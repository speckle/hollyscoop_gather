<?php
$ip = getClientIp();

$iplist = array(
		'114.255.44.131',
		'114.255.44.132',
		'114.255.44.133',
		'114.255.44.134',
		'114.255.44.135',
		'192.168.133.42',
		);
if(!in_array( $ip , $iplist )){ 
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}  

function getClientIp(){
	$uip = ''; 
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$uip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$uip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$uip = $_SERVER['REMOTE_ADDR'];
	}   
	return $uip;
}   
?>

<html>
	<head>
		<title>采集用户登录</title>	
	</head>
	<body>
		<form name="form1" method="post" action="login.php">
			<table>
				<tr>
					<td>用户名：</td>
					<td><input type="text" name="user" /></td>
				</tr>
				<tr>
					<td>密码:</td>
					<td><input type="password" name="password"/></td>
				</tr>
				<tr>
					<td><input type="submit" value="登录" ></td>
				</tr>
			</table>
		</form>
	</body>
</html>
