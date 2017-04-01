<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('db.php');
$db = new Db();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BitCoinAdministration</title>
	<link rel="stylesheet" href="css/css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
</head>
<body>
	<div class="wrap container">
		<div class="text-center">
			<h2>Bitcoin Administration</h2>
		</div>
		<form action="">
			<div class="form-group">
				<label>#</label>
				<input type="text" required="required" class="form-control" name="idoperacion" id="idoperacion">
				<p class="muted">validar esto antes de que se siga</p>
			</div>
			<div class="form-group">
				<label>Tipo de Operacion</label>
				<select name="tipo" required="required"	class="form-control" id="tipo">
					<option value="">Seleccione</option>
					<option value="compra">Compra</option>
					<option value="venta">Venta</option>
				</select>
			</div>
			<div class="form-group">
				<label>Moneda</label>
				<select name="moneda" required="required" class="form-control" id="moneda">
					<option value="">Seleccione</option>
					<?php foreach ($db->get_currencies() as $key => $value): ?>
						<option value="<?php echo $value->currabrev ?>"><?php echo $value->currency ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="form-group">
				<label>BTC</label>
				<input type="text" required="required" class="form-control" name="btc" id="btc">
			</div>
			<div class="form-group">
				<label>Monto</label>
				<input type="text" required="required" class="form-control" name="monto" id="monto">
			</div>
			<div class="form-group">
				<label>Referencia de Pago</label>
				<input type="text" required="required" class="form-control" name="ref_pago" id="ref_pago">
								<p class="muted">validar esto antes de que se siga</p>

			</div>
			<div class="form-group">
				<label>Observacion</label>
				<textarea name="observacion" required="required" id="observacion" class="form-control" cols="30" rows="2"></textarea>
			</div>
			<input type="submit" class="btn btn-success" value="Guardar">
		</form>
	</div>
	
	<?php //var_dump() ?>
</body>
</html>