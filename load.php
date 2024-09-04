<?php
require_once "flc.php";
$Obj = new fnc();
print dirname(__FILE__);
echo "<br>";
print $_SERVER["PHP_SELF"];
echo "<br>";
print basename($_SERVER["PHP_SELF"]);