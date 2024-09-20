<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once "load.php";

    $ObjLayouts->heading();
    $ObjMenus->main_menu();
    $ObjLayouts->banner();
    $ObjContents->main_content();
    $ObjContents->sidebar();
    $ObjLayouts->footer();