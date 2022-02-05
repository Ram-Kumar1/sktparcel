<?php 
	date_default_timezone_set('Asia/Kolkata');
	$date =  date('d-m-Y H:i');
	echo date('m-d-Y h:i a', strtotime($date));
?>