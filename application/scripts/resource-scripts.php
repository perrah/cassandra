<?php
//script for handling resource requests

require($_SERVER['DOCUMENT_ROOT']."/cassandra/res/config.php");

//IF PROCESS RESOURCE CHOSEN
if(isset($_POST['process'])){
	switch($_POST['process']){
		case 'source':
			$res = new Resource();
			$result = $res->addStatistic(array(
				'res_name' => $_POST['resourceName'],
				'classifier' => $_POST['classifier'],
				'res_id' => $_POST['resourceId']
			));
			$page = 'statistic';
			break;
		case 'model':
			//DO METHOD
			break;
		case 'prediction':
			//DO METHOD
			break;
	}
	if($result['error'] == false){
		redirect(BASE_URL.'/dashboard.php?page='.$page.'&success='.$result['message']);
	} else {
		redirect(BASE_URL.'/dashboard.php?page='.$page.'&error='.$result['message']);
	}
}
//IF UPLOAD FILE
if(isset($_POST['uploadFile'])){
	$result = uploadFile($_FILES["file"]);
	if($result['error'] == false){
		redirect(BASE_URL.'/dashboard.php?success='.$result['message']);
	} else {
		redirect(BASE_URL.'/dashboard.php?error='.$result['message']);
	}
}//end upload script

//IF DELETE METHOD
if(isset($_POST['deleteResource'])){
	$res = new Resource();
	$result = $res->deleteResource(
		array(
			'res_id' => $_POST['resourceId'],
			'res_name' => $_POST['resourceName'],
			'user_id' => $_POST['resourceUser'],
			'permissions' => $_POST['resourcePermissions']
		));
	if($result['error'] == false){
		redirect(BASE_URL.'/dashboard.php?page='.$_POST['resourcePage'].'&success='.$result['message']);
	}else {
		redirect(BASE_URL.'/dashboard.php?page='.$_POST['resourcePage'].'&error='.$result['message']);
	}	
}//end delete script
//IF SHARE RESOURCE
if(isset($_POST['shareResource'])){
	$res = new Resource();
	$result = $res->shareResource(
		array (
			'res_id' => $_POST['resourceId'],
			'username' => $_POST['username']
		));
	if($result['error'] == false){
		redirect(BASE_URL.'/dashboard.php?page='.$_POST['resourcePage'].'&success='.$result['message']);
	}else {
		redirect(BASE_URL.'/dashboard.php?page='.$_POST['resourcePage'].'&error='.$result['message']);
	}		
}//end share post


//function for calling and creating a new source resource of file type
function uploadFile(){
	$return = array (
		'error' => false,
		'message' => ''
	);
	if ( isset($_FILES["file"])) {
		if($_FILES["file"]['size'] > 0){
			$res = new Resource();//create new resource object
			$return = $res->addSource('file',$_FILES["file"]);
		} else {//error for no file
			$return['error'] = true;
			$return['message'] = "No file has been selected, please choose one and try again.";
		}
	}else { //error for no file
		$return['error'] = true;
		$return['message'] = "No file has been selected, please choose one and try again.";
	}
	return $return;
}


?>