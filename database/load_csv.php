<?php
date_default_timezone_set('Asia/Manila');
$date = date("H:i:sA");
header('Content-Type: application/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=download'.$date.'.csv');
header( "Pragma: no-cache" );
header( "Expires: 0" );
//set unlimited memory limit in php ini overides
ini_set('memory_limit','-1');
	include "../app/connect.php";
//set time limit set to 0 this will overides the php ini
set_time_limit(0);

$nouser = $_POST['nousers'];
$start = $_POST['start'];
$end = $_POST['end'];
$repeat = $_POST['no_repeat'];

if ($nouser == '') {
	$column[0] = 'ID';
	$column[1] = 'GENDER';
	$column[2] = 'AGE';

	$column[3] = 'MARITAL STATUS';
	$column[4] = 'OCCUPATION';
	$column[5] = 'HOUSEHOLD INCOME';
	$column[6] = 'REGION';
	$column[7] = 'CITY';

	$column[8] = 'PARTNER';
	$column[9] = 'SOURCE';
	$qry_qid_row = "SELECT DISTINCT question_id FROM happi_tb WHERE question_id ORDER BY question_id ASC";
	$res_qid_row = $con->query($qry_qid_row);
	while($row_qid = $res_qid_row->fetch_assoc()){
		for ($i=0; $i < 5; $i++) { 
			$column[] = $row_qid['question_id'];
		}
	}
	$output = fopen("php://output","w");
	fputcsv($output, $column);
	LoadAlll();
}
else{
	$column[0] = 'ID';
	$column[1] = 'GENDER';
	$column[2] = 'AGE';

	$column[3] = 'MARITAL STATUS';
	$column[4] = 'OCCUPATION';
	$column[5] = 'HOUSEHOLD INCOME';
	$column[6] = 'REGION';
	$column[7] = 'CITY';

	$column[8] = 'PARTNER';
	$column[9] = 'SOURCE';
	$qry_qid_row = "SELECT DISTINCT question_id FROM happi_tb WHERE question_id BETWEEN '$start' AND '$end' ORDER BY question_id ASC";
	$res_qid_row = $con->query($qry_qid_row);
	while($row_qid = $res_qid_row->fetch_assoc()){
		for ($i=0; $i < $repeat; $i++) { 
			$column[] = $row_qid['question_id'];
		}
	}
	$output = fopen("php://output","w");
	fputcsv($output, $column);
	LoadAll();
}


//this will loop every id to put in csv and download
function LoadAll(){
	global $nouser;
	include "../app/connect.php";
	$sql = "SELECT DISTINCT id FROM happi_tb LIMIT 0,".$nouser."";
	$ress = $con->query($sql);
	while ($roww = $ress->fetch_assoc()) {
		$id = $roww['id'];
		Insert($id);
	}
}


//FUNCTION FOR CSV WRITING
function Insert($id){
	//connectinons
	include"../app/connect.php";
	$sql = "SELECT * FROM happi_tb WHERE id='$id'";

	//global VARS
	global $nouser;
	global $start;
	global $end;
	global $repeat;

	//local VARS
	$qid = "";
	$ans = "";
	$partner = "";
	$age = "";
	$gender = "";
	$marital = "";
	$occupation = "";
	$income = "";
	$region = "";
	$city = "";

	$res = $con->query($sql);

	//GETS THE MARITAL STATUS
	$sql_marital = "SELECT * FROM happi_tb WHERE question_id='58' AND id='$id'";
	$marital_res = $con->query($sql_marital);
	while ($marital_row = $marital_res->fetch_assoc()) {
		$marital = $marital_row['text_answer'];
	}

	//GETS THE OCCUPATION
	$sql_occupation = "SELECT * FROM happi_tb WHERE question_id='160' AND id='$id'";
	$occupation_res = $con->query($sql_occupation);
	while ($occupation_row = $occupation_res->fetch_assoc()) {
		$occupation = $occupation_row['text_answer'];
	}

	//GETS THE HOUSEHOLD INCOME
	$sql_income = "SELECT * FROM happi_tb WHERE question_id='64' AND id='$id'";
	$income_res = $con->query($sql_income);
	while ($income_row = $income_res->fetch_assoc()) {
		$income = $income_row['text_answer'];
	}

	//GETS THE REGION
	$sql_region = "SELECT * FROM happi_tb WHERE question_id='59' AND id='$id'";
	$region_res = $con->query($sql_region);
	while ($region_row = $region_res->fetch_assoc()) {
		$region = $region_row['text_answer'];
	}

	//GET THE CITY
	$sql_city = "SELECT * FROM happi_tb WHERE question_id='906' AND id='$id'";
	$city_res = $con->query($sql_city);
	while ($city_row = $city_res->fetch_assoc()) {
		$city = $city_row['text_answer'];
	}

	//write static information in an array 
	while($row = $res->fetch_assoc()){
		$ans[0] = $id;
		$ans[1] = $row['gender'];
		$ans[2] = $row['age'];
		$ans[3] = $marital;
		$ans[4] = $occupation;
		$ans[5] = $income;
		$ans[6] = $region;
		$ans[7] = $city;
		$ans[8] = $row['partner_name'];
		$ans[9] = $row['source'];
	}

	// --- THIS SECTION IS MY ALGO TO WRITE EVERY COLUMN AND ANSWER IN RIGHT COLUMNS :)
	//select * id and remove all the duplicates
	$qry_qid_row = "SELECT DISTINCT question_id FROM happi_tb WHERE question_id BETWEEN '$start' AND '$end' ORDER BY question_id ASC";
	$res_qid_row = $con->query($qry_qid_row);
	
	//loop the query to get all the question_id's
	while($row_qid = $res_qid_row->fetch_assoc()){
		$column = $row_qid['question_id'];
		$sql_query = "SELECT text_answer FROM happi_tb WHERE question_id='$column' AND id='$id'";
		$res_qryy = $con->query($sql_query);
		if ($res_qryy->num_rows > 0) {
			for ($i=0; $i < $repeat; $i++) { 
				if ($row_queryy = $res_qryy->fetch_assoc()) {
					$ans[] = $row_queryy['text_answer'];
				}
				else{ 
					$ans[] = '';
				}
			}
		}
		else{
			unset($ans);
			$ans[0] = 'undefined';
		}
	}

//check if the row is empty and it will not write it on csv
if ($ans[0] == 'undefined') {
	
}
else{
	//write it in a csv file using php
	$output = fopen("php://output","w");
	fputcsv($output, $ans);
	flush();
	fclose($output);
}
	


}






