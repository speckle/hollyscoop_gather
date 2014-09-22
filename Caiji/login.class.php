<?php
include "connet_db.php";
class Login
{
	var $username; //�û���
	var $userpass; //����
	var $userid; //�û�id
	var $userlevel; //�û�����
	
	var $authtable="account"; //��֤�����ݱ�
	
	var $usecookie=true; //ʹ��cookie����sessionid
	var $cookiepath='/'; //cookie·��
	var $cookietime=108000; //cookie��Чʱ��
	
	var $err_mysql="mysql error"; //mysql������ʾ
	var $err_username="username invalid"; //�û�����Ч��ʾ
	var $err_user="user invalid"; //�û���Ч��ʾ(�����)
	var $err_password="password error"; //���������ʾ
	
	var $err; //������ʾ
	
	var $errorreport=false; //��ʾ����
	
	function __construct($host,$user,$password,$news_name){//���캯���������ݿ�
		$con=new db($host,$user,$password,$news_name); 
	}
	
	function isLoggedin() //�ж��Ƿ��¼
	{
		if(isset($_COOKIE['sid'])) //���cookie�б�����sid
		{
			session_id($_COOKIE['sid']);
			session_start();
			$this->username=$_SESSION['username'];
			$this->userid=$_SESSION['userid'];
			$this->userlevel=$_SESSION['userlevel'];
			return true;
		}
		else //���cookie��δ����sid,��ֱ�Ӽ��session
		{
			session_start();
			if(isset($_SESSION['username']))
			return true;
		}
		return false;
	}
	
	function userAuth($username,$userpass) //�û���֤
	{
		$this->username=$username;
		$this->userpass=$userpass;
		$query="select * from `".$this->authtable."` where `username`='$username';";
		$result=mysql_query($query);
		if(mysql_num_rows($result)!=0) //�ҵ����û�
		{
			$row=mysql_fetch_array($result);
			if($row['bannd']==1) //���û������
			{
				$this->errReport($this->err_user);
				$this->err=$this->err_user;
				return false;
			}
			elseif($userpass==$row['userpass']) //����ƥ��
			{
				$this->userid=$row['id'];
				$this->userlevel=$row['userlevel'];
				return true;
			}
			else //���벻ƥ��
			{
				$this->errReport($this->err_password);
				$this->err=$this->err_password;
				return false;
			}
		}
		else //û���ҵ����û�
		{
			$this->errReport($this->err_username);
			$this->err=$this->err_username;
			return false;
		}
	}
	
	function setSession() //��session
	{
		$sid=uniqid('sid'); //����sid
		session_id($sid);
		session_start();
		$_SESSION['username']=$this->username; //��session������ֵ
		$_SESSION['userid']=$this->userid; //..
		$_SESSION['userlevel']=$this->userlevel; //..
		if($this->use_cookie) //���ʹ��cookie����sid
		{
			if(!setcookie('sid',$sid,time()+$this->cookietime,$this->cookiepath))
			$this->errReport("set cookie failed");
		}
		else
		setcookie('sid','',time()-3600); //���cookie�е�sid
	}
		
	function userLogout() //�û�ע��
	{
		session_start();
		unset($_SESSION['username']); //���session�е�username
		if(setcookie('sid','',time()-3600))
		//���cookie�е�sid
		return true;
		else 
		return false;
	}
		
	function errReport($str) //����
	{
		if($this->error_report)
		echo "ERROR: $str";
	}
}
?> 


