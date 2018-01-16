<?php

include "../app/connect.php";

if (isset($_POST['qry'])) {
	$con->query($_POST['qry']);
	
}
else{
	echo $con->error;
}


?>