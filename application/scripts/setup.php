<?php
/*
INSTALLATION SCRIPT

This script is iniated if the tool has yet to be installed on the server. this includes the  
connection to a host, set up of a db-config file, creation/or selection of a database and creation
of all the required tables that are necessary for the tool.
*/
require($_SERVER['DOCUMENT_ROOT']."/cassandra/res/config.php");

//script for creating database and tables
if(isset($_POST['createDatabase'])){
		//set variabled for database creation
		$db_array = array (
			"host" => $_POST["host"],
			"username" => $_POST["username"],
			"password" => $_POST["password"],
			"database" => $_POST["database"],
			);
		$result = createDatabase($db_array);//call create function with results
		//logic for return
		if($result['error'] == TRUE){
			$validation = "&error=";
		} else {
			$validation = "&success=";
			$setup_array = array (
				'setup' => 'yes',
				'admin' => ''
				);
			updateSetupConfig($setup_array);
		}
		redirect(BASE_URL.'/form.php?setup='.$result['setup'].$validation.$result['message']);
}//end if createdatabase

//checks to see if register has been passed for creation of a new user
if(isset($_POST['register'])){
	$user_array = array(
		"username" => $_POST['username'],
		"password" => $_POST['password'],
		"email" => $_POST['email']
		);
	$user = new User();//create new user object
	$result = $user->register($user_array);
	if($result["error"] == TRUE){
		redirect(BASE_URL.'/form.php?setup=login&error='.$result['message']);
	} else { //if no error proceed to sign in user and start a session
		if(ADMIN =='no' || ADMIN == ''){
			$setup_array = array (
				'setup' => 'yes',
				'admin' => 'yes'
				);
		updateSetupConfig($setup_array);
		}
		$sign_result = $user->signed($user_array);
		//check for sign error
		if($sign_result["error"] == TRUE){
			redirect(BASE_URL.'/form.php?setup=login&error='.$sign_result['message']);
		} else {
			redirect(BASE_URL.'/dashboard.php?success='.$sign_result['message']);
		}
	}
}//end if register

if(isset($_POST['login'])){
	$user_array = array(
		"username" => $_POST['username'],
		"password" => $_POST['password']
		);
	$user = new User();//create new user object
	$sign_result = $user->signed($user_array);
		//check for sign error
		if($sign_result["error"] == TRUE){
			redirect(BASE_URL.'/form.php?sign=login&error='.$sign_result['message']);
		} else {
			redirect(BASE_URL.'/dashboard.php?success='.$sign_result['message']);
		}
}


if(isset($_GET['logout'])){
	$user = new User();
	$user->logout();
	$error = "You have been logged out. To log back in <a href='form.php?sign=login'>click here</a>";
	redirect(BASE_URL.'/index.php?error='.$error);
}

//create new database function that handles the return logic from the classes
function createDatabase($db_array){
	// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => "",
			"setup" => ""
			);
	$db = new Database(); //create Db object
	$db->updateConfig($db_array); //update config with given data
	$result = $db->connect(); //get result array 
	//if errors have occurred redirect back to form for connection, else success
	if($result['error'] === FALSE) {
		$table_result = $db->createTables();
			if($table_result["error"] === FALSE){
				$return['error'] = false;
				$return['setup'] = 'login';
				$return['message'] = $table_result['message']; 
			} else {
				$return['error'] = true;
				$return['setup'] = 'install';
				$return['message'] = $table_result['message']; 
			}
	} else {
		$return['error'] = true;
		$return['setup'] = 'install';
		$return['message'] = $result['message']; 
	}
	return $return;
}

//provides a method for updating the setup config file 
function updateSetupConfig($array){
	//convert to string for writing to file
	$toWrite = '
    	<?php
    		return array (
	    		"setup" => "'.$array['setup'].'",
				"admin" => "'.$array['admin'].'"
			);
		?>';
	//create/update file
	$file = fopen($_SERVER['DOCUMENT_ROOT']."/cassandra/res/config/setup-config.php", "w");
	//write and close
	if(fwrite($file, $toWrite)){
		fclose($file);
		return true;
	} else {
		return false;
	}
}//end update function

?>