<?php
require_once('res/config.php');	
require_once(TEMPLATES_PATH.'/header.php');	
if(isset($_GET['page'])){	
	$page= $_GET['page'];
}else {
	$page ='user';
}
?>	

<div class="well">
	<div class='row'>
		<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
            <a href="?page=user" class="list-group-item <?php if($page == 'user'){echo 'active';} ?>">Profile</a>
            <a href="?page=tasks" class="list-group-item <?php if($page == 'tasks'){echo 'active';} ?>">User Tasks</a>
            <a href="?page=settings" class="list-group-item <?php if($page == 'settings'){echo 'active';} ?>">Settings</a>
          </div>
        </div><!--/.sidebar-offcanvas-->
		<div class="col-xs-12 col-sm-9">
			<div class="panel panel-default">
				<div class="panel-heading" style="height: 40px;">
					<h3 style='margin-top:-1px;'>
						<?php
							switch($page){
								case 'user':
									echo 'User Profile';
									break;
								case 'tasks':
									echo 'User Tasks';
									break;
								case 'settings':
									echo 'User Settings';
									break;
							}//end switch
						?>
					</h3>
				</div><!--END HEADING -->
				<?php
					$user = new User();
					$user->viewuser($_SESSION['user_id']);
					

				?>
				<div class="row">
					<div class="col-xs-8" >
						<form class="form-horizontal" style="margin: 20px; margin-left: 40px;">
							<div class="form-group" style="margin-left: -15px;">
								<div class="input-group col-sm-9">
								  <span class="input-group-addon" id="basic-addon1">Username</span>
								  <input type="text" class="form-control " placeholder="Recipient's username" aria-describedby="basic-addon2">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
								  <span class="input-group-addon" id="basic-addon1">Password</span>
								  <input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2" readonly>
								  <span class="input-group-addon" id="basic-addon2"><a style="cursor: pointer;">Reset Password</a></span>
								</div>
							</div>
						 
						</form>
					</div>
				</div>
			</div> <!--END PANEL -->
		</div>
  </div>
</div>
<?php
	require_once(TEMPLATES_PATH.'/footer.php');
?>