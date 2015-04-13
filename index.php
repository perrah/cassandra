<?php
require_once('res/config.php');	
require_once(TEMPLATES_PATH.'/header.php');	

?>	

<div class="well">
		<div class="page-header">
			<h1 style="margin-top: -30px;">Cassandra Data Mining <p></p>
				<p><small>Welcome to Cassandra Data Mining a simple tool that provides simple Data Mining techniques to your business. With the help of Cassandra your business will be able to analyse data remotely on any device with an internet connection. Being more informed with your data allows your business to make accurate predictive decision making.</small></p>
			</h1><br>
				<?php 
					if(SETUP == "yes" && ADMIN == "yes"){
					echo '<a href="'.BASE_URL.'/dashboard.php" class="btn btn-success">View Dashboard &raquo;</a>';}
					else{echo '<p>Follow the Installation Wizard to install the tool on your business server.</p>
					<a href="'.BASE_URL.'/form.php?setup=install" class="btn btn-primary">Installation Wizard &raquo;</a>'; }
				?>
			</span>
		</div>
</div>
		
		<div class="row">
			<?php
				//checks to see if a log has been sent through with page change and prints at the top to alert the user.
				require_once(TEMPLATES_PATH.'/alerts.php');
			?>
			<div class="col-lg-4">
				<img src="">
				<h2>More Information</h2>
				<p>Cassandra is a tool that provides basic data mining techniques to your business. For more information on Cassandra and what the tool provides click the link below to be taken to an overview.</p>
				<p>Documentation for Cassandra is also available through the following link or can be accessed via the main navigation bar under Documentation.</p>
				<a class="btn btn-primary">Cassandra Overview &raquo;</a>
			</div>
			<div class="col-lg-4">
				<?php 
					if((SETUP == "no" || ADMIN == "no")||(SETUP == "" || ADMIN == "")){
						echo '<img src="">
						<h2>Installation wizard</h2>
						<p>The installation wizard will take you through setup of the Cassandra tool on your business server, This includes database, admin and file directory creation.</p>
						<p>You will be required to enter database information during this process anbd require host, username and password with write access rights.</p>
						<a href="'.BASE_URL.'/form.php?setup=install" class="btn btn-primary">Installation Wizard &raquo;</a>';
					} else { 
						echo '<img src="">
						<h2>Your Account</h2>
						<p>Cassandra allows indiviual employees to have unique accounts that hold user specific data and models. Users have the ability to share other data with other users.</p>
						<p>For more information on whats avaiable within Cassandra please refer to the documentation.</p>';
						if(isset($_SESSION['login_user_id'])){
							echo '<a href="'.BASE_URL.'/setup/profile.php" class="btn btn-primary">View Account &raquo;</a>';
						} else {
							echo '<a href="'.BASE_URL.'/form.php?sign=create" class="btn btn-primary">Create Account &raquo;</a>';
						}
					}
				?>
			</div>
			<!-- Optional: clear the XS cols if their content doesn't match in height -->
			<div class="clearfix visible-xs-block"></div>
			<div class="col-lg-4">
				<img src="">
				<h2>Developers</h2>
				<p>Once Cassandra has been installed onto a business server API's can be provided to allow 3rd party application access to the logic and algorithms behind the scenes.</p>
				<p>This means your business is able to create it's own applications and user interface on other servers but use Cassandra for its application logic.</p>
				<button type="button" class="btn btn-primary">Developer's Tools &raquo;</button>
			</div>
		</div><!-- /row-->

<?php
	require_once(TEMPLATES_PATH.'/footer.php');
?>