<style>
body
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
ul
{
list-style: none;
margin: 17px 20px 20px 24px;
width: 330px;
}
li
{
display: block;
padding: 5px;
background-color: #ccc;
border-bottom: 1px solid #367;
}
#content
{
padding:50px;
width:500px; border:1px solid #666;
float:left;
}
#clear
{ clear:both; }
#box
{
float:left;
margin:0 0 20px 0;
text-align:justify;
}
input[type=text]
{width:330px; height:35px;}
input[type=submit]
{
width:90px; height:35px;
}
</style>

<?php
$query=mysql_connect("localhost","root","");
mysql_select_db("freeze",$query);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Freeze Search engine</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script></head>
<body>
<div id="content">
<?php
$val=''; 
if(isset($_POST['submit'])) {
if(!empty($_POST['name'])) {
$val=$_POST['name']; 
} else {
$val=''; }
} 
?> 
<center>
<img src="freeze.PNG">
</center> 
<form method="post" action="index.php">
Search : <input type="text" name="name" id="name" autocomplete="off" value="<?php echo $val;?>"> 
<input type="submit" name="submit" id="submit" value="Search">
</form>
<div id="display"></div> 
<?php if(isset($_POST['submit'])) {
if(!empty($_POST['name'])) {
$name=$_POST['name'];
$query3=mysql_query("SELECT * FROM product WHERE name LIKE '%$name%' OR descr LIKE '%$name%'");
while($query4=mysql_fetch_array($query3)) {
echo "<div id='box'>";
echo "<b>".$query4['name']."</b>";
echo "<div id='clear'></div>";
echo $query4['descr']; echo "</div>";
} 
} else { 
echo "No Results"; 
} 
} ?> 
</div>
</body>
</html>

<script type="text/javascript">
function fill(Value)
{
$('#name').val(Value);
$('#display').hide();
}

$(document).ready(function(){
$("#name").keyup(function() {
var name = $('#name').val();
if(name=="")
{
$("#display").html("");
}
else
{
$.ajax({
type: "POST",
url: "test.php",
data: "name="+ name ,
success: function(html){
$("#display").html(html).show();
}
});
}
});
});
</script>