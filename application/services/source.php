<?php
class Source {
	
	function addFile($source){
		//set variables
		$name = $source["name"]; 
		$target = DATA.'/sources/';
		$i=0;
		$type = "file";
		//so-urce validation
		$result = $this->checkSource($type,$source);
		if($result['error'] == true) {
			return $result;
		}
		//if file exists
		$parts = pathinfo($name);
		while (file_exists($target . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		}
		//move file
		$move_result = move_uploaded_file($source['tmp_name'], $target.$name);
		if(!$move_result){
			$return['error'] = true;
			$return['message'] = "File was not moved into data directory. Please check with tool administrator.";
			return $return;
		} else { //update database with resource info
			chmod($target . $name, 0777); //set permissions on file
			if($i == 0){
				return array(
					'error'=> false,
					'source_name' => $parts["filename"],
					'location' => '/sources/' . $name
				);
			}else {
				return array(
					'error'=> false,
					'source_name' => $parts["filename"].'-'.$i,
					'location' => '/sources/' . $name
				);
			}
		}//end else
	}//end function
	
	function addDatabase($source) {
		$type = "database";
		
		//return true OR error
	}
	
	function checkSource($type, $source){
		//include source configs
		$configs = include(CONFIG_PATH.'/source-config.php');
		$return = array (
			'error' => false,
			'message' => ''
		);
		switch($type){
			case 'file':
				if($_FILES['file']['size'] > $configs['limit']){ 
					$return['error'] = true;
					$return['message'] = 'Oops, your file\'s size is to large. ';
				}
				$name = $_FILES["file"]["name"]; 
				$parts = pathinfo($name);
				if(!in_array($parts['extension'],$configs['types'])){
					$return['error'] = true;
					$return['message'] = 'Oops, your file type isnt supported, please try another. ';
				} 
				break;
			case 'database':
				//do database checks
				break;
		}
		return $return;
		//return true OR error
	}//end function
	
	
	public function viewSource($res_id){
		//set location and grab data
		$db = new Database();
		$db->connect();
		$result = $db->query('SELECT * FROM resources WHERE resource_id = "'.$res_id.'"');
		//$location = mysql_fetch_array($result);
		$array = mysqli_fetch_array($result['result']);
		$location = $array['location'];
		
		$lines = array_map('str_getcsv', file(DATA.$location));
		$header= array_shift($lines);
		$array = array();
		//for each to save file into associative array
		foreach ($lines as $line){
			$array[] = array_combine($header, $line);
		}
		return $array;
		
	}//get data function
	
	
}

?>