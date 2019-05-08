<?php //-*- Mode: php; indent-tabs-mode: nil; -*-
namespace alex290\imagelink\lib\imagelnk;


class ImageLnk_Encode
{
    public static function sjis_to_utf8($string) {
        return @iconv("SHIFT_JIS", "UTF-8//IGNORE", $string);
    }
}
