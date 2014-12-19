<?php
class Mysql
{
	protected $connect;
	public function __construct()
	{
		if ($this->connectDB()) {
			echo "Success to connect Mysql";
		}
	}
	
	public function connectDB()
	{
		$con=mysqli_connect("127.0.0.1:3306","root","chenlx201125","phpdb");
		if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  			return False;
  		} else {
  			$this->connect = $con;
  			return True;
   		}
	}

	public function disconnect()
	{
		mysqli_close($this->connect);
	}

	public function insertTable($table_name, $date)
	{
		$name = mysqli_real_escape_string($this->connect, $date['name']);
		$pwd = mysqli_real_escape_string($this->connect, $date['pwd']);
		$query = "INSERT INTO " . $table_name . " (name, pwd) VALUES ('". $name . "', '" . $pwd . "')";
		if (!mysqli_query($this->connect, $query)) {
		  die('Error: ' . mysqli_error($this->connect));
		} else {
			return True;
		}
	}

	public function showTable($table_name)
	{
		return mysqli_query($this->connect,"SELECT * FROM ".$table_name);
	}

	public function find($table_name, $data)
	{

		return mysqli_query($this->connect,"SELECT * FROM ".$table_name." where name='".$data['name']."' and pwd='".$data['pwd']."'");
	}

	public function findId($table_name, $id)
	{

		return mysqli_query($this->connect,"SELECT * FROM ".$table_name." where id=".$id);
	}

	public function delete_coloum($table_name, $id)
	{
		$id = mysqli_real_escape_string($this->connect, $id);
		$query = "Delete FROM " . $table_name . " where id=". $id;
		if (!mysqli_query($this->connect, $query)) {
		  die('Error: ' . mysqli_error($this->connect));
		} else {
			return True;
		}
	}

	public function updateTable($table_name, $data)
	{
		switch ($table_name) {
			case 'user':
				return $this->updateUser($data);
				break;
			
			default:
				return False;
				break;
		}
	}

	private function updateUser($data)
	{
		$squery = "UPDATE user SET name='".$data['name']."',age=".$data['age'].",birthday='".$data['birthday']."' where id=".$data['id'];
		echo $squery;
		return mysqli_query($this->connect, $squery);
	}
}
?>