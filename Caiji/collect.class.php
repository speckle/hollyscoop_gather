<?php
/********************************************
*对标注采集的文章发送到后台
********************************************/
Class cms{
	private $db_host;
	private $db_user;
	private $db_password;
	private $news_name;
	private $cms_name;
	private $base_url;
	function __construct($host,$user,$password,$news_name,$cms_name,$base_url){
		$this->db_host=$host;
		$this->db_user=$user;
		$this->db_password=$password;
		$this->news_name=$news_name;
		$this->cms_name=$cms_name;
		$this->base_url=$base_url;
	}
	public function db_news(){
		$con_news=new db($this->db_host,$this->db_user,$this->db_password,$this->news_name); //链接到数据库
		return $con_news;
	}
	public function db_phpcms(){
		$con_cms=new db($this->db_host,$this->db_user,$this->db_password,$this->cms_name); //链接到数据库
		return $con_cms;
	}
	public function publish($id){
		$con_news=$this->db_news(); //连接news数据库
		$sql="select title,url,head,m_pic_url,local_main_img,local_content,catid,keyword from hollyscoop where id='$id'";
		$con_news->query($sql);
		$result=mysql_fetch_array($con_news->query);
		$con_news->Close();//关闭连接
		
		$systeminfo=array();
		//主表
		$systeminfo['id']=0;
		$systeminfo['catid']=$result['catid'];
		$systeminfo['typeid']=0;
		$systeminfo['title']=$result['title'];
		$systeminfo['keywords']=$result['keyword'];
		$systeminfo['description']="";
		$systeminfo['posids']=0;
		$systeminfo['url']="";
		$systeminfo['listorder']=0;
		$systeminfo['status']=99;
		$systeminfo['sysadd']=1;
		$systeminfo['islink']=0;
		$systeminfo['username']='huangqiaoxiao';
		$systeminfo['inputtime']=time();
		$systeminfo['updatetime']=time();
		$systeminfo['mobile_flag']=1;
		//附表
		$systeminfo['content']=$result['local_content'];
		$systeminfo['readpoint']=0;
		$systeminfo['paginationtype']=0;
		$systeminfo['maxcharperpage']=5000;
		$systeminfo['paytype']=0;
		$systeminfo['voteid']=0;
		$systeminfo['allow_comment']=1;
		$systeminfo['copyfrom']='Hollyscoop|0';


		//插入主表数据，不插入url链接
		$systeminfo['title']=addslashes($systeminfo['title']);
		$con_cms=$this->db_phpcms();  //连接cms数据库
		$sql="insert into v9_news(catid,typeid,title,keywords,description,posids,listorder,status,sysadd,islink,username,inputtime,updatetime,mobile_flag)values('".$systeminfo['catid']."','".$systeminfo['typeid']."','".$systeminfo['title']."','".$systeminfo['keywords']."','".$systeminfo['description']."','".$systeminfo['posids']."','".$systeminfo['listorder']."','".$systeminfo['status']."','".$systeminfo['sysadd']."','".$systeminfo['islink']."','".$systeminfo['username']."','".$systeminfo['inputtime']."','".$systeminfo['updatetime']."','".$systeminfo['mobile_flag']."')";
		$con_cms->query($sql);

		//获取id号
		$sql="select id from v9_news where inputtime='".$systeminfo['inputtime']."'";
		$con_cms->query($sql);
		$systeminfo['id']=$con_cms->result();
		
		//获取分类url
		$sql="select parentdir from `v9_category` where catid='".$systeminfo['catid']."'";
		$con_cms->query($sql);
		$html_url=$this->base_url.$con_cms->result();
		$url=$html_url.$systeminfo['id'].'.shtml';
		//生成url链接插入到主表中
		$sql="update v9_news set url='$url' where id='".$systeminfo['id']."'";
		$con_cms->query($sql);

		//插入附属表数据。
		$new_systeminfo['content']=addslashes($systeminfo['content']);
		$sql="insert into `v9_news_data`(id,content,readpoint,paginationtype,maxcharperpage,paytype,voteid,allow_comment,copyfrom)values('".$systeminfo['id']."','".$new_systeminfo['content']."','".$systeminfo['readpoint']."','".$systeminfo['paginationtype']."','".$systeminfo['maxcharperpage']."','".$systeminfo['paytype']."','".$systeminfo['voteid']."','".$systeminfo['allow_comment']."','".$systeminfo['copyfrom']."')";
		$con_cms->query($sql);
		
		//更新category表中的items中的值
		$sql="select items from `v9_category` where catid='".$systeminfo['catid']."'";
		$con_cms->query($sql);
		$items=$con_cms->result();
		$items++;
		$sql="update `v9_category` set items='$items' where catid='".$systeminfo['catid']."'";
		$con_cms->query($sql);

		//增加hits表中的数据
		$hitsid='c-1-'.$systeminfo['id'];
		$sql="insert into v9_hits (hitsid,catid,views,yesterdayviews,dayviews,weekviews,monthviews,updatetime)values('$hitsid','".$systeminfo['catid']."',0,0,0,0,0,'".$systeminfo['updatetime']."')";
		$con_cms->query($sql);
		$con_cms->Close();
		//生成静态页面
		//include("collect/index.php");
	}
}
?>
