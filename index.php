<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>GITTY</h1>
<?php
require "load.php";
$ObjLayouts->heading();
$ObjMenus->main_menu();
?>
    <?php
     require_once "load.php";
     print $Obj->user_age("Patrick", 1964);
     echo "<br>";
     print $Obj-> computer_user("Maina");
    ?>
    <p>Learning this</p>
</body>
</html>