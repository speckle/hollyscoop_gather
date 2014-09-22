<?php 
/**
* desc：mysql操作类
* 
*/
Class db{
	//数据库配置信息
	private $Host;
	private $UserName;
	private $Password;
	private $DbName;

	public $link;
	public $query;
	public $last_error;

	function __construct($host,$user,$pwd,$dbname)
	{   
		$this->Host=$host;
		$this->UserName=$user;
		$this->Password=$pwd;
		$this->DbName=$dbname;
		$this->Connect();
	}
	private function Connect(){
   		//数据库连接
		$this->link=mysql_connect($this->Host,$this->UserName,$this->Password) or die("Error Connect to DB");
		mysql_set_charset("utf8");
		$this->SetError(mysql_error());
		//select db ...
		mysql_select_db($this->DbName) or die("Error Select DB");
		$this->SetError(mysql_error());
	}

	public function query($query)
	{
	 //mysql查询
		$this->query=mysql_query($query,$this->link) or die("Error in query:".mysql_error());
		$this->SetError(mysql_error());
	}

	public function assoc()
	{
	   //mysql_fetch_assoc :
		return mysql_fetch_assoc($this->query);
		$this->SetError(mysql_error());
	}

	public function num()
	{
	   //mysql_num_rows:
		return mysql_num_rows($this->query);
		$this->SetError(mysql_error());
	}

	public function result($index=0)
	{
	   //mysql_result : 
		return mysql_result($this->query,$index);
		$this->SetError(mysql_error());
	}

	private function SetError($error)
	{
		$this->last_error=$error;
	}

	public function ShowError()
	{
		return $this->last_error;
	}

	public function Close()
	{
		mysql_close($this->link);
	}
}
?>
