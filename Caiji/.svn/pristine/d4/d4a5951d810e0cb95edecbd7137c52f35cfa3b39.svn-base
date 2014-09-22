<?php
include"config.php";
include"connet_db.php";
$con=new db($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); //链接到数据库
$page_size=30;

//获取当前页数
if(isset($_GET['page'])){
	$page=intval($_GET['page']);
}else{
	$page=1;
}
//获取总数据量
$sql="select id from `hollyscoop` order by id desc limit 1";
$result=mysql_query($sql);
$row=mysql_fetch_row($result);
$amount=$row[0];
//计算总共有多少页
if($amount){
	if($amount<$page_size){
		$page_count=1;
	}
	if($amount % $page_size){
		$page_count=(int)($amount/$page_size)+1;
	}else{
		$page_count=$amount/$page_size;
	}
}else{
	$page_count=0;
}

$page_string = '';

if( $page == 1 ){
   $page_string .= '第一页|上一页|';
}
else{
   $page_string .= '<a href=?page=1>第一页</a>|<a href=?page='.($page-1).'>上一页</a>|';
} 
if( ($page == $page_count) || ($page_count == 0) ){
   $page_string .= '下一页|尾页';
}
else{
   $page_string .= '<a href=?page='.($page+1).'>下一页</a>|<a href=?page='.$page_count.'>尾页</a>';
}
// 获取数据，以二维数组格式返回结果
if( $amount ){
   $sql = "select id,title,status from `hollyscoop` order by id desc limit ". ($page-1)*$page_size .", $page_size";
   $result = mysql_query($sql);
   while ( $row = mysql_fetch_row($result) ){
       $rowset[] = $row;
   }
}else{
   $rowset = array();
}
?>


<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<ul>
			<?php
				//var_dump($rowset);
				foreach($rowset as $key=>$row){
			?>
						<li>
							<a href="single_h.php?id=<?php echo $row[0];?>&page=<?php echo $page;?>">
								<?php 
									echo '('.($key+1).')&nbsp&nbsp&nbsp'.$row[1];
									if($row[2]==0){
										echo "（未采集）";
									}else echo "（已采集）";
								?>
							</a>
						</li>
			<?php	
				}
			?>
		</ul>
		<?php echo $page_string;?>
	</body>
</html>