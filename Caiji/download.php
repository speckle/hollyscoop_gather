<?php
/**********************************************************
*此脚本定期自动执行，对标记为采集状态的文章进行图片下载
**********************************************************/
include"config.php";//配置文件
include"connet_db.php";//数据库连接类
include"collect.class.php";//采集类

$con=new db($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); //链接到数据库
$sql="select id,m_pic_url,content from hollyscoop where status!=0 and local_main_img=''";
$result=mysql_query($sql);
if(mysql_num_rows($result)==0){
	exit(0);
}
echo date("Y/m/d/H:i:s")."\n";
//获取数据库中的值
while($row=mysql_fetch_row($result)){
	$rowset[]=$row;   //这里rowset[0]为主图链接，rowset[1]为文章内容
}
foreach($rowset as $value){
	$p=$p='%<img src="(.*?)"/>%si'; //正则表达式
	$id=$value[0];
	/*主图下载*/
	$str=$value[1];
	preg_match_all($p,$str,$arr); //arr[0]带<img>标签，arr[1]不带<img>标签
	foreach($arr[1] as $element){
		$path=$config['img_url'].GrabImage($element,$config['img_path']);
		$str=str_replace($element,$path,$str);
	}
	$sql="update hollyscoop set local_main_img='$str' where id='$id'";
	$con->query($sql);
	/*内容下载*/
	$str=$value[2];
	preg_match_all($p,$str,$arr); //arr[0]带<img>标签，arr[1]不带<img>标签
	foreach($arr[1] as $element){
		//遍历所有图片的链接，根据链接下载图片，然后将新的本地路径加入str
		$path=$config['img_url'].GrabImage($element,$config['img_path']);
		$element='<img src="'.$element.'"/>';
		$path='<div style="text-align: center;"><img style="width:400px" src="'.$path.'"/></div>';
		$str=str_replace($element,$path,$str);
	}
	$str=addslashes($str);
	$sql="update hollyscoop set local_content='$str' where id='$id'";
	$con->query($sql);
	$phpcms=new cms($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name'],$config['db_cms_name'],$config['base_url']);
	$phpcms->publish($id);
	
	echo 'download news id='.$id.' success!'."\r\n";
	
}
function GrabImage($url,$path){ 
	if($url=="") return false; 
	if($filename=="") { 
		$ext=strrchr($url,"."); 
		if($ext!=".gif" && $ext!=".jpg" && $ext!=".png" && $ext!=".jpeg") return false; 
		$filename=date("YmdHis").rand(100,999).$ext;   //这里为了使文件名不重复,加一个100到999的随机数
		$p=$path.$filename;//存在绝对路径里面
	}
	ob_start(); 
	readfile($url); 
	$img = ob_get_contents(); 
	ob_end_clean(); 
	$size = strlen($img); 
	$fp2=fopen($p, "a"); 
	fwrite($fp2,$img); 
	fclose($fp2); 
	return $filename; //返回文件名
}

?>
