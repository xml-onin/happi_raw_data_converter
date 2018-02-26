<?php
GetID();

$ans[] = array();
function GetID(){
	include "../app/connect.php";
	$sql = "SELECT DISTINCT id FROM happi_tb";
	$ress = $con->query($sql);
	while ($roww = $ress->fetch_assoc()) {
		$id = $roww['id'];
		GetQid($id);
	}
	
}

function GetQid($idd){
	include"../app/connect.php";
	$distinct_qid = "SELECT DISTINCT question_id FROM happi_tb";
	$res_qid = $con->query($distinct_qid);
	while ($roww = $res_qid->fetch_assoc()) {
		$id = $roww['question_id'];
		ShowAns($id,$idd);
	}
}

function ShowAns($qid,$id){
	include"../app/connect.php";
	$distinct_qid = "SELECT * FROM happi_tb WHERE question_id='$qid' AND id='$id'";
	$res_qid = $con->query($distinct_qid);
	while ($roww = $res_qid->fetch_assoc()) {
		$ans[] = $roww['text_answer'];
	}
	$output = fopen("php://output","w");
	fputcsv($output, $ans);
}


?>