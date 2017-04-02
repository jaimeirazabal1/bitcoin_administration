<?php
// session_start();

class Message{
	public function __construct(){
		// var_dump($_SESSION);
		if (isset($_SESSION['mensaje.alerta'])) {
			// code...
			for ($i=0; $i < count($_SESSION['mensaje.alerta']) ; $i++) { 
				echo "<div class='".$_SESSION['mensaje.alerta'][$i][0]."'>".$_SESSION['mensaje.alerta'][$i][1]."</div>";
				unset($_SESSION['mensaje.alerta'][$i][0]);
				unset($_SESSION['mensaje.alerta'][$i][1]);
			}
			unset($_SESSION['mensaje.alerta']);
		}
	}
}