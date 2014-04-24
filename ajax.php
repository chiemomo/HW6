<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>serialize demo</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<script>
/* function which gets executed when the document is loaded */
$(function() {

	function showValues2() {
		var str = $( "form" ).serialize();
		$( "#result" ).text( str );
	}
	$( "input[type='checkbox'], input[type='radio']" ).on( "click", showValues2 );
	$( "select" ).on( "change", showValues2 );
	showValues2();




	$("#process_inquiry_btn").click( 
		function(){
	
			$.ajax(
				{
					type: "POST",
					url: "process_inquiry.php?command=get_quote", 
					data: "",
					success: function(response)
					{
						/* use JSON's function to parse the response */
						var parsed_response = JSON.parse(response);
						
						/* modify the page dynamically, i.e., do something with the response */
						
						//alert(parsed_response);
						
						var content = "<p>The letters are ";
						
						for (var i = 0; i < parsed_response.length; i++) {
							content += " " + parsed_response[i];
						}
						content += "</p>";
					
						$("#result").html(content);
					
					}
				}
			);
	
			return false;
		}
	);




	$("#process_inquiry_btn").click( 
	
		function(){
		
			//serialize the comment area form into a datastring
			var comment = $("#comment").serialize();
			console.log(comment);
			
			$.ajax(
				{
					type: "POST",
					url: "process_inquiry.php?command=process_comment", 
					data: comment,
					success: function(response)
					{
						/* use JSON's function to parse the response */
						var parsed_response = JSON.parse(response);
						
						console.log(parsed_response);
						
						//To do: dynamically change the page
						var content = "Your comment: ";
						content += parsed_response;

						$("#result").html(content);
						
					}
				}
			);

			return false;
		}
		
	);

});
</script>	
</head>
<body>
<form id="inquiry_form">
	<table>
		<tr>
			<td>Head: </td>
			<td>
				<select name="head">
				<option value="MIU0020">Miura Special Edition K.J. Choi CB-501 Forged Irons</option>
				<option value="MIU0024">Miura PP-9003 Irons</option>
				</select>
			</td> 
		</tr>
		<tr>
			<td>Shaft: </td>
			<td>
				<select name="shaft">
				<option value="DYG0001">Dynamic Gold</option>
				<option value="KBS0001">KBS Tour</option>
				</select>
			</td> 
		</tr>
		<tr>
			<td><label for="tags">Comment: </label></td>
			<td><textarea name="comment" rows="4" cols="50"></textarea></td>
		</tr>
		<tr>
			<td><button type="submit" id="process_inquiry_btn" >Get A Quote</button></td>
			<td></td>
		</tr>
	</table>
</form>
<p><tt id="result"></tt></p>

</body>
</html>