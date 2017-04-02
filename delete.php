<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("db.php");

$db = new Db();

if (isset($_GET['idoperacion'])) {

	if (count($db->delete($_GET['idoperacion'])) == 0) {
			$_SESSION['mensaje.alerta'][] = array('alert alert-success','transaction succesfully deleted #'.$_GET['idoperacion'].'! ');
				// unset($_SESSION['data']);
		}else{
			$_SESSION['mensaje.alerta'][] = array('alert alert-danger','No se pudo borrar la transaccion #'.$_GET['idoperacion']);
			$error=1;
		}
	}else{
		$_SESSION['mensaje.alerta'][] = array('alert alert-danger','No se recibio el id de operacion');
		$error=1;
	
	}


Header("Location: list.php?moneda=VEF&created=hoy&buscar=Buscar");
// var_dump($_POST);