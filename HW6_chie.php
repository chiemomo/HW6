<?php
	/*
my file	
	Homework 6: AJAX
	
	For homework 6, your task is to create a web page which uses an AJAX request to dynamically insert data into a database and refresh the visualization of that data on the page without having the user to reload the page. It is up to you to decide what type of form data to use and how to visualize it (e.g., using a table, or a chart, etc.). For examples, see Lectures 20, 21 and 31. Your page of course has to be substantially different from these examples. Finally, your page should utilize 2 different kinds of widgets or interactions that are implemented in the jQuery UI library (http://jqueryui.com/). Add an about section to the page where you briefly describe what your page does and which jQuery UI widgets or interactions it utilizes. 
	
	[8 pts] Working page
	[1 pt] Code readability and commenting
	[1 pt] Use CSS to make the page look nice
	
	EXTRA CREDIT
	
	[ 1 pt ] Use custom CSS styling for the jQuery widget you are using (e.g., style your own accordion, tooltip, etc.)
	[ 2 pt ] Allow the user to delete an item from the database using AJAX (i.e., without loading the page). Upon deletion form the database, the item should also disappear from the page (you can do that using jQuery .hide() function)
	
	*/
?>

<?php
	require 'includes/constants/dbc.php';

//Check for post data
if($_POST and $_GET)
{
	if ($_GET['cmd'] == 'add'){
	
		//Assign variables and sanitize POST data
		$customer = mysql_real_escape_string($_POST['customer_name']);
		$email = mysql_real_escape_string($_POST['email']);
		$phone = mysql_real_escape_string($_POST['phone']);
	 
		//Build our query statement
		mysql_query("INSERT INTO ".THE_TABLE." (customer_name, email, phone, time) VALUES ('" . $customer . "', '" . $email . "', '" .$phone . "', now())") or die(mysql_error());
	 
		//End this portion of the script
		exit();
	}
/*	else if ($_GET['cmd'] == 'delete_all'){
		//Left for exercise
		$query = "DELETE FROM " . TABLE_INQUIRIES . " WHERE 1;";
		mysql_query($query) or die("Cannot delete: " . mysql_error());
		
		exit();
	}*/
}

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery UI Autocomplete Exanple</title>
	
<!--include jquery UI css -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

<!-- include jquery and jquery UI javascript libraries -->
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>

/* function which gets executed when the document is loaded */
$(function() {

	/* define an array holding the strings that will be used for auto-completion */
	var brandList = [
		
		
	];
	
	$.ajax(
		{
			type: "POST",
			url: "generate_brands.php", 
			data: "",
			success: function(response)
			{
				
				/* use JSON's function to parse the response */
				var parsed_response = JSON.parse(response);

				
				/* retrieve the words array that is part of the response. Why is it called "words"? Because that is how we called it in generate_words.php */
				brandList = parsed_response.brand;
			
				/* select the HTML element with id="tags" and call the autocomplete() function from the jquery UI library */
				$( "#brand" ).autocomplete({
					source: brandList
				});
			}
		}
	);

	
});

/* function which gets executed when the document is loaded */
$(function() {

	/* define an array holding the strings that will be used for auto-completion */
	var productList = [
		
		
	];
	
	$.ajax(
		{
			type: "POST",
			url: "generate_products.php", 
			data: "",
			success: function(response)
			{
				
				/* use JSON's function to parse the response */
				var parsed_response = JSON.parse(response);
				
				/* retrieve the words array that is part of the response. Why is it called "words"? Because that is how we called it in generate_words.php */
				productList = parsed_response.product ;
				
				
				/* select the HTML element with id="tags" and call the autocomplete() function from the jquery UI library */
				$( "#product" ).autocomplete({
					source: productList
				});
			}
		}
	);

	
});

</script>
</head>
<body>

<div class="ui-widget">
	<label for="brand">Brand: </label>
	<input id="brand">
	<br>
	<label for="product">Product: </label>
	<input id="product">
</div>


<script>
//Form processing function start
$(function()
{
	refresh_content();
	
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 350,
		width: 350,
		modal: true,
		buttons: {
			"Add Item": function() {

				//create three variables to store the data entered into the form
				var client = $("#client").val();
				var quarter = $("#quarter").val();
				var amount = $("#amount").val();
			   
				//Check for empty values
				if(client == '' || quarter == '' || amount == '')
				{
					//here, we change the html content of all divs with class="error" and show them
					//there should be only 1 such div but the code would affect multiple if they were present in the page
					$('.error').fadeIn(400).show().html('Please complete all fields.'); 
				}
				else
				{
					//construct the data string - this should look something like:
					//	client=John&quarter=Q1&amount=3456
					
					var datastring = 'client=' + client + "&quarter=" + quarter + "&amount=" + amount;
		 
					/*
						Make the AJAX request. The request is made to $_SERVER['PHP_SELF'], i.e., clients_form.php
						The request is handled by checking for $_POST data -- see line 6
						After the $_POST data is processed, we use the exit() function because we don't need to actually
						show the page as the request is made in the background
					*/
					$.ajax( 
						{
						type: "POST",
						url: "clients_form.php?cmd=add", 
						data: datastring,
						success: function()
							{
								$('#client').val(''); //Clear out val from textbox
								$('#quarter').val(''); //Clear out val from namebox
								$('#amount').val(''); //Clear out val from namebox
								$('.success').fadeIn(2000).show().html('Added Successfully!').fadeOut(6000); //Show, then hide success msg
								$('.error').fadeOut(2000).hide(); //If showing error, fade out
				 
							}
						}
					);
				}
				
				$( this ).dialog( "close" );
			
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			//what happens when close is clicked? 
		}
	});

	$("#delete_button").click( function() 
	{
		var datastring = "delete=yes";
		
		$.ajax(
			{
				type: "POST",
				url: "<?php echo $_SERVER['PHP_SELF']; ?>?cmd=delete_all", 
				data: datastring,
				success: function()
				{
					$('.success').fadeIn(2000).show().html('Messages deleted successfull!').fadeOut(6000); //Show, then hide success msg
					$('.error').fadeOut(2000).hide(); //If showing error, fade out
					
					//reload the messages -- there should now be none
					refresh_content();
				}
			}
		);
		
		return false; //if we don't return false, then the form will be reloaded
	});
	
	$("#open_dialog_button").click( function() {
		$( "#dialog-form" ).dialog( "open" );
	});
	
});

//what should happen when we refresh?
//hint: find the element with id #loadmsgs, fade it in, show it, and use the load function to load get_msg.php
function refresh_content(){

	$("#load_msgs").fadeIn(400).show().load('get_msg.php');
}

//now tell JavaScript to execute the function refresh_content() every X milliseconds
setInterval( refresh_content, 2000 );


</script>

<div class="container">
 
 
<?php
	$text = "This is some text";
?> 
 
<p> <button type="submit" id="open_dialog_button" value="insert">Add Item</button> <button type="submit" id="delete_button" value="delete_all">Delete All</button></p>
 
<div id="dialog-form" title="Create new item"> 

<form method="post" name="form" id="form">
    
    <p><label>Client: </label>
    <input type="text" id="client" name="client" /></p>
    <p><label>Quarter: </label>
    <input type="text" id="quarter" name="quarter" /></p>
    <p><label>Amount: </label>
    <input type="text" id="amount" name="amount" /></p>
   
</form>

</div>

<p>
<span class="success" style="display:none;"></span>
<span class="error" style="display:none;">Please enter some text</span>
</p>


<div id="load_msgs" style="display:none;border-top: 1px solid #ccc;"></div>



</div>

</body>

</html>
