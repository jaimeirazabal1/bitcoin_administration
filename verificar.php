<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("db.php");

$db = new Db();

if (isset($_GET['idoperacion'])) {
	if ($db->buscarIdOperacion($_GET['idoperacion'])) {
		die(json_encode(false));
	}else{
		die(json_encode(true));
	}
}
if (isset($_GET['ref_pago'])) {
	if ($db->buscarRefPago($_GET['ref_pago'])) {
		die(json_encode(false));
	}else{
		die(json_encode(true));
	}
}
// var_dump($_POST);