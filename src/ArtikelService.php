<?php
	define("DATABASE_SERVER", "localhost");
	define("DATABASE_USERNAME", "schachmattsql6");
	define("DATABASE_PASSWORD", "nK0678");
	define("DATABASE_NAME", "schachmattsql6");
 
	$aktion = $_POST['aktion'];	

	if ($aktion == "getArtikels") {
		$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
		 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
		
		$query = 'SELECT * FROM artikel ORDER BY Artikelkey DESC';
					$result = mysql_query($query);
					echo "<?xml version=\"1.0\" ?>\n";
					echo "<artikels>\n";
						while ($line = mysql_fetch_assoc($result)) {
							echo "<artikel>";
								echo "<Artikelkey>".$line["Artikelkey"]."</Artikelkey>";
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
	} 
	
	if ($aktion == "saveArtikel")	{
			$artikel_Artikelkey = $_POST['Artikelkey'];		
			$artikel_ID = $_POST['artikel_ID'];		
			$artikel_headline = $_POST['artikel_headline'];		
			$artikel_produktbild = $_POST['artikel_produktbild'];	
			$artikel_logo = $_POST['artikel_logo'];		
			$artikel_infotext = $_POST['artikel_infotext'];		
			$artikel_preis = $_POST['artikel_preis'];		
			$artikel_link = $_POST['artikel_link'];		
			$artikel_gewinn = $_POST['artikel_gewinn'];		
			$artikel_gewinnmenge = $_POST['artikel_gewinnmenge'];	
			$artikel_gewinnzeitraum = $_POST['artikel_gewinnzeitraum'];		
			$artikel_aktiv = $_POST['artikel_aktiv'];	
			
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
			 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
				
			$query = ("UPDATE artikel SET ID='".$artikel_ID."', headline='".$artikel_headline."', produktbild='".$artikel_produktbild."', logo='".$artikel_logo."', infotext='".$artikel_infotext."', preis='".$artikel_preis."', link='".$artikel_link."', gewinn='".$artikel_gewinn."', gewinnmenge='".$artikel_gewinnmenge."', gewinnzeitraum='".$artikel_gewinnzeitraum."', aktiv='".$artikel_aktiv."' WHERE 	artikel.Artikelkey=".$artikel_Artikelkey);
														
			$result = mysql_query($query);
		}
		
		if ($aktion == "createArtikel")	{ 
			$artikel_Key = $_POST['Artikelkey'];		
			$artikel_ID = $_POST['artikel_ID'];		
			$artikel_headline = $_POST['artikel_headline'];		
			$artikel_produktbild = $_POST['artikel_produktbild'];	
			$artikel_logo = $_POST['artikel_logo'];		
			$artikel_infotext = $_POST['artikel_infotext'];		
			$artikel_preis = $_POST['artikel_preis'];		
			$artikel_link = $_POST['artikel_link'];		
			$artikel_gewinn = $_POST['artikel_gewinn'];		
			$artikel_gewinnmenge = $_POST['artikel_gewinnmenge'];	
			$artikel_gewinnzeitraum = $_POST['artikel_gewinnzeitraum'];		
			$artikel_aktiv = $_POST['artikel_aktiv'];	
			
				$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
				 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
				
				// add new artikel
					$query = ("INSERT INTO artikel (ID, headline, produktbild, logo, infotext, preis, link, gewinn, gewinnmenge, gewinnzeitraum, aktiv) VALUES ('".$artikel_ID."', '".$artikel_headline."', '".$artikel_produktbild."', '".$artikel_logo."', '".$artikel_infotext."', '".$artikel_preis."', '".$artikel_link."', '".$artikel_gewinn."', '".$artikel_gewinnmenge."', '".$artikel_gewinnmenge."', '".$artikel_aktiv."')"); 
					$result = mysql_query($query);
		} 
		
		if ($aktion == "deleteArtikel")	{ 
			$artikel_Key = $_POST['Artikelkey'];
		
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
			 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
			 
			$sql = ("DELETE FROM artikel WHERE artikel.Artikelkey = ".$artikel_Key);
			$result = mysql_query($sql);
		}
	
?>
