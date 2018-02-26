

<?php

session_start();


include"../app/connect.php";


$id = "";
$uid = "";

$th = "";
$td = "";

$ss = "";
echo "<table class=\"ui fixed celled selectable table\" id=\"tableData\" style=\"width: 95%;\">
	<thead>
	<tr><th>ID</th><th>Age</th><th>Gender</th><th>Nationality</th><th>Country</th><th>Partner Name</th><th>Campaign Name</th></tr>
	</thead><tbody>

	";
LoadAll();

$duplic = "";
$sql = "SELECT DISTINCT id FROM happi_tb";
$ress = $con->query($sql);
$duplic =  $ress->num_rows;


//function to get only ID and not all duplicates and call Loadinfo to get all the information needed
function LoadAll(){
	include "../app/connect.php";

	$sql = "SELECT DISTINCT id FROM happi_tb";
	$ress = $con->query($sql);

	while ($roww = $ress->fetch_assoc()) {
		$id = $roww['id'];
		LoadInfo($id);
		/*Insert($id);*/
		
	}
	
}



/*function Insert($id){

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
		$ans[] = $row['test_answer'];
	
	}
	$arr[] = $id;
	$ans[0] = $id;
	$ans[1] = $gender;
	$ans[2] = $age;
	$ans[3] = $country;
	$ans[4] = $nationality;
	$ans[5] = $partner;
}*/

//use this function to generate id information from LoadAll Function just to remove duplicate ID's
function LoadInfo($id){

	include"../app/connect.php";

	$sql = "SELECT * FROM happi_tb WHERE id='$id'";

	$qid = "";
	$ans = "";
	$partner = "";
	$age = "";
	$gender = "";
	$nationality = "";
	$country = "";
	$campaign = "";
	$res = $con->query($sql);
	while($row = $res->fetch_assoc()){
		$gender = $row['gender'];
		$age = $row['age']; 
		$qid .= "<th>Q No. ".$row['question_id']."</th>";
		$ans .= "<td>".$row['text_answer']."</td>"; 
		$country = $row['country'];
		$nationality = $row['nationality'];
		$partner = $row['partner_name'];
		
	}


	echo "
	<tr>
	<td><strong>".$id."</strong></td>
	<td>".$age."</td>
	<td>".$gender."</td>
	<td>".$nationality."</td>
	<td>".$country."</td>
	<td>".$partner."</td>

	</tr>";
	$_SESSION['sql'] = $sql;
}

echo "</tbody></table><script>$('#results').html('We found ".$duplic." rows that has duplicates.');</script>";




?>