<?php

namespace Mini\Libs;

class Url
{
    static public function get_body_class()
    {
        $url = Url::get_url_parts();
        if(empty($url[0])) {
            return "index start";
        }
        return implode(" ", $url) . " " . end($url) . "-page";
    }

    static public function get_slug()
    {
        $url = self::get_url_parts();
        return end($url);
    }

    static public function get_url_parts()
    {
        $url = Helper::remove_slashes_at_start_and_end($_SERVER['REQUEST_URI']);
        return explode("/", $url);
    }
}