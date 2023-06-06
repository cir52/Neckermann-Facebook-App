<?php

 
	define("DATABASE_SERVER", "localhost");
	define("DATABASE_USERNAME", "schachmattsql6");
	define("DATABASE_PASSWORD", "nK0678");
	define("DATABASE_NAME", "schachmattsql6");
 
class ArtikelService {

	var $username = "schachmattsql6";
	var $password = "nK0678";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "schachmattsql6";
	var $tablename = "artikel";

	var $connection;
	
	/**
	 * The constructor initializes the connection to database. Everytime a request is 
	 * received by Zend AMF, an instance of the service class is created and then the
	 * requested method is invoked.
	 */
		public function __construct() {
				$this->connection = mysqli_connect(
										$this->server,  
										$this->username,  
										$this->password, 
										$this->databasename,
										$this->port
									);

				$this->throwExceptionOnError($this->connection);
		}
		
		public function getArtikelData() {
				
				$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
				 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
				
				$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
				$this->throwExceptionOnError();
				
				mysqli_stmt_execute($stmt);
				$this->throwExceptionOnError();
				
				$rows = array();
				
				mysqli_stmt_bind_result($stmt, $row->Artikelkey, $row->ID, $row->headline, $row->produktbild, $row->logo, $row->infotext, $row->preis, $row->link, $row->gewinn, $row->gewinnmenge, $row->gewinnzeitraum, $row->aktiv);
				
				while (mysqli_stmt_fetch($stmt)) {
				  $rows[] = $row;
				  $row = new stdClass();
				  mysqli_stmt_bind_result($stmt, $row->Artikelkey, $row->ID, $row->headline, $row->produktbild, $row->logo, $row->infotext, $row->preis, $row->link, $row->gewinn, $row->gewinnmenge, $row->gewinnzeitraum, $row->aktiv);
				}
				
				mysqli_stmt_free_result($stmt);
				mysqli_close($this->connection);
			
				return $rows;
				} 
		
		 
		public function getArtikelByID($itemID) {
				
				$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
				 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
				 
				$sql = mysql_query("SELECT COUNT(*) FROM artikel WHERE ID=".$itemID);
				$row = mysql_fetch_row($sql);
				$result = $row[0];					
				return $result;
				
		}
				
		/*ublic function createArtikel($item) {
				//$stmt = mysqli_prepare($this->connection, "INSERT INTO artikel (Artikelkey, ID, headline, produktbild, logo, infotext, preis, link, gewinn, gewinnmenge, gewinnzeitraum, aktiv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				//$this->throwExceptionOnError();
				$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
				 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
				
				$query = "INSERT INTO artikel (Artikelkey, ID, headline, produktbild, logo, infotext, preis, link, gewinn, gewinnmenge, gewinnzeitraum, aktiv) VALUES ( ".$item->Artikelkey.",".$item->ID.",".$item->headline.",".$item->produktbild.",".$item->logo.",".$item->infotext.",".$item->preis.",".$item->link.",".$item->gewinn.",".$item->gewinnmenge.",".$item->gewinnzeitraum.",".$item->aktiv.")");
				
				
				//mysqli_stmt_bind_param($stmt, 'iissssdsiiis', $item->Artikelkey, $item->ID, $item->headline, $item->produktbild, $item->logo, $item->infotext, $item->preis, $item->link, $item->gewinn, $item->gewinnmenge, $item->gewinnzeitraum, $item->aktiv);
				//$this->throwExceptionOnError();

				/*mysqli_stmt_execute($stmt);		
				$this->throwExceptionOnError();

				$autoid = $item->ID;

				mysqli_stmt_free_result($stmt);		
				mysqli_close($this->connection);

				return $autoid;
		}*/
		
		public function updateArtikel($artikel) {
	
				// Connect to Database
				if ($artikel == NULL) return 1;
				
				$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
				 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
				
				$query = "UPDATE artikel SET 	ID='".$artikel->ID."', 
												headline='".$artikel->headline."',
												produktbild='".$artikel->produktbild."',
												logo='".$artikel->logo."',
												infotext='".$artikel->infotext."',
												preis='".$artikel->preis."',
												link='".$artikel->link."',
												gewinn='".$artikel->gewinn."',
												gewinnmenge='".$artikel->gewinnmenge."',
												gewinnzeitraum='".$artikel->gewinnzeitraum."'
												aktiv='".$artikel->aktiv."'
										WHERE 	Artikelkey='".$artikel->Artikelkey."'"; 
											
				$result = mysql_query($query);
				return 3;
		}
		
		public function addArtikel($artikel) {
				
				// Connect to Database
				if ($artikel == NULL) return NULL;
				
				$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
				 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
				
				// add new artikel
					$query = "INSERT INTO artikel (ID, headline, produktbild, logo, infotext, preis, link, gewinn, gewinnmenge, gewinnzeitraum, aktiv)
								VALUES ('".$artikel->ID."', 
										'".$artikel->headline."',
										'".$artikel->produktbild."',
										'".$artikel->logo."',
										'".$artikel->infotext."',
										'".$artikel->preis."',
										'".$artikel->link."',
										'".$artikel->gewinn."',
										'".$artikel->gewinnmenge."',
										'".$artikel->gewinnmenge."',
										'".$artikel->aktiv."')"; 
				
				$result = mysql_query($query);
				return (NULL);			
		} 
		
		public function deleteArtikel($artikel) { 
			
			if ($artikel == NULL) return NULL;
			
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die(mysql_error()); 
			 mysql_select_db(DATABASE_NAME) or die(mysql_error()); 
			 
			$sql = ("DELETE FROM schachmattsql6.artikel WHERE artikel.Artikelkey = ".$artikel->Artikelkey);
			mysql_query($sql);
			
			return (NULL);		
		}
	
	public function count() {
		$stmt = mysqli_prepare($this->connection, "SELECT COUNT(*) AS COUNT FROM $this->tablename");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $rec_count);
		$this->throwExceptionOnError();
		
		mysqli_stmt_fetch($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);
		
		return $rec_count;
	}


	private function throwExceptionOnError($link = null) {
		if($link == null) {
			$link = $this->connection;
		}
		if(mysqli_error($link)) {
			$msg = mysqli_errno($link) . ": " . mysqli_error($link);
			throw new Exception('MySQL Error - '. $msg);
		}		
	}
}

?>
