<?php //-*- Mode: php; indent-tabs-mode: nil; -*-
namespace alex290\imagelink\lib\imagelnk;

use alex290\imagelink\lib\imagelnk\Engine\ImageLnk_Engine_opengraph;


class ImageLnk_Engine
{
    private static $engines_ = array();

    public static function push($classname)
    {
        self::$engines_[] = $classname;
    }

    public static function getengines()
    {
        return self::$engines_;
    }
}
