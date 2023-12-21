<?php

namespace SimpleKit;

class Controller {
    protected function render(string $view, array $data = []) {
        extract($data);

        include_once dirname(__DIR__) . "/Views/$view";
    }
}