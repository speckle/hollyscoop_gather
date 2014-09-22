<?php
include"config.php";
include"connet_db.php";
$con=new db($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); //链接到数据库
$id=$_POST['id'];
$catid=$_POST['catid'];
$keyword=$_POST['keyword'];
$_SESSION['id']=$id;

$sql="select status from hollyscoop where id='$id' limit 1";
$con->query($sql);
$status=$con->result();
//如果状态是未采集,则标记为采集
if($status==0){
	$sql="update hollyscoop set catid='$catid',keyword='$keyword',status=1 where id='$id'";
	$con->query($sql);
	echo '<script charset="utf-8">alert("页面采集成功！文章已发到后台。");window.history.back();</script>';
}else{
	echo '<script charset="utf-8">alert("页面已采集！");window.history.back();</script>';
}
?>

