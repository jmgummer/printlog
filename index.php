<?php
/*if (!session_id()) {
    @session_start();
}

if(empty($_SESSION['username']) && empty($_SESSION['user_id'])){
	header('Location: ../login.php');
	//exit;
}

$anvil = new Anvil;
$user_id = $_SESSION['user_id'];
$stationlist = $anvil->getAssignedStations($user_id);
// print_r($stationlist);exit;
$spotAds = $anvil->getSpotAds();
$manualAds = $anvil->getManualAds();

$companyList = $anvil->getCompanies();
// $presenterList = json_encode($anvil->getPresenters());
*/

$_SESSION['username'] = "Joseph Kinyua";

include 'autoloader.php';
$anvil = new Anvil;

//
$prints = $anvil->getPrint();

//echo "<pre>".print_r($print,1). "</pre>";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Print Log</title>

		<link rel="stylesheet" href="../public/css/bootstrap.min.css">
		<link rel="stylesheet" href="../public/css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="../public/css/font-awesome.min.css">
		<link rel="stylesheet" href="../public/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="../public/css/nouislider.min.css">
    	<link rel="stylesheet" href="../public/css/nouislider.pips.css">
    	<link rel="stylesheet" href="../public/css/nouislider.tooltips.css">
    	<link rel="stylesheet" href="../public/css/video-js.css">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="public/css/small.css">
		<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
		<!-- <link href="..css/select2.css" rel="stylesheet">
    	<link href="css/select2-bootstrap.css" rel="stylesheet">
    	<link href="css/select2Custom.css" rel="stylesheet"> -->
		
		<style type="text/css">
			.panel.form{box-shadow: none !important;}
			#log_date,#ajax_loader{z-index:1151 !important;}
			.select2-container{width: 100% !important;}
			.select2-selection,.select2-search__field{min-height: 30px !important;}
			.select2-search__field{width: auto !important;}
		</style>

		<script src="../public/js/jquery-1.11.3.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
	  	<div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        	<span class="sr-only">Toggle navigation</span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		      	</button>
		      	<div class="pull-right"><img src="../public/img/logo.png" style="height:50px;" alt="Reelforge"></div>
		    </div>

	    	<!-- Collect the nav links, forms, and other content for toggling -->
	    	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      		<ul class="nav navbar-nav navbar-right">
	      			<li class="dropdown">
		      			<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="nav-label">QC</span> <span class="fa fa-caret-down"></span></a>
		                <?php if(isset($_SESSION['level']) && ($_SESSION['level'] == 0 || $_SESSION['level'] == 1)): ?>
			                <ul class="dropdown-menu">
			                    <li><a href="../qc.php">Manage Incantations</a></li>
								<li><a href="../qc.php?type">Manage Clippings</a></li>
			                    <li><a href="../compliance.php">Manage Compliance</a></li>
					    <li><a href="../workload/index.php" target="_blank" >WorkLoad Analysis</a></li>
			                    <li><a href="index.php">Station Logs</a></li>
			                </ul>
		            <?php endif; ?>
	                </li>
	      			<!-- <li class="active"><a href="qc.php">QC<span class="sr-only">(current)</span></a></li> -->
	        		<li><a href="../index.php">TV</a></li>
	        		<li><a href="../radio.php">Radio</a></li>
	      			<li><a href="../print.php">Print</a></li>
	      			<!-- <li><a href="kb.php" target="_blank">KB</a></li> -->
	      			<li><a href="../logout.php">Logout (<?= $_SESSION['username']; ?>)</a></li>
	      		</ul>
	    	</div><!-- /.navbar-collapse -->
	  	</div><!-- /.container-fluid -->
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h3 class="pg-title">Print Logs Report</h3>
			</div>
			<div class="col-md-12">
				<?php //echo $msg->display(); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="show-hidden-menu">
					<div class="show-hidden-menu" >
						<h5 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseStations">Search Options (Expand / Collapse) <i class="fa fa-caret-down fa-fw pull-right"></i></a>
						</h5>
					</div>
				</div>
				<div class="hidden-menu" style="display: ;box-shadow:0em 0em 0.5em;background-color:#F8F8F8;">
					<form id="print_form" class="form-inline">
						<input type="hidden" name="ajax" value="1">
						<fieldset  class="menu_body">
							<div class="row">
								<div class="col-md-3">
									<table class="table table-borderless">
										<tr>
											<div id="row">
												<div class="col-md-6">
													<td>
														<input type="checkbox" name="adtype[]" value="1" class="adtype"> &nbsp;&nbsp;
														<label for="Advert" class="label_adtype">&nbsp;&nbsp;Advert</label>
													</td>
												</div>
												<div class="col-md-6">
													
													<td>
														<input type="checkbox" name="adtype[]" value="2" class="adtype"> &nbsp;&nbsp;
														<label for="Notice" class="label_adtype">&nbsp;&nbsp;Notice</label>
													</td>
												</div>
											</div>
										</tr>
									</table>
								</div>

								<div class="col-md-9">
									<table class="table table-borderless" >
									<?php
									$count = 0;
									foreach ($prints as $print) {
										$count++;
										$print_name = $print['Media_House_List'];
										$print_id = $print['Media_House_ID'];
										$print_code = $print['media_code'];

										//echo "<tr>";
										echo "<td><input type='checkbox' class='print' name='mediatype[]' value= '$print_code'>&nbsp;&nbsp;$print_name</td>";

										if($count == 4) {
											echo "</tr><tr>";
											$count = 0;
										}
										//$count ++;
									}

									?>
								</table>
								</div>
							</div>
						</fieldset>
						<div class="row">
							<div class="col-md-12">
								<div style="margin:10px" >
									<div class="row">
										<div class=" col-md-5">
        									<div class="input-group ">
            									<span class="input-group-addon">
            										<i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
            									</span>    
            									<input type="text" class="form-control" name="start_date" id="start_date" placeholder="Click To Select Start Date" readonly="">
        									</div>
										
											<div class="input-group ">
            									<span class="input-group-addon">
            										<i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
            									</span>    
            									<input type="text" class="form-control" name="end_date" id="end_date" placeholder="Click To Select End Date" readonly="">
        									</div>
										</div>
										<div class="col-md-3">
											<div class="row">
												<div class="col-md-4">
													<label><strong style="line-height:40px" class="pull-left">Group By:</strong></label>
												</div>
												<div class="col-md-4">
													 <div class="form-check" style="line-height:40px">
  														<input type="radio" class="form-check-input" value="Media_House_List" id="Station" name="group_by"required autocomplete="off" checked>
  														<label class="form-check-label" for="Station">Station</label>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-check" style="line-height:40px">
  														<input type="radio" class="form-check-input" value="brand_name" id="Brand" name="group_by" required autocomplete="off">
  														<label class="form-check-label" for="Brand">Brand</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<button type="submit" id="get_log" class="btn btn-primary pull-right" ><i class="fa fa-list-ul" aria-hidden="true"></i> Get Logs</button>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div><br>
		<div class='row' id='clipLegend' style="display: none;margin-left:15px">
			<div class='col-md-12'  style='margin:auto;'>
				<span class='label' style='border:solid 1px #eee;background:#ffffff;color:#000000;padding:5px;'>Active</span>
				<span class='label' style='border:solid 1px #eee;background:#FFCDD2;color:#000000;padding:5px;'>Inactive</span>
				<span class='label' style='border:solid 1px #eee;background:#ffffff;color:#000000;padding:5px;'><i class='fa fa-file-pdf-o fa-2x' style='color:green;'></i> Clip available</span>
				<span class='label' style='border:solid 1px #eee;background:#ffffff;color:#000000;padding:5px;'><i class='fa fa-file-pdf-o fa-2x' style='color:red;'></i> Clip Unavailable</span>
			</div>
		</div><br>
		<div class="row">
			<div class="clearfix panel panel-default" id="station_log_listing" style="max-height: 500px; overflow-y: scroll; display: none;">
						<!-- Content Goes In here -->
			</div>
		</div>
	</body>
	<script src="public/js/datepick/bootstrap-datepicker.js"></script>
    <script src="public/js/datepick/daterangepicker.js"></script>
	<script src="public/js/small.js"></script>
	<script src="public/js/alert.js"></script>
	<script src="public/js/promise-polyfill.js"></script>
	
	
	<script type="text/javascript">
		$(document).ready(function() {
		  
		});
	</script>
</html>