<?php
session_start();
require_once "includes/constants.php"; // Ensure this is included first
require_once "includes/dbConnection.php";
require_once "lang/en.php";

// Class Auto Load
function ClassAutoload($ClassName) {
    $directories = ["forms", "processes", "structure", "tables", "global", "store"];

    foreach ($directories as $dir) {
        $FileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $ClassName . '.php';

        if (file_exists($FileName) && is_readable($FileName)) {
            require $FileName;
        }
    }
}
spl_autoload_register('ClassAutoload');

// Creating instances of all classes
$ObjGlob = new fncs();
$ObjLayouts = new layouts();
$ObjMenus = new menus();
$ObjContents = new contents();
$Objforms = new forms();

try{
$conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
// Instantiate the auth class
$ObjAuth = new auth();
$ObjAuth->signup($conn, $lang);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}