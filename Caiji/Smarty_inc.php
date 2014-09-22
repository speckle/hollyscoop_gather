<?php

/*总结使用模板的步骤：

1、 载入模板引擎：include ‘Class/Smarty.class.php’;

2、 建立模板实例：$tpl = new Smarty();

3、 设定模板实例的属性：$tpl -> template_dir = …

4、 在程序中处理变量，再用Smarty的assign方法将变量置入模板中(Test.php)

5、 利用Smarty的Display()方法将网页显示出来(Test.php)。

*/
require_once("libs/Smarty.class.php");
$smarty = new Smarty();
$smarty -> config_dir = "./demo/configs";//目录变量
$smarty ->caching=false;
$smarty -> template_dir = "./demo/templates";     //设置模版目录
$smarty -> compile_dir =  "./demo/templates_c/";  //设置编译目录
$smarty -> cache_dir = "./demo/cache";     //缓存文件夹
$smarty->debugging = false;
$smarty -> left_delimiter = '<{';
$smarty -> right_delimiter = '}>';
?>
