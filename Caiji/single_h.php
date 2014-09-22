<?php
include"config.php";
include"connet_db.php";
$con=new db($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); //链接到数据库

$title="";
$head="";
$url="";
$main_pic="";
$status=0;//初始化状态为未采集
$content="";

if(isset($_GET['id'])&&isset($_GET['page'])){
	$id=intval($_GET['id']);
	$page=intval($_GET['page']);
}
$sql="select title,url,head,m_pic_url,content,local_main_img,local_content from `hollyscoop` where id='$id'";
$result=mysql_query($sql);
while ( $row = mysql_fetch_row($result) ){
	$rowset[] = $row;
}
foreach($rowset as $row){
	$title=$row[0];
	$url=$row[1];
	$head=$row[2];
	$main_pic=$row[3];
	$content=$row[4];
	if($row[5]==''){
		$status=0;  //未采集
	}else{
		$status=1; //采集了
	}
	$local_url=$row[7]; 
}
?>


<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style>
			.image p img,img{
				width:400px;
			}
		</style>
		<script>
			function check(){
				var catid=form1.catid.value;
				var keyword=form1.keyword.value;
				if(catid==0){
					alert("请选择分类。");
					form1.catid.focus();
					return false;
				}
				if(keyword==''){
					alert("未输入关键词。");
					form1.keyword.focus();
					return false;
				}
			}
		</script>
	</head>
