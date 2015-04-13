<?php
	
	require_once('res/config.php');
	require_once('res/templates/header.php');

?>	
<!--Main body of form-->
<div class="row">
	<div style="margin: auto; max-width:510px;">
		<div class="well" >
			<!-- include for error handling -->
			<?php
				require(TEMPLATES_PATH.'/alerts.php');
				/*
				if initial setup hasnt been completed. this means host connection, database 
				and table creation
				*/
				if(SETUP == 'yes' && ADMIN =='yes'){
					if(isset($_GET['sign'])){
						$sign = $_GET['sign']; 
						switch ($sign){
							case 'login':
								echo '<h2 style="margin: auto;">Please sign in</h2><br>
									<form class="form-horizontal" action="'.SCRIPT_PATH.'/setup.php" method="post" enctype="multipart/form-data">
										<div class="form-group">
											<label for="username" class="col-sm-2 control-label">Username</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="username" autofill="no" placeholder="Enter username" required>
											</div>
										</div>
										<div class="form-group">
											<label for="password" class="col-sm-2 control-label">Password</label>
											<div class="col-sm-10">
												<input type="password" class="form-control" name="password" placeholder="Enter password" required>
											</div>
										</div>
										<input type="hidden" name="login" value="login"/>	
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="submit" class="btn btn-success">Log in</button>
												&nbsp;Click here to <a href="'.BASE_URL.'/form.php?sign=register">sign up</a>
											</div>
										</div>
									</form>';
									break;
								case 'register':
									//SIGN UP FORM FOR USER
									echo '<h2 style="margin: auto;">Please sign up</h2><br>
									<form class="form-horizontal" action="'.SCRIPT_PATH.'/setup.php" method="post" enctype="multipart/form-data">
										<div class="form-group">
											<label for="username" class="col-sm-2 control-label">Username</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="username" autofill="no" placeholder="Enter username" required>
											</div>
										</div>
										<div class="form-group">
											<label for="email" class="col-sm-2">Email</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" name="email" placeholder="Enter email" autocomplete="off" required>
											</div>
										</div>
										<div class="form-group">
											<label for="password" class="col-sm-2 control-label">Password</label>
											<div class="col-sm-10">
												<input type="password" class="form-control" name="password" placeholder="Enter password" required>
											</div>
										</div>
										<input type="hidden" name="register" value="register"/>	
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="submit" class="btn btn-primary">Sign up</button>
												&nbsp;Click here to <a href="'.BASE_URL.'/form.php?sign=login">log in</a>
											</div>
										</div>
									</form>';

									break;
							} 
					}//end if set SIGN 
				} else {
					if(SETUP == "no" || SETUP == ''){
						echo '<h2 style="margin: auto;">Installation Wizard</h2><br />
						<p>
							A database is required for functions of the tool. Fill in the following form to create a database or connect to an existing one.
						</p>
						<form action="'.SCRIPT_PATH.'/setup.php" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="host">Host name</label> 
								<input type="text" class="form-control" name="host" value="localhost" required>
							</div>
							<div class="form-group">
								<label for="database">Database name</label>
								<input type="text" class="form-control" name="database" value="Cassandra" required>
							</div>
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" class="form-control" name="username" value="root" required>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" name="password" value="">
							</div>
								<input type="hidden" name="createDatabase" value="create"/>	
							<button type="submit" class="btn btn-default">Install</button>
						</form>'; 
					} else if ((SETUP == 'yes' && (ADMIN =='no' || ADMIN ==''))) {
						echo '<h2 style="margin: auto;">Installation Wizard</h2><br />
						<p>
							A super user is required for administrative roles within Cassandra.
						</p>
							<form action="'.SCRIPT_PATH.'/setup.php" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" class="form-control" name="username" value="admin" required>
								</div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" placeholder="Enter email" required autocomplete="off">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="password" placeholder="Enter password" required autocomplete="off">
								</div>
								<input type="hidden" name="register" value="add"/>	
								<button type="submit" class="btn btn-default">Create account</button>
							</form>';
						} // end admin setup
					}//end if else for SETUP AND ADMIN == YES
			?>
		</div>
	</div>
</div>
<?php
	require_once(TEMPLATES_PATH.'/footer.php');
?>