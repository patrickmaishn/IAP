<?php 

//Class auto load.

function classAutoLoad($classname){

$directories = ["contents", "layouts", "menus"];

foreach($directories AS $dir){
$filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $classname . ".php";
if(file_exists($filename) AND is_readable($filename)){
    require_once $filename;
   }
  }
}

spl_autoload_register('classAutoLoad');


$ObjLayouts = new layouts();
$ObjMenus = new menus();
$ObjHeadings = new headings();
$ObjCont = new contents();

require "includes/constants.php";
require "includes/dbconnection.php";

$conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);

/*print dirname(__FILE__);
echo "<br>";
print $_SERVER["PHP_SELF"];
echo "<br>";
print basename($_SERVER["PHP_SELF"]);
echo "<br>";
if (file_exists("index.php") AND is_readable("index.php")){
    print "yes";
}*/