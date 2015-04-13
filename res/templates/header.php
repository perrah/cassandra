<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cassandra Data Mining Tool</title>

    <!-- Bootstrap -->
    <link href="<?php echo PUBLIC_PATH;?>/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap theme -->
    <link href="<?php echo PUBLIC_PATH;?>/css/bootstrap-theme.min.css" rel="stylesheet">
	
	<style>
		html {
		  position: relative;
		  min-height: 100%;
		}
		body {
		  padding-top: 70px;
		  padding-bottom: 30px;
		  /* Margin bottom by footer height */
		  margin-bottom: 60px;
		}

		.theme-dropdown .dropdown-menu {
		  position: static;
		  display: block;
		  margin-bottom: 20px;
		}

		.theme-showcase > p > .btn {
		  margin: 5px 0;
		}

		.theme-showcase .navbar .container {
		  width: auto;
		}
		.footer {
		  position: absolute;
		  bottom: 0;
		  width: 100%;
		  /* Set the fixed height of the footer here */
		  height: 60px;
		  background-color: #dddddd;
		}
body.modal-open-noscroll
    {
        margin-right: 0!important;
        overflow: none;
    }
    .modal-open-noscroll .navbar-fixed-top, .modal-open .navbar-fixed-bottom
    {
          margin-right: 15px;
    }
	</style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<!-- Main navigation bar holding important links to home, dashboard, documentation and user profiles -->
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php" style="margin-top: -6px; margin-right: -6px;">
			<img alt="Brand" src="<?php echo PUBLIC_PATH; ?>/img/orb-icon.png" width="30">
		  </a>
          <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">Cassandra</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<li><a href="<?php echo BASE_URL; ?>/dashboard.php">Dashboard</a></li>
			<li><a href="<?php echo BASE_URL; ?>">Documentation</a></li>
            <li><a href="<?php echo BASE_URL; ?>">Contact</a></li>
          </ul>
		  
			<?php 
			if(isset($_SESSION['user_id'])){
				echo '
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;'.$_SESSION['username'].' <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="'.BASE_URL.'/profile.php?page=user"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;Profile</a></li>
								<li><a href="'.BASE_URL.'/profile.php?page=tasks"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;User tasks</a></li>
								<li><a href="'.BASE_URL.'/profile.php?page=settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;&nbsp;Settings</a></li>
								<li class="divider"></li>								
								<li><a href="'.SCRIPT_PATH.'/setup.php?logout=1"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Log out</a></li>
							</ul>
						</li>
						
					</ul>';
			}else if(SETUP == "yes" && ADMIN == "yes"){ 
				echo '<div class="navbar-form navbar-right">
						<a href="'.BASE_URL.'/form.php?sign=login" class="btn btn-success btn-sm">Log in</a> 
						<a href="'.BASE_URL.'/form.php?sign=register" class="btn btn-primary btn-sm">Sign up</a>
					  </div>';
			}
			?>
		  
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
	<!-- Start of the container holding the body of content -->
	<div class="container theme-showcase" role="main">