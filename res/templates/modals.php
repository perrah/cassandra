<!-- MODAL UNITS -->
	<!-- modal for file upload -->
	<div class="modal fade" id="fileUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">File upload</h4>
		  </div>
		  <div class="modal-body">
			<form action="<?php echo SCRIPT_PATH; ?>/resource-scripts.php" method="post" enctype="multipart/form-data">
			<input type="file" name="file" size="50" />	
			<input type="hidden" name="uploadFile" value="">	
			<p class="help-block">Select a file to upload as a source (CSV).</p>		
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-primary" value="Upload" />
			</form>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- modal for PROCESS deletion -->
	<div class="modal fade" id="processResource" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Process Resource</h4>
		  </div>
		  <div class="modal-body">
			<form action="<?php echo SCRIPT_PATH; ?>/resource-scripts.php" method="post" enctype="multipart/form-data">
			<input type="hidden" id="processResourceField" name="resourceId" value="">	
			<input type="hidden" id="processResourceUser" name="resourceUser" value="">
			<input type="hidden" id="processResourcePage" name="process" value="">
			<input type="hidden" id="processResourceName" name="resourceName" value="">
			<p class="help-block">Please <strong>select a classifier</strong> from the drop down selection. Alternatively leave as default and the last field in your data set will be used.</p>
			<select class="form-control" id="classifierSelection" name="classifier"> 
			  <!-- javascript below to get list of attributes-->
			</select>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-success" value="Process" />
			</form>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- modal for resource DELETION -->
	<div class="modal fade" id="deleteResource" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Delete Resource</h4>
		  </div>
		  <div class="modal-body">
			<form action="<?php echo SCRIPT_PATH; ?>/resource-scripts.php" method="post" enctype="multipart/form-data">
			<div id="deleteAlert" class="alert alert-warning" role="alert" style="display: none;">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<span class="sr-only">Warning</span>
				&nbsp; <strong>Warning!</strong> This resource has been shared with other users.
			</div>
			<input type="hidden" id="deleteResourceField" name="resourceId" value="">	
			<input type="hidden" id="deleteResourcePage" name="resourcePage" value="">
			<input type="hidden" id="deleteResourceName" name="resourceName" value="">
			<input type="hidden" id="deleteResourcePermissions" name="resourcePermissions" value="">
			<input type="hidden" id="deleteResourceUser" name="resourceUser" value="">
			<input type="hidden" name="deleteResource" value="">
			<p class="help-block">To delete a resource click the button below.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-danger" value="Delete" />
			</form>
		  </div>
		</div>
	  </div>
	</div>
	
	
	<!-- modal for resource SHARING -->
	<div class="modal fade" id="shareResource" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Share Resource</h4>
		  </div>
		  <div class="modal-body">
			<form action="<?php echo SCRIPT_PATH; ?>/resource-scripts.php" method="post" enctype="multipart/form-data">
			<p class="help-block">To share a resource please type the users username in the text box below.</p>	
			<input type="text" class="form-control" name="username" placeholder="Enter a username" required>
			<input type="hidden" id="shareResourceField" name="resourceId" value="">	
			<input type="hidden" id="shareResourcePage" name="resourcePage" value="">
			<input type="hidden" name="shareResource" value="">
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-primary" value="Share" />
			</form>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- END MODAL UNITS -->