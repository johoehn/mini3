<?php

namespace Mini\Libs;

class Viewhelper
{
    public static function view_exists($view)
    {
        if (file_exists(APP . $view)) {
            return true;
        } else {
            return false;
        }
    }

    public static function render_view($view, $data = "")
    {
        if (self::view_exists($view)) {
            require APP . $view;
        } else {
            self::render_error_page();
        }
    }

    public static function render_title_tag()
    {
        return "<title>" . Url::get_title() . "</title>";
    }

    public static function render_description_tag($page)
    {
        if (!empty($page->description)) {
            return '<meta name="description" content="' . $page->description . '">';
        }
    }

    public static function render_keywords_tag($page)
    {
        if (!empty($page->keywords)) {
            return '<meta name="keywords" content="' . $page->keywords . '">';
        }
    }

    public static function render_amp_tag($page)
    {
        if (Url::is_product_page() && sizeof(Url::get_url_parts()) > 3) {
            return '<link rel="amphtml" href="' . Url::get_full_url() . '/amp">';
        }
    }

    public static function render_error_page()
    {
        Helper::log("404");
        header("HTTP/1.0 404 Not Found");
        $url = \Mini\Libs\Url::get_host() . "/error";
        echo file_get_contents($url);
        exit();
    }

    public static function main_menu_li_active($link)
    {
        $url = Url::get_url();
        if (Helper::startsWith($url, $link)) {
            return "active";
        }
    }

    public static function render_embedded_page()
    {
        if (isset($_GET['embed'])) {
            return true;
        } else {
            return false;
        }
    }
}
