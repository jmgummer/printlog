<?php
class Anvil extends Dbmethods {
	public function __construct(){
		$this->dbconnect = Dbmethods::AnvilDbconnect();
		$this->dbconnect2 = Dbmethods::RmDbconnect();
		$this->dbconnect3 = Dbmethods::RPPDbconnect();
	}

	//Get all Print
	public function getPrint(){
		$con = $this->dbconnect2;

		$sq = "SELECT Media_House_ID,Media_House_List,media_code FROM mediahouse WHERE Media_ID = 'mp01'";
		$q = $con->query($sq);

		if($q && $q->num_rows > 0){
			while($row = $q->fetch_assoc()){
				$print[] = $row;
			}
			return $print;
		}else{
			$print = "No results";
			return [];
		
		}
	}

	//Validate Dates

	public function ValidateDate($startdate,$enddate){
		if (date('Y-m-d',strtotime($startdate)) > date('Y-m-d',strtotime($enddate))) {
			$msg =  "False";
		}elseif (date('Y-m-d',strtotime($startdate)) == date('Y-m-d',strtotime($enddate))) {
			$msg =  "True";
		} else {
			$msg =  "True";
		}
		
		return $msg;
	}
	//Editor
	public function GetEditor($id){
		$con = $this->dbconnect3;

		$sq = "SELECT username FROM users where user_id = '$id'";
		$q = $con->query($sq) or die("Error!!!<br>".$con->error);
		$row = $q->fetch_assoc();
		$editor = $row['username'];

		return $editor;
	}

	//Media Logs
	public function PrintLogs($adtype, $mediatype, $startdate, $enddate){
		$con = $this->dbconnect;

		$results = [];
		$sq = "
			SELECT auto_id,`date`,Media_House_List,brand_name,entry_type,print_table.media_code,`page`,ad_size,ave,`file`,crop,editor_id
			FROM print_table
			INNER JOIN brand_table ON  print_table.brand_id = brand_table.brand_id
			INNER JOIN mediahouse ON  print_table.media_code = mediahouse.media_code
			WHERE `date` BETWEEN '$startdate' AND '$enddate' 
			AND print_table.media_code IN ($mediatype)
			AND entry_type IN ($adtype)
			ORDER BY `date`,LENGTH(`page`),`page`
		";
		$q = $con->query($sq) or die("SQL ERROR!!!<br>".$con->error);
		while ($row = $q->fetch_assoc()) {
			$results[] = $row;
		}
		return $results;
	}

	public function Adtype($ad){
		switch ($ad) {
			case '1':
				$adtpe = 'Advert';
				return $adtpe;
				break;
			
			default:
				$adtpe = 'Notice';
				return $adtpe;
				break;
		}
	}

	public function DisplayResults($output,$group_by){
		$anvil = new Anvil;
		if (empty($output)) {
			echo "<div class='panel-body'><font color='red'><h5>No results found !</h5></font></div>";
		} else {
			$total = count($output);
			$result = [];

			$mediahouse = $output[0]['Media_House_List'];
			$startdate = "<strong>".$output[0]['date']."</strong>";
			$enddate = "<strong>".$output[$total-1]['date']."</strong>";
			
			echo "	<div class='col-md-12' style='border-bottom: 1px solid #DDD;'>
						
						
					</div>";
			
			echo "	<div class='col-md-12'><div class='panel-body'>

						<div id='accordion2' class='panel-group'>";
							

								echo "	<div class='panel-body'>
						
										<div class='col-md-12'>
											Records Found - $total<br>
											Station Log Report for <strong>$mediahouse </strong> for the Period:  $startdate - $enddate<hr>
										</div>

						

												<div class='col-md-12'>
													<table class='table table-condensed table-stripped table-bordered'>
														<thead>
															<tr>				
																<th>#</th>																<th>Date</th>
																<th>Page</th>
																<th>Ad Type</th>
																<th>Brand Name</th>
																<th>Ad Size</th>
																<th>AVE</th>
																<th>View Ad</th>
																<th>View Page</th>
																<th>Edit</th>
															</tr>
														</thead>
														<tbody>";
													//echo "<pre>".	print_r($output,1);
														$count=0;
									foreach ($output as $key => $value) {
										$count++;

										$view_page = "https://media.reelforge.com/player/view/?file=".$value['file']."&name=";
										echo "<tr data-toggle='tooltip' title= '".$anvil->GetEditor($value['editor_id'])."'>";
										echo "<td>$count</td>";
										echo "<td>".$value['date']."</td>";
										echo "<td>".$value['page']."</td>";
										echo "<td>".$anvil->Adtype($value['entry_type'])."</td>";
										echo "<td>".$value['brand_name']."</td>";
										echo "<td>".$value['ad_size']."</td>";
										echo "<td>".$value['ave']."</td>";
										echo "<td>".$value['crop']."</td>";
										echo "<td><a href = '$view_page' target='_blank'><i class='fa fa-file-pdf-o fa-2x' style='color:green;'></i></a></td>";
										echo "<td><a href = '#'>Edit</a></td>";
										echo "<tr>";
										
									}#end of Foreach
		}#end of empty($output)Else
		
	}#end
}

