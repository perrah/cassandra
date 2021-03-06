 <?php
class User {
	protected $_username;
	protected $_password;
	protected $_email;
	protected $_user_id;
	protected $_reg_date;
	protected $_api_key;
	protected $_permissions;
	
	public function register($array){
		// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => "",
			);
		//check credentials to see if user exists
		$check_result = $this->_checkCredentials('register',$array);
		if($check_result["error"] == TRUE) {
			return $check_result;
		}
		//sets users permissions depending on if admin
		if(ADMIN == 'no' || ADMIN == ''){
			$this->_permissions = '100';
		}else { 
			$this->_permissions = '200';
		}
		$r = rand(); //generate random key
		$db = new Database (); 
		$conn_result = $db->connect();
		if($conn_result["error"] == TRUE){ 
					return $conn_result; 
				}
		//insert user into database
		$sql = "INSERT INTO users (username, password, email, reg_date, api_key, permissions)
		VALUES ('".$array['username']."', '".$array['password']."', '".$array['email']."', NOW(), '".sha1($r)."', '".$this->_permissions."')";
		$insert_result = $db->query($sql); //get query result
		//if error return query results else return new user created
		if($insert_result["error"] == TRUE) {
			return $insert_result;
		} else {
			$return['error'] = false;
			$return['message'] = "New user created!"; 
		}
		return $return;	
	}

	public function signed($array){
		// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => "",
			);
		//check credentials
		$check_result = $this->_checkCredentials('signed',$array);
		if($check_result['error'] == true) {
			return $check_result;
		} else {
			//session start
			$db = new Database(); //create db object
			//set the return values if there is an error in db connection
			$conn_result = $db->connect();
			if($conn_result["error"] == TRUE){ 
				return $conn_result; 
			} else {
				$this->_start($db,$array);
				$return['message'] = "User has been signed in successfully!";
			}
			
		} 
		return $return;
	}//end signed function

	public function _checkCredentials($check_type,$array){
		// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => "",
			"result" => ""
			);
		$db = new Database(); //create db object
		//set the return values if there is an error in db connection
		$conn_result = $db->connect();
		if($conn_result["error"] == TRUE){ 
					return $conn_result; 
				}
		//switch statement for check type i.e. check for existing user or if credentials are correct for sign in
		switch ($check_type) {
			case 'register':
				//set retun values for query and if theres an error
				$query_result = $db->query("SELECT user_id FROM users WHERE username = '".$array['username']."'");
				if($query_result["error"] == TRUE){ 
					return $query_result; 
				} else if (mysqli_num_rows($query_result['result']) > 0) {
					$return['error'] = true;
					$return['message'] = "Username already exists please select another";
				} 
				break;
			case 'signed':
				$query_result = $db->query("SELECT * FROM users WHERE username = '".$array['username']."' AND password = '".$array['password']."'");
				if(mysqli_num_rows($query_result['result']) == 0){
					$return["error"] = true;
					$return["message"] = "Username or password incorrect! Please try again.";
				} 
				$return['result'] = $query_result['result'];
				break;
		}//end switch
		return $return;
	}//end check function

	public function _start($db,$array){
		//start user session
		//obtain information of inserted user and set session variables
		$result = $db->query("select * from users where username = '".$array['username']."' AND password = '".$array['password']."'");
		$row = mysqli_fetch_array($result['result']);
		//set session variables
		$_SESSION['user_id']=$row['user_id'];
		$_SESSION['username']=$row['username'];
		$_SESSION['email']=$row['email'];
		$_SESSION['reg_date']=$row['reg_date'];
		$_SESSION['api_key']=$row['api_key'];
		$_SESSION['permissions']=$row['permissions'];
		//return 
		return true;
	}

	public function logOut(){
		unset($_SESSION); 
		session_destroy();
		return true;
	}

	//displays the page that has been selected in the profile page.
	public function viewProfile($page) {
		$db = new Database ();
		$db->connect();
		$result = $db->query('SELECT * FROM users WHERE user_id="'.$_SESSION['user_id'].'"');
		$user_info = mysqli_fetch_array($result['result']);
		$views = include(TEMPLATES_PATH.'/profile-panels.php');//a template hold the different views available and is returned in an array
		switch($page){
			case 'user': //echos user details and email preferences
				echo $views['public_profile'];
				echo $views['email_preferences'];
				break;
			case 'tasks': //views all the tasks the user has performed uses internal method to query database
				$this->viewTasks();
				break;
			case 'settings': //displays setting for changing password and deleting a profile
				echo $views['change_password'];
				echo $views['delete_profile'];
				break;
		}//end switch
	}
	
	//method calls the database to view all the tasks the user has peformed
	public function viewTasks(){
		$db = new Database();
		$db->connect();
		$result = $db->query('SELECT * FROM task_log WHERE user_id ="'.$_SESSION['user_id'].'"');
		$tasks = mysqli_fetch_all($result['result']);
		echo '<div class="panel panel-default">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Task ID</th>
					<th>Description</th>
					<th>Resource Type</th>
					<th>Date</th>
					<th>Duration</th>
					<th>Size</th>
					<th>Status</th>
				</tr>
			</thead>';
		foreach($tasks as $task){
			echo '<tr>
				<td>'.$task[0].'</td>
				<td>'.$task[6].'</td>
				<td>'.$task[2].'</td>
				<td>'.$task[3].'</td>
				<td>'.$task[4].'</td>
				<td>'.$task[7].'</td>
				<td>'.$task[5].'</td>
			</tr>';
		}
		echo '</table></div>';
	}

	
}
?>