<?php
require_once "layouts/layouts.php";
$ObjLayouts = new layouts();

require_once "Menus/menus.php";
$ObjMenus = new menus();

/*print dirname(__FILE__);
echo "<br>";
print $_SERVER["PHP_SELF"];
echo "<br>";
print basename($_SERVER["PHP_SELF"]);
echo "<br>";
if (file_exists("index.php") AND is_readable("index.php")){
    print "yes";
}*/