<?php

// Define Vendor File Path and Include Autoload
require(__DIR__ . '/vendor/autoload.php');

// Load Environment Variables from .env File
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Load Environment Variables from .env.db File
$dotenvDb = Dotenv\Dotenv::createImmutable(__DIR__, '.env.db');
$dotenvDb->load();