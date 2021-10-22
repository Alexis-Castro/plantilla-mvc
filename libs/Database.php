<?php 	
class Database extends PDO{

	public function __construct(){

		$options = array(
			
            PDO::ATTR_PERSISTENT => true, 
            PDO::ATTR_EMULATE_PREPARES => false, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			
		);

			parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS,$options);
	}
}