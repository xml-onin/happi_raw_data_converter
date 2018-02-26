<?php

include ("../app/connect.php");
$target_dir = "../databases/";
$target_file = $target_dir . basename($_FILES["database"]["name"]);
move_uploaded_file($_FILES["database"]["tmp_name"], $target_file);
$path = substr($target_file,3);


$file = "C:/xampp/htdocs/happi2/".$path;
$sql = "LOAD DATA INFILE '$file' INTO TABLE happi_tb FIELDS TERMINATED BY ','";
if (isset($file)) {
	if ($con->query($sql)) {
		echo 'success';
	}
	else
	{
		echo $con->error;
	}
}
else{

}

?>