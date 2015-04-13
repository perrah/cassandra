<?php 

if(isset($_GET['success'])){
	echo '<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		<span class="sr-only">Success</span>
		<strong>Success!</strong> '.$_GET['success'].'
	</div>';
	unset($_GET['success']);
}
if(isset($_GET['error'])){
	echo '<div class="alert alert-warning" role="alert">
		<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
		<span class="sr-only">Error</span>
		<strong>Error!</strong> '.$_GET['error'].'
	</div>';
	unset($_GET['error']);
}
if(isset($_GET['alert'])){
	echo '<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
		<span class="sr-only">Alert</span>
		<strong>Alert!</strong> '.$_GET['alert'].'
	</div>';
	unset($_GET['alert']);
}

?>