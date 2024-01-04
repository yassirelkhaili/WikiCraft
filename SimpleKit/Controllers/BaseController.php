<?php

namespace SimpleKit\Controllers;

class BaseController {
    protected $baseAssetPath = "../public/frontend/build/static";
    
    protected function getReactContent(string $contentDir) {
        $fullPath = $this->baseAssetPath . "/" . $contentDir;
        if (is_dir($fullPath)) {
            $staticJsFiles = scandir($fullPath);
            if (is_array($staticJsFiles)) {
                foreach ($staticJsFiles as $key => $staticFile) {
                    if (count(explode('.', $staticFile)) === 3 && substr($staticFile, 0, 4) === 'main') {
                        $fullPath .= $staticJsFiles[$key];
                    }
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
        return file_exists($fullPath) ? $fullPath : '';
    }

    protected function render(string $view, array $data = []) {
        $data = array_merge($data, ['jsurl' => $this->getReactContent("js/")], ['cssurl' => $this->getReactContent("css/")]);
        extract($data);
        include dirname(__DIR__) . "/Views/$view.php";
    }
}
