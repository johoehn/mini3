<?php

namespace Mini\Libs;

class Time
{
    static public function date_is_before_now($date)
    {
        if (strtotime($date) > strtotime('now')) {
            return true;
        } else {
            return false;
        }
    }
}
