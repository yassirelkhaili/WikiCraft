<?php

namespace SimpleKit\Helpers;

class Request {
    private $data = [];

    public function __construct() {
        $this->data = $_POST; 
    }

    public function getPostData($key = null) {
        if ($key === null) {
            return $this->data;
        }

        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