<body>
	<h2><?php echo $title?></h2>
	<p>
	<?php echo $head?>&nbsp&nbsp&nbsp&nbsp&nbsp
	<a href="<?php echo $url ?>">[原文链接]</a>&nbsp&nbsp&nbsp
	<!--<a href="<?php echo $local_url ?>"><?php if($status==1) echo "[静态模板]"?></a>&nbsp&nbsp&nbsp<br/>-->
	<form name="form1" method="post" action="collect.php">
		<table>
			<tr>
				<td>栏目分类</td>
				<td>
					<select name="catid"><option value="0">请选择</option><optgroup label=" iciba英语沙龙"></optgroup><optgroup label="&nbsp;├ 独家"></optgroup><option value="427">&nbsp;│&nbsp;├ 人物</option>;<option value="428">&nbsp;│&nbsp;├ 专题</option>;<optgroup label="&nbsp;│&nbsp;└ 专栏"></optgroup><option value="433">&nbsp;│&nbsp;&nbsp;├ 亦心</option>;<option value="434">&nbsp;│&nbsp;&nbsp;├ 张征</option>;<option value="435">&nbsp;│&nbsp;&nbsp;├ brad</option>;<option value="436">&nbsp;│&nbsp;&nbsp;├ judyzhang</option>;<option value="437">&nbsp;│&nbsp;&nbsp;├ Mark</option>;<option value="438">&nbsp;│&nbsp;&nbsp;├ 纪玉华</option>;<option value="439">&nbsp;│&nbsp;&nbsp;├ 小歌</option>;<optgroup label="&nbsp;│&nbsp;&nbsp;└ 李治专栏"></optgroup><option value="497">&nbsp;│&nbsp;&nbsp;&nbsp;├ 栗子日志</option>;<option value="498">&nbsp;│&nbsp;&nbsp;&nbsp;├ MBA直播</option>;<option value="499">&nbsp;│&nbsp;&nbsp;&nbsp;├ Eng栗师</option>;<option value="500">&nbsp;│&nbsp;&nbsp;&nbsp;└ 栗栗在目</option>;<optgroup label="&nbsp;├ 乐活"></optgroup><option value="409">&nbsp;│&nbsp;├ 旅游</option>;<option value="410">&nbsp;│&nbsp;├ 美食</option>;<option value="411">&nbsp;│&nbsp;└ 时尚</option>;<optgroup label="&nbsp;├ 娱乐"></optgroup><option value="424">&nbsp;│&nbsp;├ 电影</option>;<option value="425">&nbsp;│&nbsp;├ 美剧</option>;<option value="426">&nbsp;│&nbsp;├ 音乐</option>;<option value="479">&nbsp;│&nbsp;└ 漫画</option>;<optgroup label="&nbsp;├ 科技"></optgroup><option value="421">&nbsp;│&nbsp;├ app</option>;<option value="422">&nbsp;│&nbsp;├ 创新</option>;<option value="423">&nbsp;│&nbsp;└ 数码</option>;<optgroup label="&nbsp;├ 职场"></optgroup><option value="42">&nbsp;│&nbsp;├ 职场口语</option>;<option value="135">&nbsp;│&nbsp;├ 职场资讯</option>;<optgroup label="&nbsp;│&nbsp;├ 职场预备营"></optgroup><option value="146">&nbsp;│&nbsp;│&nbsp;├ 求职测评</option>;<option value="147">&nbsp;│&nbsp;│&nbsp;├ 职业选择</option>;<option value="148">&nbsp;│&nbsp;│&nbsp;├ 求职心态</option>;<option value="149">&nbsp;│&nbsp;│&nbsp;├ 求职技巧</option>;<option value="151">&nbsp;│&nbsp;│&nbsp;├ 求职信函</option>;<option value="152">&nbsp;│&nbsp;│&nbsp;└ 求职面试</option>;<optgroup label="&nbsp;│&nbsp;├ 职场菜鸟"></optgroup><option value="155">&nbsp;│&nbsp;│&nbsp;├ 初入职场</option>;<option value="156">&nbsp;│&nbsp;│&nbsp;├ 职场礼仪</option>;<option value="157">&nbsp;│&nbsp;│&nbsp;├ 职场口语</option>;<option value="158">&nbsp;│&nbsp;│&nbsp;├ 职场写作</option>;<option value="159">&nbsp;│&nbsp;│&nbsp;├ 行业英语</option>;<option value="160">&nbsp;│&nbsp;│&nbsp;├ 职场法则</option>;<option value="161">&nbsp;│&nbsp;│&nbsp;└ 职场趣谈</option>;<optgroup label="&nbsp;│&nbsp;└ 职场达人"></optgroup><option value="164">&nbsp;│&nbsp;&nbsp;├ 职场生存</option>;<option value="165">&nbsp;│&nbsp;&nbsp;├ 晋升加薪</option>;<option value="166">&nbsp;│&nbsp;&nbsp;├ 离职跳槽</option>;<option value="167">&nbsp;│&nbsp;&nbsp;└ 学做老板</option>;<optgroup label="&nbsp;├ 悦读"></optgroup><option value="37">&nbsp;│&nbsp;├ 双语资讯</option>;<option value="38">&nbsp;│&nbsp;├ 英语点津</option>;<option value="39">&nbsp;│&nbsp;├ 双语美文</option>;<optgroup label="&nbsp;│&nbsp;├ 名著连载"></optgroup><option value="334">&nbsp;│&nbsp;│&nbsp;├ 夏洛的网</option>;<option value="335">&nbsp;│&nbsp;│&nbsp;├ 沉思录</option>;<option value="336">&nbsp;│&nbsp;│&nbsp;├ 傲慢与偏见</option>;<option value="337">&nbsp;│&nbsp;│&nbsp;├ 德伯家的苔丝</option>;<option value="338">&nbsp;│&nbsp;│&nbsp;├ 红字</option>;<option value="339">&nbsp;│&nbsp;│&nbsp;├ 爱丽丝梦游仙境</option>;<option value="340">&nbsp;│&nbsp;│&nbsp;├ 呼啸山庄</option>;<option value="341">&nbsp;│&nbsp;│&nbsp;└ 英国文化</option>;<option value="407">&nbsp;│&nbsp;├ 文化</option>;<option value="408">&nbsp;│&nbsp;├ 趣闻</option>;<option value="420">&nbsp;│&nbsp;└ 漫画</option>;<optgroup label="&nbsp;├ 学习"></optgroup><optgroup label="&nbsp;│&nbsp;├ 英语词汇"></optgroup><option value="134">&nbsp;│&nbsp;│&nbsp;├ 同义词辨析</option>;<option value="392">&nbsp;│&nbsp;│&nbsp;├ 形近词辨析</option>;<option value="487">&nbsp;│&nbsp;│&nbsp;└ 词海拾贝</option>;<option value="143">&nbsp;│&nbsp;├ 英语语法</option>;<optgroup label="&nbsp;│&nbsp;├ 口语"></optgroup><option value="43">&nbsp;│&nbsp;│&nbsp;├ 日常口语</option>;<option value="46">&nbsp;│&nbsp;│&nbsp;├ 英文演讲</option>;<option value="447">&nbsp;│&nbsp;│&nbsp;├ 口语资料</option>;<option value="441">&nbsp;│&nbsp;│&nbsp;├ 日常口语900句</option>;<option value="442">&nbsp;│&nbsp;│&nbsp;├ 口语常见错误</option>;<option value="458">&nbsp;│&nbsp;│&nbsp;├ 俚语口头禅</option>;<option value="472">&nbsp;│&nbsp;│&nbsp;├ 听歌学英语</option>;<option value="473">&nbsp;│&nbsp;│&nbsp;├ 每日一招学英语</option>;<optgroup label="&nbsp;│&nbsp;│&nbsp;└ 品牌口语"></optgroup><option value="440">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 美语咖啡屋</option>;<option value="443">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 小笨霖英语笔记</option>;<option value="454">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 色拉英语乐园学口语</option>;<option value="455">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 酒店口语900句</option>;<option value="456">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 戴尔英语红宝书</option>;<option value="457">&nbsp;│&nbsp;│&nbsp;&nbsp;├ ABC潘玮柏教学地道日常口语</option>;<option value="459">&nbsp;│&nbsp;│&nbsp;&nbsp;├ Eztalk美语</option>;<option value="469">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 英伦广角</option>;<option value="471">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 白领的一天</option>;<option value="474">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 美国习惯用语</option>;<option value="480">&nbsp;│&nbsp;│&nbsp;&nbsp;├ 最in导购口语</option>;<option value="481">&nbsp;│&nbsp;│&nbsp;&nbsp;└ 英语场景口语</option>;<optgroup label="&nbsp;│&nbsp;├ 听力"></optgroup><option value="45">&nbsp;│&nbsp;│&nbsp;├ 基础听力</option>;<optgroup label="&nbsp;│&nbsp;│&nbsp;├ 品牌听力"></optgroup><option value="489">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 用耳朵背短语</option>;<option value="490">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 躺着就能背单词</option>;<option value="491">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 常春藤解析英语</option>;<option value="492">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 洪恩环境英语</option>;<option value="493">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ Faith英语电台</option>;<option value="494">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 安徒生童话故事</option>;<option value="495">&nbsp;│&nbsp;│&nbsp;│&nbsp;└ 新概念优美背诵短文</option>;<option value="48">&nbsp;│&nbsp;│&nbsp;├ 美文听力</option>;<option value="49">&nbsp;│&nbsp;│&nbsp;├ 考试听力</option>;<optgroup label="&nbsp;│&nbsp;│&nbsp;├ VOA听力"></optgroup><optgroup label="&nbsp;│&nbsp;│&nbsp;│&nbsp;├ VOA慢速英语"></optgroup><option value="501">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 时事新闻</option>;<option value="502">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 今日美国</option>;<option value="503">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 词汇故事</option>;<option value="504">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 科技报道</option>;<option value="505">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 健康报道</option>;<option value="506">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 教育报道</option>;<option value="507">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;├ 经济报道</option>;<option value="508">&nbsp;│&nbsp;│&nbsp;│&nbsp;│&nbsp;└ 农业报道</option>;<option value="171">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ VOA标准英语</option>;<option value="172">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ VOA每日学一词</option>;<option value="173">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ VOA流行美语</option>;<option value="174">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ VOA美国习惯用语 </option>;<option value="175">&nbsp;│&nbsp;│&nbsp;│&nbsp;├ VOA单词大师</option>;<option value="176">&nbsp;│&nbsp;│&nbsp;│&nbsp;└ VOA美语咖啡屋</option>;<option value="391">&nbsp;│&nbsp;│&nbsp;├ 听力资讯</option>;<option value="463">&nbsp;│&nbsp;│&nbsp;├ 听故事练听力</option>;<option value="467">&nbsp;│&nbsp;│&nbsp;├ 视频讲词</option>;<option value="468">&nbsp;│&nbsp;│&nbsp;├ CRI电台</option>;<option value="476">&nbsp;│&nbsp;│&nbsp;├ 听力文摘</option>;<option value="483">&nbsp;│&nbsp;│&nbsp;└ 听笑话学英语</option>;<optgroup label="&nbsp;│&nbsp;└ 写作"></optgroup><option value="448">&nbsp;│&nbsp;&nbsp;├ GRE写作</option>;<option value="449">&nbsp;│&nbsp;&nbsp;├ 雅思写作</option>;<option value="451">&nbsp;│&nbsp;&nbsp;├ 托福写作</option>;<option value="452">&nbsp;│&nbsp;&nbsp;├ 六级写作</option>;<option value="453">&nbsp;│&nbsp;&nbsp;└ 四级作文</option>;<optgroup label="&nbsp;└ 考试"></optgroup><optgroup label="&nbsp;&nbsp;├ 雅思考试"></optgroup><option value="228">&nbsp;&nbsp;│&nbsp;├ 雅思资讯</option>;<optgroup label="&nbsp;&nbsp;│&nbsp;├ 雅思辅导"></optgroup><option value="264">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 口语</option>;<option value="267">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 词汇</option>;<option value="270">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 预测</option>;<option value="271">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 名师辅导</option>;<option value="272">&nbsp;&nbsp;│&nbsp;│&nbsp;└ 历年真题</option>;<option value="231">&nbsp;&nbsp;│&nbsp;├ 网友分享</option>;<option value="232">&nbsp;&nbsp;│&nbsp;└ 高分学员</option>;<optgroup label="&nbsp;&nbsp;├ 托福考试"></optgroup><optgroup label="&nbsp;&nbsp;│&nbsp;├ 托福资讯"></optgroup><option value="221">&nbsp;&nbsp;│&nbsp;│&nbsp;└ 考试动态</option>;<optgroup label="&nbsp;&nbsp;│&nbsp;└ 托福辅导"></optgroup><option value="251">&nbsp;&nbsp;│&nbsp;&nbsp;├ 口语</option>;<option value="252">&nbsp;&nbsp;│&nbsp;&nbsp;├ 听力</option>;<option value="253">&nbsp;&nbsp;│&nbsp;&nbsp;├ 阅读</option>;<option value="254">&nbsp;&nbsp;│&nbsp;&nbsp;├ 词汇</option>;<option value="259">&nbsp;&nbsp;│&nbsp;&nbsp;├ 名师指导</option>;<option value="260">&nbsp;&nbsp;│&nbsp;&nbsp;└ 历年真题</option>;<option value="51">&nbsp;&nbsp;├ 高考英语</option>;<option value="52">&nbsp;&nbsp;├ 职称英语</option>;<optgroup label="&nbsp;&nbsp;├ CET"></optgroup><option value="137">&nbsp;&nbsp;│&nbsp;├ 四六级写作</option>;<option value="138">&nbsp;&nbsp;│&nbsp;├ 四六级阅读</option>;<option value="139">&nbsp;&nbsp;│&nbsp;├ 四六级听力</option>;<option value="140">&nbsp;&nbsp;│&nbsp;├ 四六级综合</option>;<option value="141">&nbsp;&nbsp;│&nbsp;├ 四六级历年真题</option>;<option value="241">&nbsp;&nbsp;│&nbsp;├ 四级资讯</option>;<optgroup label="&nbsp;&nbsp;│&nbsp;├ 四级名师辅导"></optgroup><option value="298">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 综合辅导</option>;<option value="302">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 完形</option>;<option value="303">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 作文</option>;<option value="306">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 词汇</option>;<option value="307">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 阅读</option>;<option value="308">&nbsp;&nbsp;│&nbsp;│&nbsp;└ 听力</option>;<option value="245">&nbsp;&nbsp;│&nbsp;├ 六级资讯</option>;<optgroup label="&nbsp;&nbsp;│&nbsp;├ 六级名师辅导"></optgroup><option value="321">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 词汇</option>;<option value="324">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 阅读</option>;<option value="325">&nbsp;&nbsp;│&nbsp;│&nbsp;└ 听力</option>;<optgroup label="&nbsp;&nbsp;│&nbsp;├ 六级试题"></optgroup><option value="326">&nbsp;&nbsp;│&nbsp;│&nbsp;└ 历年真题</option>;<option value="248">&nbsp;&nbsp;│&nbsp;└ 备考交流</option>;<option value="431">&nbsp;&nbsp;├ BEC</option>;<optgroup label="&nbsp;&nbsp;├ 考研"></optgroup><option value="249">&nbsp;&nbsp;│&nbsp;├ 考研英语专栏 </option>;<option value="250">&nbsp;&nbsp;│&nbsp;└ 考研英语备考 </option>;<optgroup label="&nbsp;&nbsp;├ GRE"></optgroup><optgroup label="&nbsp;&nbsp;│&nbsp;├ GRE资讯"></optgroup><option value="274">&nbsp;&nbsp;│&nbsp;│&nbsp;└ 考试动态</option>;<optgroup label="&nbsp;&nbsp;│&nbsp;├ GRE辅导"></optgroup><option value="277">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 词汇</option>;<option value="278">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 阅读</option>;<option value="282">&nbsp;&nbsp;│&nbsp;│&nbsp;├ 名师辅导</option>;<option value="283">&nbsp;&nbsp;│&nbsp;│&nbsp;└ 历年真题</option>;<option value="236">&nbsp;&nbsp;│&nbsp;└ 考生故事</option>;<optgroup label="&nbsp;&nbsp;└ GMAT"></optgroup><optgroup label="&nbsp;&nbsp;&nbsp;├ GMAT辅导"></optgroup><option value="292">&nbsp;&nbsp;&nbsp;│&nbsp;└ 名师指导</option>;<option value="240">&nbsp;&nbsp;&nbsp;└ 考生故事</option>;<optgroup label=" 英语学习频道"></optgroup><optgroup label="&nbsp;├ 英语口语"></optgroup><option value="41">&nbsp;│&nbsp;├ 口语资料</option>;<option value="351">&nbsp;│&nbsp;└ 口语常见错误</option>;<optgroup label="&nbsp;├ 英语听力"></optgroup><option value="144">&nbsp;│&nbsp;├ CRI电台</option>;<option value="168">&nbsp;│&nbsp;├ Faith英语电台</option>;<option value="394">&nbsp;│&nbsp;└ 视频讲词</option>;<optgroup label="&nbsp;├ 双语阅读"></optgroup><option value="393">&nbsp;│&nbsp;├ 图文悦读</option>;<option value="395">&nbsp;│&nbsp;└ 英语漫画</option>;<optgroup label="&nbsp;├ 考试英语"></optgroup><option value="32">&nbsp;│&nbsp;├ 四六级</option>;<option value="33">&nbsp;│&nbsp;├ 考研英语</option>;<option value="36">&nbsp;│&nbsp;├ GRE考试</option>;<option value="50">&nbsp;│&nbsp;├ GMAT考试</option>;<option value="477">&nbsp;│&nbsp;└ catti</option>;<optgroup label="&nbsp;├ 出国留学"></optgroup><optgroup label="&nbsp;│&nbsp;├ 美国留学"></optgroup><option value="77">&nbsp;│&nbsp;│&nbsp;├ 留学资讯</option>;<option value="78">&nbsp;│&nbsp;│&nbsp;├ 院校推荐</option>;<option value="79">&nbsp;│&nbsp;│&nbsp;├ 留学签证</option>;<option value="80">&nbsp;│&nbsp;│&nbsp;└ 成功案例</option>;<optgroup label="&nbsp;│&nbsp;├ 英国留学"></optgroup><option value="81">&nbsp;│&nbsp;│&nbsp;├ 留学资讯</option>;<option value="82">&nbsp;│&nbsp;│&nbsp;├ 院校推荐</option>;<option value="83">&nbsp;│&nbsp;│&nbsp;├ 留学签证</option>;<option value="84">&nbsp;│&nbsp;│&nbsp;└ 成功案例</option>;<optgroup label="&nbsp;│&nbsp;├ 加拿大留学"></optgroup><option value="85">&nbsp;│&nbsp;│&nbsp;├ 留学资讯</option>;<option value="86">&nbsp;│&nbsp;│&nbsp;├ 院校推荐</option>;<option value="87">&nbsp;│&nbsp;│&nbsp;├ 留学签证</option>;<option value="88">&nbsp;│&nbsp;│&nbsp;└ 成功案例</option>;<optgroup label="&nbsp;│&nbsp;├ 澳大利亚留学"></optgroup><option value="89">&nbsp;│&nbsp;│&nbsp;├ 留学资讯</option>;<option value="90">&nbsp;│&nbsp;│&nbsp;├ 院校推荐</option>;<option value="91">&nbsp;│&nbsp;│&nbsp;├ 成功案例</option>;<option value="92">&nbsp;│&nbsp;│&nbsp;└ 留学签证</option>;<option value="329">&nbsp;│&nbsp;└ 国外知名报刊</option>;<optgroup label="&nbsp;├ 写作指南"></optgroup><option value="388">&nbsp;│&nbsp;├ 求职简历</option>;<option value="389">&nbsp;│&nbsp;└ 考试作文</option>;<optgroup label="&nbsp;├ 综合资讯"></optgroup><option value="55">&nbsp;│&nbsp;├ 综合资讯</option>;<option value="56">&nbsp;│&nbsp;├ 词霸资讯</option>;<option value="193">&nbsp;│&nbsp;└ 词霸产品动态</option>;<optgroup label="&nbsp;├ 专题英语"></optgroup><option value="58">&nbsp;│&nbsp;├ 奥运英语</option>;<option value="59">&nbsp;│&nbsp;└ 世博英语</option>;<optgroup label="&nbsp;├ 职场点睛"></optgroup><option value="208">&nbsp;│&nbsp;└ 职场攻略打包</option>;<option value="133">&nbsp;├ 基础英语</option>;<optgroup label="&nbsp;├ 新东方英语考试"></optgroup><optgroup label="&nbsp;│&nbsp;├ 托福"></optgroup><option value="219">&nbsp;│&nbsp;│&nbsp;├ 初中托福考试</option>;<option value="225">&nbsp;│&nbsp;│&nbsp;├ 特别推荐</option>;<option value="226">&nbsp;│&nbsp;│&nbsp;├ 网友分享</option>;<option value="227">&nbsp;│&nbsp;│&nbsp;└ 考生故事</option>;<option value="213">&nbsp;│&nbsp;├ 雅思</option>;<option value="214">&nbsp;│&nbsp;├ GRE</option>;<option value="215">&nbsp;│&nbsp;├ GMAT</option>;<option value="216">&nbsp;│&nbsp;├ 四级</option>;<option value="217">&nbsp;│&nbsp;├ 六级</option>;<option value="218">&nbsp;│&nbsp;└ 考研英语</option>;<optgroup label="&nbsp;├ 英孚教育"></optgroup><option value="344">&nbsp;│&nbsp;├ todayblog</option>;<option value="345">&nbsp;│&nbsp;├ Reading</option>;<option value="346">&nbsp;│&nbsp;├ Business</option>;<option value="347">&nbsp;│&nbsp;├ LifeStyle</option>;<option value="348">&nbsp;│&nbsp;├ Practical</option>;<option value="349">&nbsp;│&nbsp;└ Industry</option>;<option value="478">&nbsp;└ 漫画频道</option>;<option value="1"> 公共(section)</option>;</select>
				</td>
			</tr>
			<tr>
				<td>关键字：</td>
				<td><input type="text" name="keyword" /></td>
				<input type="hidden" name="id" value="<?php echo $id ?>"> 
				<td><input type="submit" value="采集此页" onclick="return check();"><?php if($status==0) echo "（未采集）";else echo "（已采集）"; ?></td>
				<!--<td><a href="collect.php?id=<?php echo $id;?>">【采集此页】</a><?php if($status==0) echo "（未采集）";else echo "（已采集）"; ?></td> -->
			</tr>
		</table>
	</form>
	
	<p>
	<p><span class="image"><?php echo $content?></span></p>
	<a href="hollyscoop_title.php?page=<?php echo $page;?>">返回</a>
</body>
</html>
