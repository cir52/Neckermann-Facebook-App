<?php
	
define("DATABASE_SERVER", "localhost");
define("DATABASE_USERNAME", "schachmattsql6");
define("DATABASE_PASSWORD", "nK0678");
define("DATABASE_NAME", "schachmattsql6");

$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
		 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 

$query = ("SELECT * FROM artikel WHERE aktiv=\"assets/aktiv.png\"");
$result = mysql_query($query);

echo "<?xml version=\"1.0\" ?>\n";
echo "<artikels>\n";
 	while ($line = mysql_fetch_assoc($result)) {
		echo "<artikel>";
			echo "<Key>".$line["Artikelkey"]."</Key>";
			echo "<ID>".$line["ID"]."</ID>";
			echo "<headline>".$line["headline"]."</headline>";
			echo "<produktbild>".$line["produktbild"]." </produktbild>";
			echo "<logo>".$line["logo"]."</logo>";
			echo "<infotext>".$line["infotext"]."</infotext>";
			echo "<preis>".$line["preis"]."</preis>";
			echo "<link>".$line["link"]."</link>";
			echo "<gewinn>".$line["gewinn"]."</gewinn>";
			echo "<gewinnmenge>".$line["gewinnmenge"]."</gewinnmenge>";
			echo "<gewinnzeitraum>".$line["gewinnzeitraum"]."</gewinnzeitraum>";
			echo "<aktiv>".$line["aktiv"]."</aktiv>";
		echo "</artikel>";
	}		 
echo "</artikels>";

mysql_close($mysql);
?>