<?php

// Include the autoloader (assuming you're using Composer)
require 'vendor/autoload.php';

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define constants using environment variables
define('DBTYPE', getenv('DB_TYPE'));
define('HOSTNAME', getenv('DB_HOSTNAME'));
define('DBPORT', getenv('DB_PORT'));
define('HOSTUSER', getenv('DB_USERNAME'));
define('HOSTPASS', getenv('DB_PASSWORD'));
define('DBNAME', getenv('DB_NAME'));

// Now, these constants will be populated from your .env file
