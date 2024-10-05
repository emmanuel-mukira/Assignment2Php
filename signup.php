<?php
session_start(); // Start the session to handle error messages
require_once "load.php";

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors']; // Get the error messages
    unset($_SESSION['errors']); // Clear errors after displaying
} else {
    $errors = []; // No errors
}

$ObjLayouts->heading();
$ObjMenus->main_menu();
$ObjLayouts->banner();
$Objforms->sign_up_form($errors); // Pass errors to the form
$ObjContents->sidebar();
$ObjLayouts->footer();
