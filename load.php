<?php

require_once "includes/constants.php";
require_once "includes/dbConnection.php";

// Class Auto Load
function ClassAutoload($ClassName){
   $directories = ["forms", "processes", "structure", "tables", "global", "store"];

   foreach($directories AS $dir){
        $FileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir .  DIRECTORY_SEPARATOR . $ClassName . '.php';
        
        if(file_exists($FileName) AND is_readable($FileName)){
         require $FileName;
        }
   }
}
spl_autoload_register('ClassAutoload');

// Creating instances of all classes
    $ObjLayouts = new layouts();
    $ObjMenus = new menus();
    $ObjContents = new contents();
    $Objforms = new forms();
    $conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);


