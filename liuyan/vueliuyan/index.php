<?php 
// echo $_GET['username'];
// exit;
require_once "db.inc.php";
header("Content-Type:text/html;charset=utf-8");
$a=new db("localhost","root","123456","vue");
// $a->insert("liuyan",$_GET,'index.html');
$sql1="insert into liuyan(username,age) values('$_GET[username]','$_GET[age]')";
mysql_query($sql1);
$sql="select * from liuyan order by id asc";
$query=mysql_query($sql);

while($res=mysql_fetch_assoc($query))
{
	$arr[]=$res;
}

echo json_encode($arr);
// print_r(json_encode($res));
?>