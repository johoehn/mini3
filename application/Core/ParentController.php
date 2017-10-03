<?php

namespace Mini\Core;
use Mini\Libs\Url;

class ParentController
{
    public $data;
    public function __construct()
    {
        $this->data = new \stdClass();
        $this->data->body_class = Url::get_body_class();
    }
}
