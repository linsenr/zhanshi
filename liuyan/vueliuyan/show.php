<?php 
require_once "db.inc.php";
header("Content-Type:text/html;charset=utf-8");
$a=new db("localhost","root","123456","vue");
$res=$a->getalldata('liuyan',MYSQL_ASSOC);
print_r(json_encode($res));
 ?>