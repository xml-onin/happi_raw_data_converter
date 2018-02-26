<?php
ini_set('memory_limit','-1');
include "../app/connect.php";
date_default_timezone_set('Asia/Manila');




/*function LoadCol(){
	include "../app/connect.php";
	$qry = "SELECT * FROM happi_tb ORDER BY question_id";
	$res = $con->query($qry);
	while ($row = $res->fetch_assoc()) {
		$column[0] = 'ID';
		$column[1] = 'Gender';
		$column[2] = 'Age';

		$column[3] = 'Marital Status';
		$column[4] = 'Occupation';
		$column[5] = 'Household Income';
		$column[6] = 'Region';
		$column[7] = 'City';

		$column[8] = 'partner';
		$column[9] = 'Source';
		$column[] = $row['question_id'];
	}

	$output = fopen("php://output","w");
	fputcsv($output, $column);
	
}
LoadCol();*/

include "load_csv.php";


fclose($output);

function delete(){
	include "../app/connect.php";
	$sql = "DELETE FROM happi_tb";
	if ($con->query($sql)) {
			
		}
		else{
			echo $con->error;
		}
	}
/*delete();*/
?>