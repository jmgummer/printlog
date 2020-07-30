<?php

include 'autoloader.php';
$anvil = new Anvil;
if (isset($_POST) && !empty($_POST['start_date']) && $_POST['end_date'] != ''  && $_POST['ajax'] == '1') {
	//Print Log
	//echo "<pre>".print_r($_POST,1);
		$adtype = $_POST['adtype'];
		$mediatype = $_POST['mediatype'];
		$startdate = $_POST['start_date'];
		$enddate = $_POST['end_date'];
		$group_by = $_POST['group_by'];

		$adtype = json_encode($adtype);
		$adtype = str_replace('[','', $adtype);
		$adtype = str_replace(']','', $adtype);

		$mediatype = json_encode($mediatype);
		$mediatype = str_replace('[','', $mediatype);
		$mediatype = str_replace(']','', $mediatype);

		$output = [];
		$validate_date =  $anvil->ValidateDate($startdate,$enddate);
		if ($validate_date == "True") {
			$output = $anvil->PrintLogs($adtype, $mediatype, $startdate, $enddate);
		} else {
			$output = "
				Please Check Your Data;
			";
			
		}

		//Check Number of mediahouse
		if(count($mediatype) == 1 && $group_by == 'Media_House_List'){
				if (is_array ($output)) {
					$anvil->DisplayResults($output,$group_by);
				} else {
					$anvil->DisplayError($output);
				}
		}
		
		
			//echo "$msg";
		

		//echo"<pre>". print_r($output,1) ;
//End Of Generating Print Log
} /*else if(){
	//Some Else
} else if(){
	//Some Else
}*/ else {
	echo "<div class = 'alert alert-danger'>Please Contact System Admin.<div>";
}
