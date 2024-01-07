<?php

// Define Vendor File Path and Include Autoload
define('VENDOR_FILE_PATH', __DIR__ . '/vendor/autoload.php');
require VENDOR_FILE_PATH;

// Load Environment Variables from .env File
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Load Environment Variables from .env.db File
$dotenvDb = Dotenv\Dotenv::createImmutable(__DIR__, '.env.db');
$dotenvDb->load();