<?php

include 'includes/constants/dbc.php';

if ( isset ($_POST['limit']) ) {

	$limit = preg_replace('#[^0-9]#', '', $_POST['limit']);

	$i = 0;
	$jsonData = '{';
	$sqlString = "SELECT * FROM TABLE_INQUIRIES ORDER BY RAND() LIMIT $limit";
	$query = mysql_query($sqlString) or die (mysql_error()); 
	while ($row = mysql_fetch_array($query)) {
	$i++;
		$id = $row["id"]; 
		$title = $row["club"];
	$cd  = $row["creationdate"];
	   $cd = strftime("%B %d, %Y", strtotime($cd));
	$jsonData .= '"article'.$i.'":{ "id":"'.$id.'","club":"'.$title.'", "time":"'.$cd.'" },';
	}
	$now = getdate();
		$timestamp = $now[0];
	$jsonData .= '"arbitrary":{"itemcount":'.$i.', "returntime":"'.$timestamp.'"}';
	$jsonData .= '}';
		echo $jsonData;
}

?>