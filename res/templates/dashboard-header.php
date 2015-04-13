<!-- SECONDARY NAVBAR CONTAINER -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand">Dashboard</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li <?php if($dashboard_page == 'source'){ echo 'class="active"'; }?> ><a href="<?php echo BASE_URL; ?>/dashboard.php?page=source">Sources</a></li>
			<li <?php if($dashboard_page == 'statistic'){ echo 'class="active"'; }?> ><a href="<?php echo BASE_URL; ?>/dashboard.php?page=statistic">Statistics</a></li>
			<li <?php if($dashboard_page == 'model'){ echo 'class="active"'; }?> ><a href="<?php echo BASE_URL; ?>/dashboard.php?page=model">Models</a></li>
			<li <?php if($dashboard_page == 'prediction'){ echo 'class="active"'; }?> ><a href="<?php echo BASE_URL; ?>/dashboard.php?page=prediction">Predictions</a></li>
		  </ul>
		  <form class="navbar-form navbar-right" role="search">
			<div class="form-group">
			  <input type="text" class="form-control" placeholder="Search">
			  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</div>
		  </form>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav> 
<!-- END SECONDARY NAVIGATION -->