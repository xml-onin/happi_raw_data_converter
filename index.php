<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Happi 2</title>
	<link rel="shortcut icon" type="icon" href="images/happi_icon.ico">
	<link rel="stylesheet" type="text/css" href="semantic/out/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="semantic/out/semantic.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">

</head>
<body>
<br><br>
<center>
	<img id="happiImg" src="images/happi.png" class="ui circular image" width="110" height="110">
	<table class="ui yellow table" style="width: 20%;"> 
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
			<td style="font-weight: bold;"><i class="file icon"></i> Choose file (.csv)</td>
		</tr>
		<tr>
			<td><input type="file" name="database" id="database"></td>
			<td><div class="ui facebook button" id="btnUpload"> Upload</div></td>
		</tr>
	</table>
</center>

<center>
	<div id="results" style="margin-bottom: 10px;margin-top: 10px;font-weight: bold;width: 30%;" class="ui warning message"></div>
	<a href="database/tocsv.php" class="ui positive button disabled" id="tocsv" style="margin-top: 9px;"><i class="save icon"></i> to CSV</a>
<br><br>
<div class="res">
	
</div>
</center>

</body>
<script type="text/javascript" src="assets/jq.js"></script>
<script src="semantic/out/semantic.min.js"></script>
<script src="assets/plugin.js"></script>

<script type="text/javascript">
	$('#results').hide();

	$(document).ready(function(){
		$.ajax({
			type: 'POST',
			data: {},
			url: 'database/check_db_rows.php',
			success:function(ress){
				if (ress == "1") {
	      			$('#btnUpload').addClass('disabled');
	      			$('#database').attr('disabled',false);
				}
				else{
					$('#database').attr('disabled',true);
					$('#btnLoad').removeClass('disabled');
	      			$('#btnUpload').addClass('disabled');
				}
			}
		});
	});

	var tmp;
	$('#database').change((event)=>{
		$('#btnUpload').removeClass('disabled');
	});

	$('div#btnUpload').on('click',function(){
		$('#database').upload('database/move_database.php',{
	        data: 'database',
	      },function(res){ 
	      	if (res == "success") {
	      		$('#btnLoad').removeClass('disabled');
	      		$('#btnUpload').addClass('disabled');
	      		$('#database').attr('disabled',true);
	      	}
	      	else{

	      	}
	      },function(prog, value){

	      });
	});


	$('img#happiImg').on('click',function(){
		$('#happiImg').transition({
		    debug: true
		  }).transition('scale in').transition('tada', '800ms');
	});

	$('div#btnLoad').on('click',function(){
		$('div#btnLoad').addClass('loading');
		var id = $('#id').val();
		$.ajax({
			type: 'POST',
			data: {id:id},
			url: 'database/get_user.php',
			success:function(res){

				$('.res').html(res);
				$('div#btnLoad').removeClass('loading');
				$('#tocsv').removeClass('disabled');
				$('#results').slideDown(350).delay(4000).slideUp(350);
			}
		});
	});

</script>

</html>

