<?php

	require 'includes/constants/dbc.php';

	//list the products in the product table and get rid of duplicate entries
	$product_list = get_autocomplete_words();

	//$response = array("product" => $product_list);

	echo json_encode($product_list);

?>