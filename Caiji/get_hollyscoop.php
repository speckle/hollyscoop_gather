<?php
include "simplehtmldom_1_5/simple_html_dom.php";
include "config.php";
include "connet_db.php";
ini_set('memory_limit','1024M');
$con=new db($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); //链接到数据库
$url='http://www.hollyscoop.com';
$stack=array();  //数组用于队列
echo time().":connect db success..."."\r\n";

$num=0;//作为计数器
$obj=file_get_html('http://www.hollyscoop.com/news/');	
echo time().":create html_obj success..."."\n";

foreach($obj->find('span[class=title-field] a') as $element){
	//$stack[]=$element->href;
	array_unshift($stack,$element->href);  //这里是队列
}
echo time().":create title success..."."\r\n";

foreach($stack as $element){
	$html=file_get_html($url.$element);
	$title=""; 
	$c_url=$url.$element;  //原文链接
	$head="";
	$m_pic_url="";
	$contents="";
	
	//判断数据库中文章是否存在
	$sql="select count(url) from hollyscoop where url='$c_url'";
	$con->query($sql);
	$count=$con->result();
	if($count>=1){//如果存在
		continue;//跳出循环循环下一次
	}

	//抓取文章标题
	foreach($html->find('h1[id=page-title]') as $t){ 
		$title=$t->plaintext;
	}

	//获取子标题
	foreach($html->find('p[class=submitted] span') as $h){
		$head=$h->plaintext;
	}
	foreach($html->find('div[class=image-wrapper] div div div[class=field-item even] a')as $value){ //获取主图
		$main_pic='<img src="'.$value->href.'"/>';
	}
	foreach($html->find('div[id=body-content]') as $content){ //抓取主体内容框架
		foreach($content->find('p') as $p){ //抓取所有p标签
			if($p->children(0)->tag!='img'){//如果抓取的p标签内不是图片链接
				$p->plaintext=trim($p->plaintext);//去除前后空格
				if(strlen($p->plaintext)!=0&&strlen($p->plaintext)!=2){  //筛选过滤空字符串
					$p->plaintext=addslashes($p->plaintext);
					$contents.='<p>'.$p->plaintext.'</p>';
				}
			}else{
				//如果content是图片链接  就将src存进数据库
				$p->children(0)->src=addslashes($p->children(0)->src);
				$src='<img src="'.$p->children(0)->src.'"/>';
				$contents.=$src;
			}
		}
	}
	$sql="insert into hollyscoop (title,url,head,m_pic_url,content)values('$title','$c_url','$head','$main_pic','$contents')";
	$con->query($sql);
	$num++;

	$html->clear();
}
$obj->clear();
echo "collect success..."."\r\n";
echo date("Y/m/d")."\n";
echo '共更新了:'.$num.'篇文章'."\n";
echo "The end!"."\n";
?>
