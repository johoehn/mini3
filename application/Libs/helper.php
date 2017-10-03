<?php

namespace Mini\Libs;

class Helper
{
    static public function p($obj)
    {
        echo "<pre>";
        echo $obj;
        echo "</pre>";
    }
    static public function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    static public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
    static public function hide_email($email)
    {
        $output = "";
        for ($i = 0; $i < strlen($email); $i++) { $output .= '&#'.ord($email[$i]).';'; }
        return $output;
    }
    static public function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    function remove_slashes_at_start_and_end($string) {
        if($this->startsWith($string, "/")) {
            $string = substr($string, 1);
        }
        if($this->endsWith($string, "/")) {
            $string = substr($string, 0, -1);
        }
        return $string;
    }
}