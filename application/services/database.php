<?php
/*
DATABASE CLASS

This class contains all the required functions that communicate to the database. This is 
connect to the host and database, creation or update of the config file that contains the server 
data, handling a query to the database and creation of all the tables
*/

class Database {

	private $host;
	private $username;
	private $password;
	private $dbname;
	private $conn;

	public function __construct(){
		//set db variables
		$this->host = HOST;
		$this->username = USERNAME;
		$this->password = PASSWORD;
		$this->dbname = DATABASE;
	}//end constructor

	//funtion allows a conection to the database on the given db variables from config.
	public function connect(){
		// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => "",
			"conn" => ""
			);
		//make connections
		$this->conn = new mysqli($this->host, $this->username,$this->password);
		// Check connection
		if ($this->conn->connect_error) {
			$return['error'] = true;
		    $return['message'] = $this->conn->connect_error;
		} else { //else no error with connection, selection of db required
			$result = $this->selectDatabase($this->dbname);
			if($result['error'] == false){
				//database has been selected
				$return["message"] = "Database ".$this->dbname." has been selected.";
				$return['conn'] = $this->conn;
			} else {
				//database has not been selected, set error in return
				$return["error"] = true;
				$return["message"] = $result["message"];
			}
		} 
		return $return;
	}//end connection function

	//selects the database either provided by the setup or within predefined db info from the config.
	public function selectDatabase($database){
		// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => ""
			);
		// Create database if it doesn't exist
		$sql = "CREATE DATABASE IF NOT EXISTS $database";
		$result = $this->query($sql);
		//select database
		if($result['error'] == false){
        	mysqli_select_db($this->conn, $database);
        } else{
        	return $result;
        }
        return $return;
    }//end selectDatabase

    //query returns an array of the result, or an error if it fails
    public function query($query){
    	// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => "",
			"result" => ""
			);
		//query
    	$result = mysqli_query($this->conn,$query);
    	if (!$result) {
    		$return['error'] = true;
		    $return['message'] = $this->conn->error;
    	} else {
    		$return['error'] = false;
		    $return['message'] = "Query successful! ";
		    $return['result'] = $result;
    	}
    	return $return;
    }//end query function

    //provides a method for update the database config file 
    public function updateConfig($array){
    	//convert to string for writing to file
    	$toWrite = '
	    	<?php
	    		return array (
		    		"database" => "'.$array['database'].'",
					"username" => "'.$array['username'].'",
					"password" => "'.$array['password'].'",
					"host" => "'.$array['host'].'"
				);
			?>';
		//create/update file
		$file = fopen($_SERVER['DOCUMENT_ROOT']."/cassandra/res/config/db-config.php", "w");
		//write and close
		if(fwrite($file, $toWrite)){
			fclose($file);
			return true;
		} else {
			return false;
		}
    }//end update function

    //function to create all the required tables for the tool
    public function createTables(){
    	$table_count =0;
    	$message = ''; 
    	// return array for handling messages and errors
		$return = array(
			"error" => false,
			"message" => ""
			);
    	$this->deleteTables();//delete existing tables
		//get sql from config
		$queries = require(RESOURCE_PATH."/config/table-config.php");
		//for each query
    	foreach($queries as $query){
    		$result = $this->query($query);//get result
    		//check if an array if so add to count, else add to error
    		if($result['error'] === FALSE){
    			$table_count ++;
    		} else {
    			$message .= $result['message'] . '. ';
    		}
    	}//end for each query
    	//return logic
    	if(count($queries) > $table_count){ 
    		$return['error'] = true;//if not all tables where created generate an error
    		$message .= "Contact support teams or refer to documentation. ";
    	}
    	$return['message'] = $table_count . " table(s) created. ". $message;
    	return $return;
    }//end create table function

    //delete any existing tables within the given database
    public function deleteTables(){
    	//delete all existing tables 
    	$this->conn->query('SET foreign_key_checks = 0');
		if ($result = $this->conn->query("SHOW TABLES"))
		{
			while($row = $result->fetch_array(MYSQLI_NUM))
			{
				$this->conn->query('DROP TABLE IF EXISTS '.$row[0]);
			}
		}
    }
}//end class

?>