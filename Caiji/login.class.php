<?php
include "connet_db.php";
class Login
{
	var $username; //用户名
	var $userpass; //密码
	var $userid; //用户id
	var $userlevel; //用户级别
	
	var $authtable="account"; //验证用数据表
	
	var $usecookie=true; //使用cookie保存sessionid
	var $cookiepath='/'; //cookie路径
	var $cookietime=108000; //cookie有效时间
	
	var $err_mysql="mysql error"; //mysql出错提示
	var $err_username="username invalid"; //用户名无效提示
	var $err_user="user invalid"; //用户无效提示(被封禁)
	var $err_password="password error"; //密码错误提示
	
	var $err; //出错提示
	
	var $errorreport=false; //显示错误
	
	function __construct($host,$user,$password,$news_name){//构造函数连接数据库
		$con=new db($host,$user,$password,$news_name); 
	}
	
	function isLoggedin() //判断是否登录
	{
		if(isset($_COOKIE['sid'])) //如果cookie中保存有sid
		{
			session_id($_COOKIE['sid']);
			session_start();
			$this->username=$_SESSION['username'];
			$this->userid=$_SESSION['userid'];
			$this->userlevel=$_SESSION['userlevel'];
			return true;
		}
		else //如果cookie中未保存sid,则直接检查session
		{
			session_start();
			if(isset($_SESSION['username']))
			return true;
		}
		return false;
	}
	
	function userAuth($username,$userpass) //用户认证
	{
		$this->username=$username;
		$this->userpass=$userpass;
		$query="select * from `".$this->authtable."` where `username`='$username';";
		$result=mysql_query($query);
		if(mysql_num_rows($result)!=0) //找到此用户
		{
			$row=mysql_fetch_array($result);
			if($row['bannd']==1) //此用户被封禁
			{
				$this->errReport($this->err_user);
				$this->err=$this->err_user;
				return false;
			}
			elseif($userpass==$row['userpass']) //密码匹配
			{
				$this->userid=$row['id'];
				$this->userlevel=$row['userlevel'];
				return true;
			}
			else //密码不匹配
			{
				$this->errReport($this->err_password);
				$this->err=$this->err_password;
				return false;
			}
		}
		else //没有找到此用户
		{
			$this->errReport($this->err_username);
			$this->err=$this->err_username;
			return false;
		}
	}
	
	function setSession() //置session
	{
		$sid=uniqid('sid'); //生成sid
		session_id($sid);
		session_start();
		$_SESSION['username']=$this->username; //给session变量赋值
		$_SESSION['userid']=$this->userid; //..
		$_SESSION['userlevel']=$this->userlevel; //..
		if($this->use_cookie) //如果使用cookie保存sid
		{
			if(!setcookie('sid',$sid,time()+$this->cookietime,$this->cookiepath))
			$this->errReport("set cookie failed");
		}
		else
		setcookie('sid','',time()-3600); //清除cookie中的sid
	}
		
	function userLogout() //用户注销
	{
		session_start();
		unset($_SESSION['username']); //清除session中的username
		if(setcookie('sid','',time()-3600))
		//清除cookie中的sid
		return true;
		else 
		return false;
	}
		
	function errReport($str) //报错
	{
		if($this->error_report)
		echo "ERROR: $str";
	}
}
?> 


