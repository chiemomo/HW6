<?php

	require 'includes/constants/dbc.php';

/*if (isset($_POST['limit'])){
	$limit = preg_replace('#[^0-9]#', '', $_POST['limit']);
*/	$i = 0;
	$jsonData = '{';

	$sqlString = "SELECT * FROM ".TABLE_PRODUCTS." WHERE `product_id` = " . $this;
	$query = mysql_query($sqlString) or die (mysql_error()); 

	while ($row = mysql_fetch_array($query)) {
		$i++;
		$product_id = $row["product_id"]; 
		$product_name = $row["product_name"];
		$price = $row["price"];
		$jsonData .= '"id'.$i.'":{ "product_id":"'.$product_id.'","product_name":"'.$product_name.'", "price":"'.$price.'" },';
	}

	$jsonData .= '}';

	echo $jsonData;


?>
