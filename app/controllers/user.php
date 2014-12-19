<?php
class User extends Controller
{
	public function index()
	{
		echo 'show';
		$new_user = false;
		if (isset($_SESSION['user'])) {
			$sql = new Mysql;
			$res = $sql->showTable('user');
	    	while($row = mysqli_fetch_assoc($res)) {
	  			$body[(string)$row["id"]] = $row;
			}
	    	$sql->disconnect();
			$this->view('user/index', ['body' => $body,'new_user' => $new_user]);
		} else {
			$new_user = true;
			$this->view('user/index', ['new_user' => $new_user]);
		}
		//$this->view('user/index', ['name'=> $user->name]);
	}

	public function insert()
	{
		switch($_SERVER['REQUEST_METHOD'])
		{
		case 'GET': $this->view('user/register'); break;
		case 'POST': 
		echo 'insert function<br />';
		if ($this->check_value($_POST)) {
			$sql = new Mysql;
			if ($sql->insertTable('user', $_POST)) {
				$_SESSION['user'] = $row['name'];
				$_SESSION['type'] = $row['type'];
				echo "<a href='./?url=user/index'>succes and return to the index</a>";
			}
		}
		$this->view('user/register');
		}
	}

	public function check_value($date) {
		if (!array_key_exists('name', $date)) {
			echo "without user name<br />";
			echo "<a href='./?url=user/insert'>again</a>";
			return False;
		}
		if (!array_key_exists('pwd', $date)) {
			echo "without password <br />";
			echo "<a href='./?url=user/insert'>again</a>";
			return False;
		} 
		if (!array_key_exists('pwd2', $date)) {
			echo "without password confirm<br />";
			echo "<a href='./?url=user/insert'>again</a>";
			return False;
		}
		if ($date['pwd'] !== $date['pwd2']) {
			echo "password is not the same<br />";
			echo "<a href='./?url=user/insert'>again</a>";
			return False;
		}
		return True;
	}

	public function deleted($id=Null)
	{
		echo 'deleted';
		if (($id) && ($_SESSION['type']=="admin")) {
			$sql = new Mysql;
			$res = $sql->findId('user', $id);
			if (mysqli_num_rows($res)==0) {
				echo "<a href='./?url=user/index'>the user does not existe</a>";	
			} else {
				if ($sql->delete_coloum('user', $id)) {
					echo "<a href='./?url=user/index'>success to delete the user</a>";
				}
			}
			$sql->disconnect();
		} else {
			echo "<a href='./?url=user/index'>you can not delete the user</a>";
		}
	}

	public function update($id=Null) 
	{
		echo 'update';
		$sql = new Mysql;
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': 
				echo "find user '$id'";
				$res = $sql->findID('user', $id);
				if ( mysqli_num_rows( $res ) !== 0 ) {
					$body=mysqli_fetch_assoc($res);
					$this->view('user/update', ['body'=>$body]);
				} else {
					echo "<a href='./?url=user/index'>can not find the user</a>"; 
				}
				break;
			case 'POST':
				var_dump($_POST);
				if ($sql->updateTable('user', $_POST)) {
					$_SESSION['user'] = $_POST['name'];
					echo "<a href='./?url=user/index'>succes and return to the index</a>";
				} else {
					echo "<a href='./?url=user/index'>can not update the user</a>"; 
				}
		}
		$sql->disconnect();
	}

	public function login()
	{
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': $this->view('user/login'); break;
			case 'POST': 
			echo 'login function<br />';
			$sql = new Mysql;
			$res = $sql->find('user', $_POST);
			if (mysqli_num_rows($res)>=1) {
				$row = mysqli_fetch_array($res);
				$_SESSION['user'] = $row['name'];
				$_SESSION['type'] = $row['type'];
				echo "<a href='./?url=user/index'>succes and return to the index</a>";
			
			} else {
				echo "<a href='./?url=user/login'>can not find the user</a>";
				$this->view('user/login');
			}
			$sql->disconnect();
		}
	}

	public function logout() 
	{
		session_unset();
		$this->view('user/index');
	}
}
?>