//this will loop every id to put in csv and download
function LoadAlll(){
	global $nouser;
	include "../app/connect.php";
	$sql = "SELECT DISTINCT id FROM happi_tb";
	$ress = $con->query($sql);
	while ($roww = $ress->fetch_assoc()) {
		$id = $roww['id'];
		Insertt($id);
	}
}

//FUNCTION FOR CSV WRITING
function Insertt($id){
	//connectinons
	include"../app/connect.php";
	$sql = "SELECT * FROM happi_tb WHERE id='$id'";

	//local VARS
	$qid = "";
	$ans = "";
	$partner = "";
	$age = "";
	$gender = "";
	$marital = "";
	$occupation = "";
	$income = "";
	$region = "";
	$city = "";

	$res = $con->query($sql);

	//GETS THE MARITAL STATUS
	$sql_marital = "SELECT * FROM happi_tb WHERE question_id='58' AND id='$id'";
	$marital_res = $con->query($sql_marital);
	while ($marital_row = $marital_res->fetch_assoc()) {
		$marital = $marital_row['text_answer'];
	}

	//GETS THE OCCUPATION
	$sql_occupation = "SELECT * FROM happi_tb WHERE question_id='160' AND id='$id'";
	$occupation_res = $con->query($sql_occupation);
	while ($occupation_row = $occupation_res->fetch_assoc()) {
		$occupation = $occupation_row['text_answer'];
	}

	//GETS THE HOUSEHOLD INCOME
	$sql_income = "SELECT * FROM happi_tb WHERE question_id='64' AND id='$id'";
	$income_res = $con->query($sql_income);
	while ($income_row = $income_res->fetch_assoc()) {
		$income = $income_row['text_answer'];
	}

	//GETS THE REGION
	$sql_region = "SELECT * FROM happi_tb WHERE question_id='59' AND id='$id'";
	$region_res = $con->query($sql_region);
	while ($region_row = $region_res->fetch_assoc()) {
		$region = $region_row['text_answer'];
	}

	//GET THE CITY
	$sql_city = "SELECT * FROM happi_tb WHERE question_id='906' AND id='$id'";
	$city_res = $con->query($sql_city);
	while ($city_row = $city_res->fetch_assoc()) {
		$city = $city_row['text_answer'];
	}

	//write static information in an array 
	while($row = $res->fetch_assoc()){
		$ans[0] = $id;
		$ans[1] = $row['gender'];
		$ans[2] = $row['age'];
		$ans[3] = $marital;
		$ans[4] = $occupation;
		$ans[5] = $income;
		$ans[6] = $region;
		$ans[7] = $city;
		$ans[8] = $row['partner_name'];
		$ans[9] = $row['source'];
	}

	// --- THIS SECTION IS MY ALGO TO WRITE EVERY COLUMN AND ANSWER IN RIGHT COLUMNS :)
	//select * id and remove all the duplicates
	$qry_qid_row = "SELECT DISTINCT question_id FROM happi_tb WHERE question_id ORDER BY question_id ASC";
	$res_qid_row = $con->query($qry_qid_row);
	
	//loop the query to get all the question_id's
	while($row_qid = $res_qid_row->fetch_assoc()){
		$column = $row_qid['question_id'];
		$sql_query = "SELECT text_answer FROM happi_tb WHERE question_id='$column' AND id='$id'";
		$res_qryy = $con->query($sql_query);
		if ($res_qryy->num_rows > 0) {
			for ($i=0; $i < 5; $i++) { 
				if ($row_queryy = $res_qryy->fetch_assoc()) {
					$ans[] = $row_queryy['text_answer'];
				}
				else{ 
					$ans[] = '';
				}
			}
		}
		else{
			unset($ans);
			$ans[0] = 'undefined';
		}
	}

//check if the row is empty and it will not write it on csv
if ($ans[0] == 'undefined') {
	
}
else{
	//write it in a csv file using php
	$output = fopen("php://output","w");
	fputcsv($output, $ans);
	flush();
	fclose($output);
}
	


}



?>