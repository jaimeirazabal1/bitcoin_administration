<?php


class Db extends PDO{

	private $dbini;

	public function __construct(){
		$this->dbini = parse_ini_file('db.ini');
		parent::__construct("mysql:dbname=".$this->dbini['dbname'].";host=".$this->dbini['host'], $this->dbini['dbuser'], $this->dbini['dbpassword']);
	}
	public function get_currencies(){
		$query = "SELECT * from currencies";
		return $this->get($query);
	}
	public function get($query){
		$result = parent::query($query);
		$rows=array();
		while ($row = $result->fetch(PDO::FETCH_OBJ)) {
			
			$rows[]=$row;
		}
		return $rows;		
	}
	public function count_($query){
		$result = parent::query($query);
		return $result->rowCount();
	}
	public function esCampoRepetido($campo,$valor,$tabla='transaction'){
		if ($valor) {
			$r = parent::query("SELECT * from $tabla where $campo = '".$valor."'");
			if($r->rowCount()){
				return true;
			}else{
				return false;
			}
		}		
		return true;
	}
	public function guardar($tabla,$campos,$exceptionFields=array()){
		$query="INSERT INTO $tabla ";
		$keys=array();
		$values=array();
		foreach ($campos as $key => $value) {
			if (!in_array($key, $exceptionFields)) {
				# code...
				$keys[]=$key;
				$values[]=$value;
			}
		}
		$keys = "(".implode(",",$keys).")";
		$values = "('".implode("','",$values)."')";
		$query = $query.$keys." values ".$values;
		// var_dump($query);
		$r = parent::query($query);
		return $r;
	}
	public function get_transaction($tipo = 'compra'){
		if (isset($_GET['created']) and !empty($_GET['created'])) {
			$partes = explode(' ',$_GET['created']);
			if ($partes[1] == '00:00:00' or $partes[1]='') {
				$date_sub = " and  CAST(created AS DATE) = '".$partes[0]."' ";
			}else{
				$date_sub = " and created = '".$_GET['created']."' ";
			}
			$query = "SELECT * FROM transaction where tipo = '".$tipo."' $date_sub order by created asc";
		}else{
			$query = "SELECT * FROM transaction where tipo = '".$tipo."' order by created asc";
		}
		return $this->get($query);
	}
	public function get_by_moneda($moneda,$tipo = "compra"){
		if (isset($_GET['created']) and !empty($_GET['created'])) {
			$partes = explode(' ',$_GET['created']);
			if ($partes[1] == '00:00:00' or $partes[1]='') {
				$date_sub = " and  CAST(created AS DATE) = '".$partes[0]."' ";
			}else{
				$date_sub = " and created = '".$_GET['created']."' ";
			}
			$query = "SELECT * FROM transaction WHERE tipo = '".$tipo."' and moneda = '".$moneda."' $date_sub order by created asc";
		}else{
			$query = "SELECT * FROM transaction WHERE tipo = '".$tipo."' and moneda = '".$moneda."' order by created asc";
		}
		return $this->get($query);
	}
	public function get_promedio($moneda,$tipo = "compra"){
		$query = "SELECT * from transaction WHERE	
		created BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() and tipo = '".$tipo."' and moneda = '".$moneda."' order by created asc";
		return $this->get($query);
	}
}