<?php
	include 'includes/constants/dbc.php';
?>

<html>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
function refresh_content(){

	$("#load_msgs").fadeIn(400).show().load('get_msg.php');
}

$(document).ready(refresh_content);

//now tell JavaScript to execute the function refresh_content() every X milliseconds
setInterval( refresh_content, 2000 );
</script>
</head>
<body>
<h2>Timed JSON Data Request Random Items Script</h2>
<div id="load_msgs" style="display:none;border-top: 1px solid #ccc;"></div>
</body>
</html>
