<?php

include ("../app/connect.php");
	
	$con->select_db('db_happi2');
	$file = "C:/xampp/htdocs/happi2/happi_tb_orig.csv";
	$sql = "LOAD DATA INFILE '$file' INTO TABLE happi_tb FIELDS TERMINATED BY ','";
	if (isset($file)) {
		if ($con->query($sql)) {
			echo 'Database has been uploaded succesfuly.';
		}
		else
		{
			echo "File Not Found";
		}
	}
	else{

	}

?>