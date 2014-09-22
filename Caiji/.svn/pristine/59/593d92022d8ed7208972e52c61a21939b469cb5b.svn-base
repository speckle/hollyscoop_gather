<?php
include "config.php";
include "login.class.php";
$login=new Login($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
$login->error_report=true;
$login->cookietime=3600*24*30;
if($login->isLoggedin())
{?>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>hollyscoop news</title>
	</head>
	<frameset cols="20%,80%">
		<frame src="web.php"/>
		<frame src="hollyscoop_title.php" name="showframe"/>
	</frameset>
	</html>
<?php
}
elseif($login->userAuth($_POST['user'],$_POST['password']))
{?>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>hollyscoop news</title>
	</head>
	<frameset cols="20%,80%">
		<frame src="web.php"/>
		<frame src="hollyscoop_title.php" name="showframe"/>
	</frameset>
	</html>
<?php
	$login->setSession();
}
echo "<p>...</p>";
?>