<?php
	return array (
			"table_source" => '<div class="row">
								<div class="col-md-8">
									<h3 class="panel-title">Data Sources</h3>
								</div>
								<div class="col-md-4">
									<div class="text-right">
										<a href="#" data-toggle="tooltip" title="Connect to a remote database table">
											<span data-toggle="modal" data-target="#myModal" class="glyphicon glyphicon-cd" aria-hidden="true" style="font-size: 1.3em;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="font-size: 0.7em; position: relative; top: -10px; left: -5px; color: #9ACD32;"></span>
										</a>
										<a href="#" data-toggle="tooltip" title="Upload a CSV file">
											<span data-toggle="modal" data-target="#fileUpload" class="glyphicon glyphicon-file" aria-hidden="true" style="font-size: 1.3em;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="font-size: 0.7em; position: relative; top: -10px; left: -5px; color: #9ACD32;"></span></span>
										</a>
									</div>
								</div>
							</div>',
			"table_statistic" => "<h3 class='panel-title'>Source Statistics</h3>",
			"table_model" => "<h3 class='panel-title'>Learned Models</h3>",
			"table_prediction" => "<h3 class='panel-title'>Model Predictions</h3>",
			"resource_source" => '<div class="row">
								<div class="col-md-8">
									<h3 class="panel-title">'.$name.'</h3>
								</div>
								<div class="col-md-4">
									<div class="text-right">
										<a href="'.SCRIPT_PATH.'/resource-scripts.php?process=source&resource='.$resource_id.'" data-toggle="tooltip" title="Process data to obtain statistics">
											<span data-toggle="modal" data-target="#processSource" class="glyphicon glyphicon-dashboard" aria-hidden="true" style="font-size: 1.3em;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="font-size: 0.7em; position: relative; top: -10px; left: -5px; color: #9ACD32;"></span></span>
										</a>
									</div>
								</div>
							</div>',
			"resource_statistic" => '<div class="row">
								<div class="col-md-8">
									<h3 class="panel-title">'.$name.'</h3>
								</div>
								<div class="col-md-4">
									<div class="text-right">
										<a href="'.SCRIPT_PATH.'/resource-scripts.php?process=source&resource='.$resource_id.'" data-toggle="tooltip" title="Process statistic to create a model">
											<span data-toggle="modal" data-target="#processSource" class="glyphicon glyphicon-flash" aria-hidden="true" style="font-size: 1.3em;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="font-size: 0.7em; position: relative; top: -10px; left: -5px; color: #9ACD32;"></span></span>
										</a>
									</div>
								</div>
							</div>',
			"resource_model" => '',
			"resource_prediction" => ''	
		);

?>