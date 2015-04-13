<?php
require_once('res/config.php');	
require_once(TEMPLATES_PATH.'/header.php');	
if(isset($_GET['page'])){
	$page = $_GET['page'];
} else {
	$page = 'user';
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
		<!--holds main content -->
		<div class="col-xs-12 col-sm-9">
			<?php 
				$display = new User();
				$display->viewProfile($page);
			?>
		</div>
  </div>
</div>
<?php
	require_once(TEMPLATES_PATH.'/footer.php');
?>