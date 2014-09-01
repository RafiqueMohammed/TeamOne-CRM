<?php
$query=mysql_connect("localhost","root","");
mysql_select_db("team_crm",$query);
if(isset($_POST['name']))
{
$name=trim($_POST['name']);
$query2=mysql_query("SELECT distinct(`pincode`) FROM `locality` WHERE `pincode` LIKE '$name%' LIMIT 5");
echo "<ul>";
while($query3=mysql_fetch_array($query2))
{
?>

<li onclick='fill("<?php echo $query3['pincode']; ?>")'><?php echo $query3['pincode']; ?></li>
<?php
}
}
?>
</ul>