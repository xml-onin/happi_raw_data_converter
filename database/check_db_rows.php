<?php
include "../app/connect.php";
$sql = "SELECT * FROM happi_tb";
$res = $con->query($sql);
$row_num = $res->num_rows;
if ($row_num == 0) {
	echo "1";
}
else{
	echo "0";
}


?>