
<?php
	include 'sitecred.php';
	try{
		
		$db = new PDO('pgsql:host=70.35.196.223;dbname='.DB_NAME.';', DB_USER_NAME, DB_PASSWORD);
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
	}catch(PDOException $ex) {
		        echo $ex;
	}
	

?>

