<?php
//FOR MY PROJECT

//SQL credentials
define ("DB_HOST", "localhost");
define ("DB_USER", "hci573");
define ("DB_PASS", "hci573");
define ("DB_NAME", "hci573");

//tables
define ("TABLE_PRODUCTS", "products_chie");
define ("TABLE_INQUIRIES", "inquiries_chie");
define ("TABLE_USERS", "users_chie");

//connect to the SQL database
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

/* a functions which return an array holding all brand in the product table */
function get_brands(){

	//generate and execute the SQL query``
	$query = "SELECT brand FROM " . TABLE_PRODUCTS . " WHERE 1;";
	$result = mysql_query($query) or die(mysql_error());
	
	//initialize an array to hold the words
	$brands = array();
	
	while (true)
	{
		$row = mysql_fetch_array($result);
		
		if (!$row) //if $row evaluates to 'false' (i.e., !$row evaluates to true) then we're done
			break;
		
		//get rid of carriage return character (just in case) and add the brand from the current row to the list of brand
		$brands[] = str_replace("\r","",$row['brand']);
	}
	
	//return the list of words
	return $brands;
	
}

function get_product(){

	$query="SELECT product_name FROM " . TABLE_PRODUCTS . " WHERE 1;";
	$result = mysql_query($query) or die(mysql_error());
	
	$products = array();
	
	while (true)
	{
		$row = mysql_fetch_array($result);
		
		if (!$row)
			break;
		
		$products[] = str_replace("\r","",$row['product_name']);
	}
	
	return $products;

}

//function which returns all stored entries wrapped up in HTML code
function load_messages()
{
    //here, the variable $build holds the HTML content that is generated by the function
	$build = '';
	
	
	//setup our query and execute it
	$query = "SELECT * FROM ".TABLE_INQUIRIES." ORDER BY ci_id DESC";
    $msgq = mysql_query($query) or die(mysql_error());
    
	
	if(mysql_num_rows($msgq) == 0)
    {
       
		//the .= operator adds on to the current value of $build
		$build .= "<p><b>No data found.  Add some data using the form above</b></p>";
    }
    else
    {
        while($row = mysql_fetch_array($msgq))
        {
            $build .= "<div class=\"display\"><table style=\"width:100%;\"><td style=\"width:80%;\">";
			
			//generate the entry
            $build .= "<p><b>The Client:</b> ".$row['ci_ci']."<br />";
 
            $build .= "<b>The Quarter:</b> ". $row['ci_qt'] . "<br />";
 
            $build .= "<b>The Amount:</b> $" . $row['ci_amt'] . "<br />";
   
   
			//generate the button to delete
			$button_id = "delete_button_" . $row['ci_id'];
			$build .= "</td><td style=\"width:20%;\">";
			
			
			$build .= "</td></table>";
            $build .= "</div>";
        }
    }
    return $build;
}

?>