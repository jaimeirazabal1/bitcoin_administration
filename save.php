<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("db.php");

$db = new Db();

if (isset($_POST['guardar'])) {
	if (!$db->esCampoRepetido('idoperacion',$_POST['idoperacion'])) {
		if (!$db->esCampoRepetido('ref_pago',$_POST['ref_pago'])) {
			if($db->guardar('transaction',$_POST,array('guardar'))){
				$_SESSION['mensaje.alerta'][] = array('alert alert-success','transaction succesfully saved!');
				unset($_SESSION['data']);
			}
		}else{
			$_SESSION['mensaje.alerta'][] = array('alert alert-danger','La referencia de pago esta repetida');
			$error=1;
		}
	}else{
		$_SESSION['mensaje.alerta'][] = array('alert alert-danger','El id de operacion '.$_POST['idoperacion'].' esta repetido');
		$error=1;
	
	}
}
if (isset($error)) {
	foreach ($_POST as $key => $value) {
		if ($key != 'guardar') {
			$_SESSION['data'][$key]=$value;
		}
	}
}
Header("Location: index.php");
// var_dump($_POST);