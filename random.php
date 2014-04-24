<!--http://www.developphp.com/view.php?tid=1276-->
<!-- json_mysql_data.php -->
<?php
header("Content-Type: application/json");
if(isset($_POST['limit'])){
$limit = preg_replace('#[^0-9]#', '', $_POST['limit']);
require_once("connect_db.php");
$i = 0;
$jsonData = '{';
$sqlString = "SELECT * FROM tablename ORDER BY RAND() LIMIT $limit";
$query = mysql_query($sqlString) or die (mysql_error()); 
while ($row = mysql_fetch_array($query)) {
$i++;
    $id = $row["id"]; 
    $title = $row["title"];
$cd  = $row["creationdate"];
   $cd = strftime("%B %d, %Y", strtotime($cd));
$jsonData .= '"article'.$i.'":{ "id":"'.$id.'","title":"'.$title.'", "cd":"'.$cd.'" },';
}
$now = getdate();
    $timestamp = $now[0];
$jsonData .= '"arbitrary":{"itemcount":'.$i.', "returntime":"'.$timestamp.'"}';
$jsonData .= '}';
    echo $jsonData;
}
?>
<!-- JSON_tutorial_7.html -->
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
div#databox {
padding:12px;
background: #F3F3F3;
border:#CCC 1px solid;
width:550px;
height:310px;
}
</style>
<script type="text/javascript">
var myTimer;
function ajax_json_data(){
var databox = document.getElementById("databox");
var arbitrarybox = document.getElementById("arbitrarybox");
    var hr = new XMLHttpRequest();
    hr.open("POST", "json_mysql_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
   if(hr.readyState == 4 && hr.status == 200) {
   var d = JSON.parse(hr.responseText);
arbitrarybox.innerHTML = d.arbitrary.returntime;
databox.innerHTML = "";
for(var o in d){
if(d[o].title){
   databox.innerHTML += '<p><a href="page.php?id='+d[o].id+'">'+d[o].title+'</a><br>';
databox.innerHTML += ''+d[o].cd+'</p>';
}
}
   }
    }
    hr.send("limit=4");
    databox.innerHTML = "requesting...";
myTimer = setTimeout('ajax_json_data()',6000);
}
</script>
</head>
<body>
<h2>Timed JSON Data Request Random Items Script</h2>
<div id="databox"></div>
<div id="arbitrarybox"></div>
<script type="text/javascript">ajax_json_data();</script>
</body>
</html>
