<?php

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=happi_exported_file.csv');

LoadAll();
function LoadAll(){
	include "../app/connect.php";

	$sql = "SELECT DISTINCT id FROM happi_tb";
	$ress = $con->query($sql);

	while ($roww = $ress->fetch_assoc()) {
		$id = $roww['id'];
		Insert($id);
	}
	
}



function Insert($id){

	include"../app/connect.php";

	$sql = "SELECT * FROM happi_tb WHERE id='$id'";

	$qid = "";
	$ans = "";
	$partner = "";
	$age = "";
	$gender = "";
	$nationality = "";
	$country = "";

	
	$res = $con->query($sql);
	while($row = $res->fetch_assoc()){
		$gender = $row['gender'];
		$age = $row['age']; 
		$nationality = $row['nationality'];
		$country = $row['country'];
		$partner = $row['partner_name'];
		$campaign = $row['campaign_name'];
		$ans[0] = $id;
		$ans[1] = $gender;
		$ans[2] = $age;
		$ans[3] = $country;
		$ans[4] = $nationality;
		$ans[5] = $partner;
		$ans[6] = $campaign;
		$ans[] = $row['question_id']." - ".$row['test_answer'];	
		
	}
	$arr[] = $id;
	

	$output = fopen("php://output","w");
	
	fputcsv($output, $ans);
	


}
?>