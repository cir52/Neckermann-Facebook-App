<?php
	define("DATABASE_SERVER", "localhost");
	define("DATABASE_USERNAME", "schachmattsql6");
	define("DATABASE_PASSWORD", "nK0678");
	define("DATABASE_NAME", "schachmattsql6");
 
	$aktion = $_POST['gewinnaktion'];	
	$Artikelkey=10;
	
	$Artikelkey = $_POST['Artikelkey'];	

	$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
	 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
	
//Gewinnvariable wurde auf true gesetzt...
	if ($aktion == "setgewinn") setgewinn($Artikelkey);
	if ($aktion == "checkwin") checkwin($Artikelkey);

	//if ($aktion == "gewinn_changed") gewinn_changed($Artikelkey);
	

function setgewinn($Artikelkey) {
	$timestamp = time();
	$temp=("UPDATE artikel SET gewinnstart=FROM_UNIXTIME(".$timestamp.") WHERE artikel.Artikelkey='".$Artikelkey."'"); 
	mysql_query($temp);	 
	$temp=("UPDATE artikel SET tempdisabled=FROM_UNIXTIME(".$timestamp.") WHERE artikel.Artikelkey='".$Artikelkey."'"); 
	mysql_query($temp);	 
	setnextgewinn($Artikelkey);
	return;
}

function setnextgewinn($Artikelkey) {
 	$timestamp = time();
	$datum = getdate($timestamp);

	$query = ("SELECT gewinnmenge,gewinnzeitraum,nextgewinn,artikelleft, UNIX_TIMESTAMP(gewinnstart) FROM artikel WHERE artikel.Artikelkey = '".$Artikelkey."'"); 
	$result = mysql_query($query);
	$artikel = mysql_fetch_row($result);
	
	$gewinnmenge = $artikel[0];
	$gewinnzeitraum = $artikel[1];
	$nextgewinn = $artikel[2];
	$artikelleft = $artikel[3];
	$gewinnstart = $artikel[4];
	
	if ($artikelleft == 0) { 
		$artikelleft = $gewinnmenge;
		$temp=("UPDATE artikel SET artikelleft='".$artikelleft."' WHERE artikel.Artikelkey='".$Artikelkey."'"); 
			mysql_query($temp);			
	}
	$gewinnabschnitt = ($gewinnzeitraum*24*60*60)/($gewinnmenge);
	$nextgewinn = ($gewinnstart) + (($gewinnabschnitt)*($gewinnmenge-$artikelleft));
	
	$temp=("UPDATE artikel SET nextgewinn=FROM_UNIXTIME(".$nextgewinn.") WHERE artikel.Artikelkey='".$Artikelkey."'");
	mysql_query($temp);
		
	return;
}

?> 