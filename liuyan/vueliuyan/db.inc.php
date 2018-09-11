<?php
/*
	测试页面，补充下边需要填空的代码，实现数据的删除操作。

*/

//功能：数据库操作类
header("Content-Type:text/html;charset=utf-8");
class db
{  
	private $host='localhost';//数据库主机
	private $user='root';//数据库用户
	private $pwd='123456';//密码
	private $dbname='_class_info';//数据库名
	public $conn;

	//自执行完成对数据库属性的初始化
	//参数：$host string 主机
		// $user string 用户
		// $pwd string 密码
		// $dbname string 数据库
		// return :void
	function __construct($host='',$user='',$pwd='',$dbname='')
	{   
		if(!empty($host)&&!empty($user)&&!empty($pwd)&&!empty($dbname))
		{
			$this->host=$host;
			$this->user=$user;
			$this->pwd=$pwd;
			$this->dbname=$dbname;
		}
		$this->link();
	}
	/**
	 *
	 *功能1：完成数据库的连接
	 * 
	 */
	private function link()
	{
		$this->conn=mysql_connect($this->host,$this->user,$this->pwd) or die(mysql_error());
		mysql_select_db($this->dbname,$this->conn) or die (mysql_error());
		mysql_query("set names utf8");
	}
/**
 *功能2：获取表中所有的数据
 *参数：$table string 表名
 *      $type   const 关联或索引类型
 * return:array;二维数组
 * 
 */
	public function getalldata($table,$type=MYSQL_NUM)
	{
		$arr=array();
		$i=0;
		$sql="select * from $table order by id desc";
		$query=$this->query($sql);
		while($res=mysql_fetch_array($query,$type))
		{
			$arr[$i]=$res;
			$i++;
		} 
		return $arr;
	}
		/**
		 *功能3：任意合法的sql语句
		 *参数：$table string 表名
		 *      $type  const 关联或索引类型
		 * return:array;二维数组
		 * 
		 */
	public function getsqldata($sql,$type=MYSQL_NUM)
	{
		$arr=array();
		$i=0;
		$query=$this->query($sql);
		while($res=mysql_fetch_array($query,$type))
		{
			$arr[$i]=$res;
			$i++;
		} 
		return $arr;
	}
			/**
		 *功能4：通过id获取表中数据
		 *参数：$table string 表名
		 *      $type const 关联或索引类型
		 *      $id int 主键
		 * return:array一维;
		 * 
		 */
	public function getonedata($table,$id,$type=MYSQL_NUM)
	{
		$res=array();
		$i=0;
		$sql="select * from $table where id=$id limit 1";
		$query=$this->query($sql);
		$res=mysql_fetch_array($query,$type);
		return $res;
	}
			/**
		 *功能5：删除信息
		 *参数：$table string 表名
		 *      $id  array 主键
		 *      $page string 跳转的页面
		 * return:void;
		 * 
		 */
	public function delete($table,$id,$page)
	{
		if(empty($id))
		{
			$this->goback('没有id值');
		}
		$sql="delete from $table where id=$id limit 1";
		$query=mysql_query($sql)or die(mysql_error());
		if(mysql_affected_rows()>0)
		{
			$this->jump('删除成功',$page);
			
		}else{
			$this->goback('删除失败');
		}
	}
	/**
		 *功能6：更改信息
		 *参数：$table string 表名
		 *      $date array 数据
		 *		$id string id值
		 *      $page string 指定跳转页面
		 * 
		 * 
		 */
	public function update($table,$data,$id,$page='show_stu_test.php'){
		$a='';
		//判断是否数组
		if(!is_array($data))
		{
			$this->jump('值的类型不对',$page);
		}
		//判断是否为空
		if(empty($data))
		{
			$this->goback('空值');
		}
		//拆分数组，拼接键和值
		foreach($data as $key => $value)
		{		
			$a.=$key.'='."'".$value."'".',';
		}
		$a=substr($a,0,-1);
        $sql="update $table set $a where id='$id'";
        $query=mysql_query($sql);
        if (mysql_affected_rows()>0)
    {
        $this->jump('录入成功',$page);
        exit;
    }else {
         $this->goback('失败die');
    }
	}
	/**
		 *功能7：完成图片的上传功能
		 *参数：$table string 表名
		 *      $img string 上传的文件夹名
		 * 7.24日
		 * 
		 */
	public function tu($up,$img){
		if(is_uploaded_file($_FILES[$up]['tmp_name'])){
			$wenjian=$_FILES[$up];
			$nameok=$wenjian['name'];
			$type=$wenjian['type'];
			$size=$wenjian['size'];
			$tmp_name=$wenjian['tmp_name'];
			$error=$wenjian['error'];
		}
		switch($type)
		{
		case"image/jpg":$ok=1;
		break;
		case"image/jpeg":$ok=1;
		break;
		case "image/png":$ok=1;
		break;
		case "image/gif":$ok=1;
		break;
		default:$ok=0;break;
		}
		if($ok&&$error=='0')
	{	
		move_uploaded_file($tmp_name,$img.'/'.'2018'.time().$nameok);
		$url=$img.'/'.'2018'.time().$nameok;
		return $url;
	}else{
		return false;
	}
	}
					/**
		 *功能8：插入信息
		 *参数：$table string 表名
		 *      $date array 数据
		 *      $page string 指定跳转页面
		 * 
		 * 
		 */
	public function insert($table,$data,$page='show_stu_test.php')
	{
		$v='';
		$k='';
		//判断是否数组
		if(!is_array($data))
		{
			$this->jump('值的类型不对',$page);
		}
		//判断是否为空
		if(empty($data))
		{
			$this->goback('空值');
		}
		//拆分数组，拼接键和值
		foreach($data as $key => $value)
		{
			//拼接。
			$k.=$key.',';
			$v.="'".$value."',";
		}
		$k=substr($k,0,-1);
		$v=substr($v,0,-1);
        $sql="insert into $table($k)values($v)";
        echo $sql;
        exit;
        $this->query($sql);
    //     if (mysql_affected_rows()>0)
    // {
    //     $this->jump('录入成功',$page);
    //     exit;
    // }else {
    //      $this->goback('你没有更改任何值');
    // }
	}
	/**
		 *功能9：跳转到指定界面
		 *参数：$info string 任意合法查询sql语句
		 * return:void;
		 * 
		 */
	private function query($sql)
	{
		$query=mysql_query($sql) or die(mysql_error());
		if($query){
			return $query;
		}else{
			return false;
		}
	}
		/**
		 *功能10：跳转到指定界面
		 *参数：$info string 任意合法查询sql语句
		 * return:void;
		 * 
		 */
	public function jump($info,$page)
	{
		// echo"<script>
		// 	alert('$info');
		// 	window.location.href='$page';
		// 	</script>";
		// 	exit;
	}
		/**
		 *功能11：跳转到前一页，并给出出错信息。
		 *参数：$info string 任意合法查询sql语句
		 * return:void;
		 * 
		 */
	public function goback($info)
	{
		echo"<script>
			alert('$info');
			window.history.go(-1);
			</script>";
			exit;
	}
}

?>