<?php
	require 'includes/constants/dbc.php';

	$autocomplete_list = all_inquiries();

	$response = array("words" => $autocomplete_list);
	
	echo json_encode($response);


?>