<?php

namespace Mini\Libs;

class Url
{
    static public function get_body_class()
    {
        $url = Url::get_url_parts();
        if (empty($url[0])) {
            return "start";
        }
        return implode(" ", $url) . " " . end($url) . "-page";
    }

    static public function get_slug()
    {
        $url = self::get_url_parts();
        $url = end($url);
        return $url;
    }

    static public function get_url_parts()
    {
        $url = Helper::remove_slashes_at_start_and_end(self::get_request_uri());
        return explode("/", $url);
    }

    static public function get_host()
    {
        return "https://host.de";
    }

    static public function get_last_url_part()
    {
        $parts = self::get_url_parts();
        return end($parts);
    }

    static public function get_url()
    {
        return self::get_request_uri();
    }

    static public function get_full_url()
    {
        return self::get_host() . $_SERVER["REQUEST_URI"];
    }

    static public function get_slug_of_full_url()
    {
        $slug = self::get_request_uri();
        $slug = Helper::remove_slashes_at_start_and_end($slug);
        $slug = str_replace("/", "-", $slug);
        return $slug;
    }

    static public function get_title()
    {
        return self::url_decode(self::get_last_url_part());
    }

    static public function url_decode($string)
    {
        $string = str_replace(array("-"), array(" "), $string);
        $string = ucwords($string);
        return $string;
    }

    static function escape_lodashes_in_url($url)
    {
        return str_replace("_", "-", $url);
    }

    static function get_request_uri()
    {
        return strtok($_SERVER["REQUEST_URI"], '?');
    }
}
