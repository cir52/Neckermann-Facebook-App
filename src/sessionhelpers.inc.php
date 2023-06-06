<?php
function connect() 
{ 
    $con = mysql_connect('localhost','root') or die(mysql_error()); 
     mysql_select_db('test',$con) or die(mysql_error()); 
} 

function check_user($name, $pass) 
{ 
    $sql="SELECT costumer_id FROM costumer WHERE email='".$name."' AND password=MD5('".$pass."') 
    LIMIT 1"; 
    $result= mysql_query($sql) or die(mysql_error()); 
    if ( mysql_num_rows($result)==1) 
    { 
        $cost = mysql_fetch_assoc($result); 
		return $cost['costumer_id']; 
    } 
    else 
        return false; 
} 

function login($costumer_id) 
{   $sql=("UPDATE costumer SET session_id='".session_id()."'WHERE costumer_id='".$costumer_id."'"); 
    mysql_query($sql); 

	$timestamp = time();
	$temp=("UPDATE costumer SET last_login=FROM_UNIXTIME(".$timestamp.") WHERE session_id='".session_id()."'"); 
	mysql_query($temp);	 
	//Warenkorb nullen
	$temp=("DELETE FROM basket WHERE costumer_id='".$costumer_id."'");
	mysql_query($temp);
	return 0;
} 

function check_logg() 
{ 
	$sql="SELECT costumer_id FROM costumer WHERE session_id='".session_id()."'LIMIT 1"; 
    $result = mysql_query($sql);
    
	if (mysql_num_rows($result)==1) {
	
		$timestamp = time();
		//letzter Login ?
		$temp = "SELECT (UNIX_TIMESTAMP(last_login)) FROM costumer WHERE session_id='".session_id()."'"; 
		$data = mysql_query($temp);
		$row = mysql_fetch_row($data);
		$lastlogin = $row[0];
		
		if ( ($timestamp - $lastlogin) > 1800 )  { 
			$temp="UPDATE costumer SET session_id=NULL WHERE session_id='".session_id()."'";
			mysql_query($temp);
			return false;
		  }
		else {		
			$temp="UPDATE costumer SET last_login=FROM_UNIXTIME(".$timestamp.") WHERE session_id='".session_id()."'"; 
			mysql_query($temp);
			return true;
		}
	}
	else
		return false;
} 

function logged_in() 
{ 
    $sql="SELECT costumer_id  FROM costumer WHERE session_id='".session_id()."'LIMIT 1"; 
    $data = mysql_query($sql); 
	$row = mysql_fetch_row($data);
	$result = $row[0];
	return ($result); 
} 
function logout() 
{   $sql="UPDATE costumer SET session_id=NULL WHERE session_id='".session_id()."'"; 
    mysql_query($sql); 
    //$_SESSION[loggedin] = false;
	return true;
} 

function datum_ok($datum)
{
 list ($d, $m, $y) = explode('.', $datum); 

 if (is_numeric($d) && is_numeric($m) && is_numeric($y) && ( (int)$y > 1950 ))
 { 
	if ( checkdate( $m, $d, $y) ) 
		return true;
 }
  else
	return false;
}

//einen Artikel im Warenkorb löschen
function del_basket_art($artikel) {
	$sql=("DELETE FROM basket WHERE (costumer_id=".logged_in()." AND article_id=".$artikel.")");
	mysql_query($sql);
	return 0;
}

//****************  DATEI UPLOAD *********************************+
function random($laenge) { 
    $signs = "abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ0123456789";
    $name_new = ""; 
    mt_srand ((double) microtime() * 1000000); 
    for ($i = 0; $i < $laenge; $i++) $name_new .= $signs{mt_rand (0,strlen($signs))}; 
    return $name_new; 
}

function createName($pname, $ftype){
    global $folder;
    $pname .= random(3);
    if(file_exists($folder.$pname.".".$ftype)) return createName($pname, $ftype);
    else return $pname.".".$ftype;
}

function to_string($zahl) {
	$komma = "00";
	$zahl *= 1.00;
	
	$split = explode(".", $zahl);
	$zahl = $split[0];
	$komma = $split[1];
		
	if ( (strlen($komma)) == 0) $komma = "00"; 
	if ( (strlen($komma)) == 1) $komma .= "0";
	
	$zahl = $zahl.",".$komma;
	return $zahl;
}

function fileupload($med_typ) {

	global $folder;
    global $max_filesize;
	global $extensions;
	global $stringext;
	global $info;
		
    if(!empty($_FILES[$med_typ]['name'])){
        $fname = $_FILES[$med_typ]['name'];
        $split = explode(".", $fname);
        $pname = $split[0];
        $ftype = $split[1];
		if(!in_array($ftype, $extensions)) {
			foreach ($extensions as $value)
				$stringext.= $value.", ";				
			return "Die Datei hat keine zulässige Dateiendung. (erlaubt: $stringext)";
        }
		if($_FILES[$med_typ]['size'] > $max_filesize) return "Die von Ihnen ausgewählte Datei ist zu groß.";
        if(file_exists($folder.$fname)){
            $fname = createName($pname, $ftype);
            $image = $fname;
			$info = "<br /><strong>Die Datei musste unbenannt werden, weil eine Datei mit gleichem Dateinamen schon auf dem Server existiert.</strong>";
        }
        if(!move_uploaded_file($_FILES[$med_typ]['tmp_name'], str_replace("\\","/",$folder.$fname))) return "Der Upload ist fehlgeschlagen, bitte versuchen Sie es erneut.";
	chmod(str_replace("\\","/",$folder.$fname),0777);        
		//erfolgreicher Upload: in Datenbanktabelle eintragen:
		
		return "Die Datei \"$fname\" wurde erfolgreich hochgeladen.$info";
    }
    else return "Sie haben noch keine Datei ausgewählt!";
}
connect(); 
?>