<?php
class Resource {
	
	//function for uploading file
	function addSource($type,$source){
		$return = array (
			'error' => false,
			'message' => ''
		);
		$src = new Source();
		switch($type){
			case 'file':
				$result = $src->addFile($source);
				$size = $source['size'];
				break;
			case 'database':
				$result = $src->addDatabase($source);
				break;
		}//end switch
		//error checking
		if($result['error'] == true){
			return $result;
		} else {
			$insert = array(
				"name" => $result['source_name'],
				"parent_id" => null,
				"size" => $size,
				"description" => "File upload",
				"resource_type" => "source",
				"source_type" => $type,
				'user_id' => $_SESSION['user_id'],
				'validation' => 'true',
				'location' => $result['location']
			);
			$db_result = $this->insertResource($insert);
			if($db_result['error'] == true){
				return $db_result;
			}
			$return['message'] = 'Source '.$source['name'].' has been added successfully';
			return $return;
		}	
	}//end function
	
	//function for connecting a database
	function addStatistic ($array) {
		$stat = new Statistic();
		$res_array = $stat->createStatistics($array);
		$insert = array(
				"name" => $res_array['res_name'],
				"parent_id" => $res_array['parent_id'],
				"size" => filesize(DATA.$res_array['location']),
				"description" => "Statistic creation",
				"resource_type" => "statistic",
				"source_type" => '',
				'user_id' => $_SESSION['user_id'],
				'validation' => 'true',
				'location' => $res_array['location']
			);
		$db_result = $this->insertResource($insert);
		if($db_result == true){
			return array ('error' => false, 'message' => 'Statistics have been successfully created');
		} else {
			return array ('error' => true, 'message' => 'There was an issue with creating your statistics please check with your administrator');
		}
	}
	
	//checks file by type, etc.
	function addModel(){
	
	}
	
	//saves resource in database tables
	function addPrediction(){
	
	}
	
	function deleteResource($array) {
		//connect
		$db = new Database ();
		$db->connect();
		//get location
		$sql = "SELECT * FROM resources WHERE resource_id='".$array['res_id']."'";
		$result = $db->query($sql);
		if($result['error'] == true){
			return $result;
		}
		$location = mysqli_fetch_array($result['result']);
		$location = $location['location'];
		//delete from user resource relationships
		$sql = "DELETE FROM user_resources WHERE resource_id='".$array['res_id']."' AND user_id='".$array['user_id']."'";
		$result = $db->query($sql);
		if($result == false){
			return $result;
		}
		if($array['permissions'] == '100'){
		//delete actual resource
			$sql = "DELETE FROM user_resources WHERE resource_id='".$array['res_id']."'";
			$result = $db->query($sql);
			if($result['error'] == false){
				$sql = "DELETE FROM resources WHERE resource_id='".$array['res_id']."'";
				$result = $db->query($sql);
				if($result['error'] == false){
					if(unlink(DATA.$location)){//delete object from directory
						return array (
							'error' => false,
							'message' => 'Resource has been successfully deleted.' 
						);	
					} else {
						return array (
							'error' => true,
							'message' => 'Resource has not been deleted from the directory.' 
						);
					}
				} else { return $result;}
			} else {
				return $result;
			}
		} else {
			return $result;
		}//end if permission = 100
		
	}//end delete resource
	
	function shareResource($array) {
		//connect
		$db = New Database();
		$db->connect();
		//check if user exists
		$sql = "SELECT * FROM users WHERE username='".$array['username']."'";
		$result = $db->query($sql);
		//return user if user does not exists
		if(mysqli_num_rows($result['result']) == 0){
			return array ("error" => true, "message" => "That user does not exists, please try again.");
		}
		$user_data = mysqli_fetch_array($result['result']);
		$user_id = $user_data['user_id'];
		//check to see if resource user relationship exists already
		$sql = "SELECT * FROM user_resources WHERE user_id='$user_id' AND resource_id='".$array['res_id']."'";
		$result = $db->query($sql);
		if(mysqli_num_rows($result['result']) > 0){
			return array ("error" => true, "message" => "The user already has the selected resource. Please try again.");
		} else {
			//if not insert relationship with 200 permissions
			$sql = "INSERT INTO user_resources (user_id, resource_id, permissions) VALUES ('$user_id','".$array['res_id']."','200')";
			$result = $db->query($sql);
			if( $result['error'] == false){
				return array ('error'=> false, 'message' => 'resource has been shared with user.');
			} else {
				//return message results
				return $result;
			}
		}
	}
	
	//grab all resources for user depending on type
	function getResources($type){
		$return = array (
				'error' => false,
				'message' => ''
			);
		$db = New Database();
		$db->connect();
		$sql = "SELECT * FROM resources WHERE resource_type = '$type' AND resource_id IN (SELECT resource_id FROM user_resources WHERE user_id = '".$_SESSION['user_id']."') ORDER BY created_on ASC";
		$result = $db->query($sql);
		if(mysqli_num_rows($result['result']) == 0){
			$return['error'] = true;
			$return['message'] = "No Resources available";
		}else {
			return $result;
		} 
		return $return;
	}
	
	function insertResource($array){
		$duration ='';
		$last_resource_id = '';
		//update resources, user_resource and task log
		$queries = array(
			"INSERT INTO resources (resource_name, parent_id, resource_type, source_type, created_on, size, location) 
			VALUES ('".$array['name']."','".$array['parent_id']."','".$array['resource_type']."','".$array['source_type']."',NOW(),'".$array['size']."', '".$array['location']."')",
			"INSERT INTO user_resources (user_id, resource_id, permissions) 
			VALUES ('".$array['user_id']."','last_resource_id','100')",
			"INSERT INTO task_log (user_id, resource_type, date, duration, status, description, size) 
			VALUES ('".$array['user_id']."','".$array['resource_type']."', NOW(),'$duration','".$array['validation']."','".$array['description']."','".$array['size']."')"
		);
		$db = new Database();
		$conn_result = $db->connect();
		//run through each query
		foreach($queries as $query){
			$query = str_replace('last_resource_id', $last_resource_id, $query);
			$query_result = $db->query($query);//one query at a time
			$last_resource_id = mysqli_insert_id($conn_result['conn']); //get last id
			if($query_result["error"] == TRUE){ 
				return $query_result;
			}
		}
		return array ("error" => false, "" => "Resource was successfully added to the database");
	}//function end for insert resource
		
}//end class
?>