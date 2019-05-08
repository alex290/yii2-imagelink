<?php //-*- Mode: php; indent-tabs-mode: nil; -*-
namespace alex290\imagelink\lib\imagelnk\Engine;

use alex290\imagelink\lib\imagelnk\ImageLnk_Cache;
use alex290\imagelink\lib\imagelnk\ImageLnk_Response;
use alex290\imagelink\lib\imagelnk\ImageLnk_Helper;

class ImageLnk_Engine_opengraph
{
    const LANGUAGE = null;
    const SITENAME = 'any site which has og:image';

    public static function handle($url)
    {
        $data = ImageLnk_Cache::get($url);
        $html = $data['data'];

        $response = new ImageLnk_Response();
        $response->setReferer($url);

        ImageLnk_Helper::setResponseFromOpenGraph($response, $html);

        if (empty($response->getImageURLs())) {
            return false;
        }

        return $response;
    }
}
// Do not call ImageLnk_Engine::push here for opengraph
