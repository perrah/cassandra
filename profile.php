<?php
require_once('res/config.php');	
require_once(TEMPLATES_PATH.'/header.php');	

?>	

<div class="well">
	<div class='row'>
		<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
            <a href="?page=user" class="list-group-item <?php //if($page == 'user'){echo 'active';} ?>">Profile</a>
            <a href="?page=tasks" class="list-group-item <?php //if($page == 'tasks'){echo 'active';} ?>">User Tasks</a>
            <a href="?page=settings" class="list-group-item <?php //if($page == 'settings'){echo 'active';} ?>">Settings</a>
          </div>
        </div><!--/.sidebar-offcanvas-->
		<div class="col-xs-12 col-sm-9">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Public Profile</strong></div>
				<div class="row">
					<div class="col-xs-7" >
						<form class="form-horizontal" style="margin: 20px; margin-left: 40px;">
							<div class="form-group">
								  <label for="user_name">Username</label>
								  <div class="input-group">
									<input type="text" class="form-control" id="user_name" placeholder="admin" readonly>
									 <span class="input-group-addon"><a href=''>Change Password</a></span>
								  </div>
							</div>
							<div class="form-group">
								<label for="user_email">Email address</label>
								<input type="email" class="form-control" id="user_email" value="perryjsteward@gmail.com">
							</div>
							<div class="form-group">
								<label for="company">Company</label>
								<input type="text" class="form-control" id="company" value="">
							</div>
							<div class="form-group">
								<label for="location">Location</label>
								<input type="text" class="form-control" id="location" value="">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success">Update profile</button>
							</div>
						</form>
					</div>
				</div>
			</div> <!--END PANEL -->
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Email Preferences</strong></div>
				<div class="row">
					<div class="col-xs-7" >
						<form class="form-horizontal" style="margin: 20px; margin-left: 40px;">
							<div class="form-group">
								<label>Notify me when:</label>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									  <input type="checkbox" checked> Someone shares a resource with me
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									  <input type="checkbox" checked> Someone reshares a resource I own
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									  <input type="checkbox" checked> Someone deletes a resource that was shared with me
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									  <input type="checkbox" checked> Someone deletes a shared resource I own
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									  <input type="checkbox" checked> When I delete a resource I own
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									  <input type="checkbox" checked> When I delete a resource thats been shared with me
									</label>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success">Update preferences</button>
							</div>
						</form>
					</div>
				</div>
			</div> <!--END PANEL -->
			
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Change Password</strong></div>
				<div class="row">
					<div class="col-xs-7" >
						<form class="form-horizontal" style="margin: 20px; margin-left: 40px;">
							<div class="form-group">
								<label for="old_password">Old Password</label>
								<input type="email" class="form-control" id="old_password" value="">
							</div>
							<div class="form-group">
								<label for="new_password">New password</label>
								<input type="text" class="form-control" id="new_password" value="">
							</div>
							<div class="form-group">
								<label for="new_password">Confirm new password</label>
								<input type="text" class="form-control" id="new_password" value="">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-default">Update passsword</button> <a href=''>Forgotten password?</a>
							</div>
						</form>
					</div>
				</div>
			</div> <!--END PANEL -->
			
			<div class="panel panel-default">
				<div class="panel-heading" style="background-image: linear-gradient(to bottom,#d9534f 0,#c12e2a 100%);"><strong style="color: white;">Delete account</strong></div>
				<div class="container"><br/>Deleting your account will only delete resources that have not been shared with other users. </div>
				<div class="row">
					<div class="col-xs-7" >
						<form class="form-horizontal" style="margin: 20px; margin-left: 40px;">
							<div class="form-group">
								<button type="submit" class="btn btn-danger">Delete your account</button>
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