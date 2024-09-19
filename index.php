<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Now you can access your .env variables
$customVar = getenv('MY_CUSTOM_VARIABLE');

    require_once "load.php";
    $ObjLayouts->heading();
    $ObjMenus->main_menu();
    $ObjLayouts->banner();
    $ObjContents->main_content();
    $ObjContents->sidebar();
    $ObjLayouts->footer();