<?php

namespace Mini\Core;

use Mini\Libs\Helper;
use Mini\Libs\Url;
use Mini\Libs\Viewhelper;
use Mini\Model\Genericpages;

class ParentController
{
    public $data;
    private $page;

    public function __construct()
    {
        $this->data = new \stdClass();
        $this->data->body_class = Url::get_body_class();

        $this->title = "asdf";
    }

    public function get_page()
    {
        return $this->page;
    }
}
