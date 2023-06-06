<?php
echo "<?xml version=\"1.0\" ?>\n";
	
define("DATABASE_SERVER", "localhost");
define("DATABASE_USERNAME", "schachmattsql6");
define("DATABASE_PASSWORD", "nK0678");
define("DATABASE_NAME", "schachmattsql6");

$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
		 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 

$usern = $_POST['usern'];
$passw = $_POST['passw'];

$results = mysql_query("SELECT * FROM `user` WHERE 1");

$loged = false;

while ($row = mysql_fetch_assoc($results)) 
{
	if (strtolower($usern) == strtolower($row['UserNick']) &&
		strtolower($passw) == strtolower($row['UserPass'])) 
	{ $loged = true;
	}
}

if ($loged == true) 
	echo "<status>true</status>"; 
else 
	echo "<status>false</status>"; 


?>