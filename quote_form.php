<?php
//Include the database connection file (also contains the script to output submitted entries)
include 'includes/constants/dbc.php';

//Check for post data
if($_POST and $_GET)
{
	if ($_GET['cmd'] == 'add') {
	
		//Assign variables and sanitize POST data
		$client = mysql_real_escape_string($_POST['client']);
		$product = mysql_real_escape_string($_POST['product']);
		$qty = mysql_real_escape_string($_POST['qty']);
	 
		//Build our query statement
		mysql_query("INSERT INTO ".THE_TABLE." (ci_ci, ci_qt, ci_amt, ci_added) VALUES ('" . $client . "', '" . $quarter . "', '" .$amount . "', now())") or die(mysql_error());
	 
		//End this portion of the script
		exit();
	}
	else if ($_GET['cmd'] == 'delete_all'){
		//Left for exercise
		$query = "DELETE FROM " . THE_TABLE . " WHERE 1;";
		mysql_query($query) or die("Cannot delete: " . mysql_error());
		
		exit();
	}
}

?>
