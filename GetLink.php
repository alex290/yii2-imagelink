<?php

namespace alex290\imagelink;

use yii\helpers\Json;
use alex290\imagelink\lib\ImageLnk;

/**
 * This is just an example.
 */
class GetLink extends \yii\base\Widget
{
    public $url;

    public function run()
    {
        $r = ImageLnk::getImageInfo($this->url);
            if ($r) {
                $data['title']     = $r->getTitle();
                $data['referer']   = $r->getReferer();
                $data['backlink']  = $r->getBackLink();
                $data['imageurls'] = $r->getImageURLs();
            }
        return Json::encode($r, $asArray = true);
    }
}
