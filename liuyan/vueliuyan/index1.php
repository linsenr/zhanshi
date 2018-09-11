<?php 
require_once "db.inc.php";
header("Content-Type:text/html;charset=utf-8");
$a=new db("localhost","root","123456","vue");
if($_GET[n]==-1){
$sql="delete from liuyan";
mysql_query($sql);
}else{
$sql="delete from liuyan where id=".$_GET[id];
mysql_query($sql);
}
 ?>
