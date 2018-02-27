<?php

namespace App\Core;

class Database {

	private $db_host = DBHOST;
	private $db_user = DBUSER;
	private $db_pass = DBPASS;
	private $db_name = DBNAME;
	private $db_type = DBTYPE;
	private $dbh;
	private $stmt;
	private $error;

	public function __construct(){

		try{

			$dsn = $this->db_type . ':host=' . $this->db_host . ';dbname=' . $this->db_name;
			$options = [
				\PDO::ATTR_PERSISTENT 	=> true,
				\PDO::ATTR_ERRMODE		=> \PDO::ERRMODE_EXCEPTION
			];
			$this->dbh = new \PDO($dsn,$this->db_user,$this->db_pass, $options);
			return $this->dbh;
		
		}catch (PDOException $e){

			$this->error = $e->getMessage();
			echo 'Error!: ' . $e->getMessage() . '<br>';
		}
	}

	public function query($sql){
		$this->stmt = $this->dbh->prepare($sql);
	}

	public function bind($param, $value, $type = ''){

		if (empty($type)){
			switch(true){

				case is_int($value): 
					$type = \PDO::PARAM_INT;
					break;
				case is_null($value): 
					$type = \PDO::PARAM_NULL;
					break;
				case is_bool($value):
					$type = \PDO::PARAM_BOOL;
					break;
				default:
					$type = \PDO::PARAM_STR;
			}
		}

		$this->stmt->bindValue($param,$value,$type);
	}

	public function execute(){
		return $this->stmt->execute();
	}

	public function singleResult(){
		$this->execute();
		return $this->stmt->fetch(\PDO::FETCH_OBJ);
	}

	public function multiResult(){
		$this->execute();
		return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	public function rowCount(){
		return $this->stmt->rowCount();
	}
}