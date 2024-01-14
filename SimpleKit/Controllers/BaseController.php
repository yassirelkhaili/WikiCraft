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

    private function generateCsrfToken () {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function render(string $view, array $data = [], string $title = '') {
        $title = $title ?: $_ENV["APP_NAME"];
        $data = array_merge($data, ['jsurl' => $this->getReactContent("js/")], ['cssurl' => $this->getReactContent("css/")], ['pageTitle' => $title]);
        extract($data);
        include dirname(__DIR__) . "/Views/layouts/header.php";
        include dirname(__DIR__) . "/Views/$view.php";
        include dirname(__DIR__) . "/Views/layouts/footer.php";
    }
}