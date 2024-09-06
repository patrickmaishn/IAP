<?php 

//Class auto load.

function classAutoLoad($classname){
$directories = ["contents", "layouts", "meanus"];
foreach($directories AS $dir){
$filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $classname . ".php";
if(file_exists($filename) AND is_readable($filename)){
    require_once $filename;
   }
  }
}

spl_autoload_register('classAutoLoad');


require_once "layouts/layouts.php";
$ObjLayouts = new layouts();

require_once "Menus/menus.php";
$ObjMenus = new menus();

require_once "contents/headings.php";
$ObjHeadings = new headings();

/*print dirname(__FILE__);
echo "<br>";
print $_SERVER["PHP_SELF"];
echo "<br>";
print basename($_SERVER["PHP_SELF"]);
echo "<br>";
if (file_exists("index.php") AND is_readable("index.php")){
    print "yes";
}*/