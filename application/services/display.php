<?php
Class Display {

	public function generateHeader($dashboard_page, $dashboard_view){
		//logic to get variables resource id and name
		if($dashboard_view == 'resource'){
			$name = $_GET['name'];
			$resource_id = $_GET['resource'];
		} else {
			$name = '';
			$resource_id = '';
		}
		//get panel_headers array
		$panel_headers = include(TEMPLATES_PATH.'/panel-headers.php');
		//switch to display correct header
		switch ($dashboard_view) {
			case 'table':
				echo $panel_headers['table_'.$dashboard_page];
				break;
			case 'resource':
				echo $panel_headers['resource_'.$dashboard_page];
				break;
			default:
				echo $panel_headers['table_'.$dashboard_page];
				break;
		}				
	}//end function to generate header

	public function generateContent($dashboard_page, $dashboard_view){
		$firstheader = "";
		$array = "";
			if($dashboard_page == 'source'){
				$firstheader = "Type";
			} else {
				$firstheader = "Parent";
			}
		//get display html
		include(TEMPLATES_PATH.'/display-views.php');
		//switch for which view is being selected
		switch ($dashboard_view) {
			case 'table':
				$res = new Resource();
				$result = $res->getResources($dashboard_page);
				if($result['error']== true){
					echo "<div class='container'><p><br />No resources found in $dashboard_page.</p></div>";
				} else {
					echo $display_views['table_header'];
					$this->generateTable($dashboard_page, $result['result']);//get resource table
					echo '</table>'; //print end of table
				}
				break;
			case 'resource':
				//display resource
				$this->viewResource($dashboard_page);
				break;
			default:
				//get resource
				break;
		}				

	}

	//displays the content in html and grabs extra info like child count, etc.
	public function generateTable($type, $data){
		$db = new Database();
		$conn_result = $db->connect();
		if($conn_result["error"] == TRUE){ 
					return $conn_result; 
				}
		//fetch array
		while($row = mysqli_fetch_array($data)){
			//FETCH DATA TO DISPLAY
			$array = $this->setTableData($row, $db);
			//grab first td entry depending on type
			$this->printTableData($array, $type);
		}//end while
	}//end function
	
	public function printTableData($array, $type){
		//get classifiers for data
		if($type == 'source'){
			$src = new Source();
			$csv = $src->viewSource($array['resource_id']);
			$headers = array_keys($csv[0]);
			$attributes ="";
			//loop through headers printing them to select options
			foreach($headers as $header){
				$attributes .= "<option value=".$header.">".$header."</option>";
			}
		}//end if source
		$firstfield = "";
				if($type == 'source'){
					$firstfield = $array['source_type'];
				} else {
					//get parent resource data
					$db = new Database();
					$db->connect();
					$result = $db->query('select * from resources where resource_id ="'.$array['parent_id'].'"');
					$parent = mysqli_fetch_array($result['result']);
					switch($type){
						case 'statistic':
							$parent_img = '<span class="glyphicon glyphicon-hdd" aria-hidden="true">';
							break;
						case 'model':
							$parent_img = '<span class="glyphicon glyphicon-flash" aria-hidden="true">';
							break;
						case 'predcition':
							$parent_img = '<span class="glyphicon glyphicon-hdd" aria-hidden="true">';
							break;
					}
					$firstfield = '&nbsp;&nbsp;&nbsp;<a href="'.BASE_URL.'/dashboard.php?view=resource&resource='.$parent['resource_id'].'&name='.$parent['resource_name'].'">'.$parent_img.'</a>';
				}
		echo '<tr>
				<td>'.$firstfield.'</td>
			  <td>
				<li style="list-style-type: none;" role="presentation" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					'.$array['name'].' <span class="caret"></span>
					</a>';
		switch($type){
					case 'source':
						  echo '<ul class="dropdown-menu" role="menu">
								  <li><a href="'.BASE_URL.'/dashboard.php?view=resource&resource='.$array['resource_id'].'&name='.$array['name'].'"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span>&nbsp;&nbsp;View Data</a></li>
								  <li><a href="#" class="processButton" data-toggle="modal" data-selectors="'.$attributes.'" data-user="'.$_SESSION['user_id'].'" data-page="'.$type.'" data-id="'.$array['resource_id'].'" data-name="'.$array['name'].'" data-target="#processResource"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>&nbsp;&nbsp;Process Data</a></li>
								  <li><a href="#" class="shareButton" data-toggle="modal" data-page="'.$type.'" data-id="'.$array['resource_id'].'" data-target="#shareResource"><span class="glyphicon glyphicon-share" aria-hidden="true"></span>&nbsp;&nbsp;Share Source</a></li>
								  <li class="divider"></li>
								  <li><a href="#" class="deleteButton" data-toggle="modal" data-user="'.$_SESSION['user_id'].'" data-name="'.DATA.'/sources/'.$array['name'].'" data-permissions="'.$array['permission'].'" data-page="'.$type.'" data-id="'.$array['resource_id'].'" data-usercount="'.$array['user_count'].'" data-target="#deleteResource"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;&nbsp;Delete Source</a></li>
								</ul>';
						  break;
					case 'statistic':
						  echo '<ul class="dropdown-menu" role="menu">
								  <li><a href="'.BASE_URL.'/dashboard.php?page=statistic&view=resource&resource='.$array['resource_id'].'&name='.$array['name'].'"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>&nbsp;&nbsp;View Stats</a></li>
								  <li><a href="#" class="processButton" data-toggle="modal" data-user="'.$_SESSION['user_id'].'" data-page="'.$type.'" data-id="'.$array['name'].'" data-target="#processResource"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span>&nbsp;&nbsp;Create Model</a></li>
								  <li><a href="#" class="shareButton" data-toggle="modal" data-page="'.$type.'" data-id="'.$array['resource_id'].'" data-target="#shareResource"><span class="glyphicon glyphicon-share" aria-hidden="true"></span>&nbsp;&nbsp;Share Stats</a></li>
								  <li class="divider"></li>
								  <li><a href="#" class="deleteButton" data-toggle="modal" data-user="'.$_SESSION['user_id'].'" data-name="'.DATA.'/sources/'.$array['name'].'" data-permissions="'.$array['permission'].'" data-page="'.$type.'" data-id="'.$array['resource_id'].'" data-usercount="'.$array['user_count'].'" data-target="#deleteResource"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;&nbsp;Delete Stats</a></li>
								</ul>';
						  break;
				}//end switch
		  echo '</li>
						  </td>
						  <td>'.$array['created'].'</td>
						  <td>'.$array['size'].' '.$array['size_type'].'</td>
						  <td>'.$array['child_count'].'</td>
						</tr>';
	}
	
	public function setTableData($array, $db){
		//FETCH DATA TO DISPLAY
		$return = array (
			'resource_id' => $array['resource_id'],
			'source_type' => $array['source_type'],
			'name' => $array['resource_name'],
			'created' => $array['created_on'],
			'parent_id' => $array['parent_id'],
			'size_type' => '',
			'size' => '',
			'permission' => '',
			'child_count' => '',
			'user_count' => ''
		);		
		//size formats
		$return['size_type'] = "kb";
		$return['size'] = $array['size'];
		$return['size'] = number_format(($return['size'] * 0.0009765625),2);
		if($return['size'] >= 1024){
			$return['size'] = number_format(($return['size']* 0.0009765625),2);
			$return['size_type'] = "mb";
		}
		if($return['size'] >= 1024){
			$return['size'] = number_format(($return['size'] * 0.0009765625),2);
			$return['size_type'] = "gb";
		}
		//get permissions for user
		$sql = "SELECT permissions FROM user_resources WHERE resource_id = '".$array['resource_id']."' AND user_id = '".$_SESSION['user_id']."'";
		$permission_result = $db->query($sql);
		$permission = mysqli_fetch_array($permission_result['result']);
		$return['permission'] = $permission['permissions'];
		//get child count of resource
		$sql = "SELECT * FROM resources WHERE parent_id = '".$array['resource_id']."' AND resource_id IN (SELECT resource_id FROM user_resources WHERE user_id = '".$_SESSION['user_id']."')";
		$child_result = $db->query($sql);
		$return['child_count'] = mysqli_num_rows($child_result['result']);
		//get amount of shares
		$sql = "SELECT user_id FROM user_resources WHERE resource_id = '".$array['resource_id']."'";
		$user_result = $db->query($sql);
		$return['user_count'] = mysqli_num_rows($user_result['result']);
		
		return $return;
	}
	
	public function viewResource($type) {
		
		switch($type){
			case 'source':
				$source = new Source();
				$result = $source->viewSource($_GET['resource']);
				$headers = array_keys($result[0]);
				//display header
				echo '<table class="table table-hover">
				<thead>';
					foreach($headers as $header){
						echo '<th>'.$header.'</th>';
					}
				echo '</thead>';
				//display main body
				foreach($result as $instance){
					echo '<tr>';
						foreach($instance as $field){
							echo '<td>'.$field.'</td>';
						}
					echo '</tr>';
				}
				echo '</table>';
				break;
			case 'statistic':
				$stats = new Statistic();
				echo '<table class="table table-hover">
					<thead>
						<th style="text-align: center;" >Attribute</th>
						<th style="text-align: center;">Type</th>
						<th style="text-align: center;">Instances</th>
						<th style="text-align: center;">Distinct</th>
						<th style="text-align: center;">Unique</th>
						<th width="35%">Histogram</th>
						<th>Stats</th>
					</thead>';
				$stats->viewStatistic($_GET['resource']);
				echo '</table>';
					;
				break;
			case 'model':
				break;
			case 'prediction':
				break;
		}//end switch
		
	}//end function
	
}

?>