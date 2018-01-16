<?php

$qry = "";

date_default_timezone_set('Asia/Manila');

$output = fopen("php://output","w");

$questionid[0] = 'ID';
$questionid[1] = 'Gender';
$questionid[2] = 'Age';
$questionid[3] = 'country';
$questionid[4] = 'nationality';
$questionid[5] = 'partner';
$questionid[6] = 'Campaign Name';
fputcsv($output, $questionid);
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
delete();
?>