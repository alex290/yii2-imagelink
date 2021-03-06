<?php //-*- Mode: php; indent-tabs-mode: nil; -*-

namespace alex290\imagelink\lib;

use alex290\imagelink\lib\imagelnk\ImageLnkURL;
use alex290\imagelink\lib\imagelnk\ImageLnk_Engine;
use alex290\imagelink\lib\imagelnk\ImageLnk_Config;


// ------------------------------------------------------------
function ImageLnk_autoload($className)
{
    $replaces = array(
        '_' => DIRECTORY_SEPARATOR,
        '::' => DIRECTORY_SEPARATOR,
        '.' => '',
    );
    $classPath = str_replace(array_keys($replaces), array_values($replaces), $className);
    $fileName = join(
        DIRECTORY_SEPARATOR,
        array(dirname(__FILE__), $classPath . '.php')
    );

    if (is_file($fileName)) {
        include_once $fileName;
    }
}
spl_autoload_register('alex290\imagelink\lib\ImageLnk_autoload');

// ------------------------------------------------------------
ImageLnk_Config::static_initialize();

// ------------------------------------------------------------
foreach (glob(sprintf('%s/ImageLnk/Engine/*.php', dirname(__FILE__))) as $file) {
    include_once $file;
}
ImageLnk_Engine::push('alex290\imagelink\lib\imagelnk\Engine\ImageLnk_Engine_opengraph');

// ------------------------------------------------------------
class ImageLnk
{
    public static function getImageInfo($url)
    {
        $url = ImageLnkURL::getRedirectedURL($url);
        foreach (ImageLnk_Engine::getEngines() as $classname) {
            try {
                $response = $classname::handle($url);
                if ($response !== false) {
                    return $response;
                }
            } catch (Exception $e) {
                error_log('getImageInfo got Exception: ' . $e->getMessage());
                error_log($e->getTraceAsString());
            }
        }
        return false;
    }

    public static function getSites()
    {
        $sites_generic = array();
        $sites_domestic = array();
        foreach (ImageLnk_Engine::getEngines() as $classname) {
            if (!$classname::SITENAME) {
                continue;
            }

            if ($classname::LANGUAGE) {
                $sites_domestic[] = $classname::SITENAME;
            } else {
                $sites_generic[] = $classname::SITENAME;
            }
        }
        sort($sites_generic);
        sort($sites_domestic);
        return array_merge($sites_generic, $sites_domestic);
    }
}
