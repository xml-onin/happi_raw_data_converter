<?php
set_time_limit(360);
session_start();

/*$qry_qid_row = "SELECT DISTINCT question_id FROM happi_tb ORDER BY question_id ASC";
	$res_qid_row = $con->query($qry_qid_row);
	while($row_qid = $res_qid_row->fetch_assoc()){
		$column = $row_qid['question_id'];
		$sql_query = "SELECT text_answer FROM happi_tb WHERE question_id='$column' AND id='624'";
		$res_qryy = $con->query($sql_query);
		for ($i=0; $i < 5 ; $i++) { 
			if ($row_queryy = $res_qryy->fetch_assoc()) {
				$ans[] = $column . " -  " .$row_queryy['text_answer'];
			}
			else{ 
				$ans[] = $column . " -- ";
			}
		}
	}

echo "<pre>";
print_r($ans);
echo "</pre>";*/


?>
<!DOCTYPE html>
<html>
<head>
	<title>Happi</title>
	<link rel="shortcut icon" type="icon" href="images/happi_icon.ico">
	<link rel="stylesheet" type="text/css" href="semantic/out/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="semantic/out/semantic.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<style type="text/css">
		select{
			margin-bottom: 5px;
		}
	</style>
</head>
<body>
<br>
<center>
	<img id="happiImg" src="images/happi.png" class="ui circular image" width="110" height="110">
	<?php
	include"app/connect.php";
	$sql = "SELECT DISTINCT id FROM happi_tb";
	$res = $con->query($sql);
	$row = $res->num_rows;
	echo "<strong>".$row."</strong><br>RESPONDENTS";
	?>
	
	<table class="ui table" style="width: 20%;"> 
		<tr>
			<td style="font-weight: bold;"><i class="refresh icon"></i> Load Data</td>
		</tr>
		<tr>
			<td colspan="2">
		<div class="ui twitter button disabled" id="btnLoad" style="width: 100%;">
			Load
		</div>
	</td>

		</tr>
		<tr>
			<td style="font-weight: bold;" colspan="2">
				<div class="ui toggle checkbox">
				<input type="checkbox" name="" id="checkboxx">
				<label style="color: white;"> Customize Output</label>
			</div>
		</td>
		</tr>
		<tr>
			<form method="POST" action="database/load_csv.php" class="ui form">
			<td colspan="2" style="font-weight: bold;padding: 20px;" id="cus_input">
				<div class="ui input"  style="width: 100%;"><input type="number" value="5" min="1" max="5" name="no_repeat" placeholder="Question Repeat" style="margin-bottom: 5px;"></div><br>
				
				<div class="ui input" id="no_users" style="width: 100%;"><input type="number" placeholder="No. of Respondent" id="num_users" name="nousers"></div>
				
				<!-- <div class="ui input" id="starting_range"><input type="number" id="starting" name="start" style="margin: 5px;width: 120px;"></div> -->
				<label>Question Range (Start - End)</label>
				<select class="ui fluid dropdown" name="start">
					<?php
					include "app/connect.php";
					$sql = "SELECT DISTINCT question_id FROM happi_tb ORDER BY question_id ASC";
					$res = $con->query($sql);
					while ($row = $res->fetch_assoc()) {
						echo "<option>".$row['question_id']."</option>";
					}
					?>
				</select>
				<select class="ui fluid dropdown" name="end">
					<?php
					$sql = "SELECT DISTINCT question_id FROM happi_tb ORDER BY question_id DESC";
					$res = $con->query($sql);
					while ($row = $res->fetch_assoc()) {
						echo "<option>".$row['question_id']."</option>";
					}
					?>
				</select>
				<!-- <div class="ui input" id="end_range"><input type="number" id="ending" name="end" style="margin: 5px;width: 120px;"></div>
 -->				<input type="submit" name="" class="ui positive button" value="Download" style="width: 100%;">
			</td>
			</form>
		</tr>
		
		<tr>
			<td colspan="2" style="font-weight: bold;"><i class="file icon"></i> Choose file (.csv)</td>
		</tr>
		<tr>
			<td><input type="file" name="database" id="database" accept=".csv"></td>
			<td><div class="ui facebook button" id="btnUpload"> Upload</div></td>
		</tr>
		<tr>
			<td colspan="2">
				<a class="ui positive button" href="databas/load_csv.php" id="tocsv" style="margin-top: 9px;width: 100%;"><i class="save icon"></i> to CSV</a>
			</td>
		</tr>
	</table>
</center>

<center>
	<div id="results" style="margin-bottom: 10px;margin-top: 10px;font-weight: bold;width: 30%;" class="ui warning message"></div>
	
<br><br>
<div class="res">
	
</div>
</center>

</body>
<script type="text/javascript" src="assets/jq.js"></script>
<script src="semantic/out/semantic.min.js"></script>
<script src="assets/plugin.js"></script>
<script type="text/javascript" src="assets/settings.js"></script>
</html>

