<?php
//obtains includes
require_once('res/config.php');
require_once(TEMPLATES_PATH.'/header.php');	
require_once(TEMPLATES_PATH.'/alerts.php');
//check if user session has been set if not send to login p
if(!isset($_SESSION['user_id'])){
	$message = "You need to be logged in before accessing the dashboard";
	$url = BASE_URL."/form.php?sign=login&alert=".$message;
	redirect($url);
}
//checks page request from user for a dynamic content page

//get page
if(isset($_GET['page'])){
	$dashboard_page=$_GET['page'];
} else {
	$dashboard_page="source";
}
//get view type
if(isset($_GET['view'])){
	$dashboard_view=$_GET['view'];
} else {
	$dashboard_view="table";
}

//create new display object
$display = new Display();
?>	
<!-- DASHBAORD BODY CONTAINER -->
<div class="well" style="margin-bottom: 5px;">
	<?php require_once(TEMPLATES_PATH.'/dashboard-header.php'); //includes header?>
	<!-- INSET FOR DATA DISPLAY -->
	<div class="panel panel-default">
		<div class="panel-heading" style="height: 40px;">
			<?php 
				//generate page sub header
				$display->generateHeader($dashboard_page, $dashboard_view);
			?>
		</div><!-- end div for panel heading -->
			<?php
				$display->generateContent($dashboard_page, $dashboard_view);
			?>	
	</div> <!-- End panel for dashabord header & content -->
</div><!--End well style for dashabord -->
<?php
	require_once(TEMPLATES_PATH.'/footer.php');
?>