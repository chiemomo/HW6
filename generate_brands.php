<?php

	require 'includes/constants/dbc.php';

	//list the brands in the product table and get rid of duplicate entries
	$brand_list = get_brands();

	$response = array("brand" => $brand_list);

	echo json_encode($response);

?>