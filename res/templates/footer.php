    </div> <!-- /container -->
	
	<?php require_once(TEMPLATES_PATH.'/modals.php'); ?>
	
	<!-- FOOTER -->

	<footer class="footer">
	  <div class="container">
		<p></p>
		<p class="pull-right"><a href="#">Back to top</a></p>
		<p>&copy; 2015 Cassandra. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
	  </div>
	</footer>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo PUBLIC_PATH ?>/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo PUBLIC_PATH; ?>/js/bootstrap.min.js"></script>
	
	<!--JavaScript -->
	<script>
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip({html: true})
		});
		
		$(document).ready(function () {
			$('#myModal').on('shown.bs.modal', function () {
				$('#myInput').focus();
	
	
			})
			//function to pass resource id for deletion and to check if resource has been shared if so display warning
			 $(".deleteButton").click(function () {
				var id = $(this).data('id');
				var count = $(this).data('usercount');
				var name = $(this).data('name');
				var page = $(this).data('page');
				var permissions = $(this).data('permissions');
				var user = $(this).data('user');
				document.getElementById('deleteResourceField').value=id;
				document.getElementById('deleteResourceName').value=name;
				document.getElementById('deleteResourcePage').value=page;
				document.getElementById('deleteResourcePermissions').value=permissions;
				document.getElementById('deleteResourceUser').value=user;
				if(count > 1 && permissions == 100){
					document.getElementById('deleteAlert').style.display="";
				} else {
					document.getElementById('deleteAlert').style.display="none";
				}
			 })
			 //function to share resource data information
			 $(".shareButton").click(function () {
				var id = $(this).data('id');
				var page = $(this).data('page');
				document.getElementById('shareResourceField').value=id;
				document.getElementById('shareResourcePage').value=page;
			 })
			 //function to process resource data information
			 $(".processButton").click(function () {
				var id = $(this).data('id');
				var name = $(this).data('name');
				var page = $(this).data('page');
				var user = $(this).data('user');
				var selectors = $(this).data('selectors');
				document.getElementById('processResourceField').value=id;
				document.getElementById('processResourceName').value=name;
				document.getElementById('processResourcePage').value=page;
				document.getElementById('processResourceUser').value=user;
				document.getElementById("classifierSelection").innerHTML = '<option value="Default">Default</option>' + selectors;
			 })
			
		});  
		
	</script>
	
	<?php echo '<script src="'.PUBLIC_PATH.'/js/Chart.js"></script>'; ?>
  </body>
</html>