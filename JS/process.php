<?php
if(isset($_POST['query'])){
    $res = addslashes($_POST['query']);

}else{
    $res = " ";
}
print $res;
?>