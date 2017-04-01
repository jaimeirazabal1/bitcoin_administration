<?php


class Db extends PDO{

	private $dbini;

	public function __construct(){
		$this->dbini = parse_ini_file('db.ini');
		parent::__construct("mysql:dbname=".$this->dbini['dbname'].";host=".$this->dbini['host'], $this->dbini['dbuser'], $this->dbini['dbpassword']);
	}
	public function get_currencies(){
		$query = "SELECT * from currencies";
		$result = parent::query($query);
		$rows=array();
		while ($row = $result->fetch(PDO::FETCH_OBJ)) {
			
			$rows[]=$row;
		}
		return $rows;
	}
}