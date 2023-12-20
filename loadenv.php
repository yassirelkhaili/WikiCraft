<?php

//load .env
define('VENDOR_FILE_PATH', __DIR__ . '/vendor/autoload.php');

require VENDOR_FILE_PATH;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env.db');
$dotenv->load();