<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('db.php');
include_once('message.php');
$db = new Db();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BitCoinAdministration</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/css/bootstrap.min.css">
	<style type="text/css">
		.wrap{
			margin: auto;
			margin-top:10px;
			margin-bottom:10px;
			width: 50%;
		}
	</style>
	<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
	<script type="text/javascript">
	var formatNumber = {
	 separador: ",", // separador para los miles
	 sepDecimal: '.', // separador para los decimales
	 formatear:function (num){
	 num +='';
	 var splitStr = num.split('.');
	 var splitLeft = splitStr[0];
	 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
	 var regx = /(\d+)(\d{3})/;
	 while (regx.test(splitLeft)) {
	 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
	 }
	 return this.simbol + splitLeft +splitRight;
	 },
	 new:function(num, simbol){
	 this.simbol = simbol ||'';
	 return this.formatear(num);
	 }
	}
		$(document).ready(function(){
			
			$("#guardar").click(function(){
				var mensaje = 'Esta a punto de crear la siguiente operacion:\nMonto:'+formatNumber.new($("#monto").val())+' \nBTC:'+$('#btc').val()+' \nMoneda:'+$("#moneda").val()+' \nOperacion: '+$("#tipo").val()+' \n\nconforme?';
				if (!confirm(mensaje)) {
					return false;
				};
			});
			$("#idoperacion").blur(function(){
				$(this).parent().find('p').text("Verificando id de operación");
				var este = $(this);
				if (!$("#idoperacion").val()) { return;};

				$.ajax({
					url:'verificar.php?idoperacion='+$("#idoperacion").val(),
					dataType:'json',

					success:function(r){
						console.log(r)
						if (r) {
							este.parent().find('p').text("").css({
								border:'1px solid white',
								background:'white',
								color:'white'
							});
							
						}else{
							este.parent().find('p').text("Id de Verificación repetido").css({
								border:'1px solid red',
								background:'red',
								color:'white'
							});
							este.focus();

						}

					}
				})
			});
			$("#ref_pago").blur(function(){
				$(this).parent().find('p').text("Verificando id de operación");
				var este = $(this);
				if (!$("#ref_pago").val()) { return;};
				$.ajax({
					url:'verificar.php?ref_pago='+$("#ref_pago").val(),
					dataType:'json',

					success:function(r){
						console.log(r)
						if (r) {

							este.parent().find('p').text("").css({
								border:'1px solid white',
								background:'white',
								color:'white'
							});
							
						}else{
							este.parent().find('p').text("Id de Verificación repetido").css({
								border:'1px solid red',
								background:'red',
								color:'white'
							});
							este.focus();

						}

					}
				})
			})
		});
	</script>
</head>
<body>
	<div class="col-md-3 col-sm-3"></div>
	<div class="col-md-6 col-sm-6">
		<?php new Message() ?>
		<div class="text-center">
			<h2><span class="glyphicon glyphicon-bitcoin"></span>itcoin Administration</h2>
		</div>
		<form action="save.php" method="POST">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>#</label>
						<input type="text" value="<?php echo isset($_SESSION['data']['idoperacion']) ? $_SESSION['data']['idoperacion'] : '' ?>" required="required" class="form-control" name="idoperacion" id="idoperacion">
						<p class="muted">Validar esto antes de que se siga</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Referencia de Pago</label>
						<input type="text" required="required" value="<?php echo isset($_SESSION['data']['ref_pago']) ? $_SESSION['data']['ref_pago'] : '' ?>" class="form-control" name="ref_pago" id="ref_pago">
										<p class="muted">Validar esto antes de que se siga</p>

					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Tipo de Operacion</label>
						<select name="tipo" required="required"	class="form-control" id="tipo">
							<option value="">Seleccione</option>
							<option value="compra" <?php if(isset($_SESSION['data']['tipo']) and $_SESSION['data']['tipo']=='compra'){ echo 'selected';} ?>>Compra</option>
							<option value="venta" <?php if(isset($_SESSION['data']['tipo']) and $_SESSION['data']['tipo']=='venta'){ echo 'selected';} ?>>Venta</option>
						</select>
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Moneda</label>
						<select name="moneda" required="required" class="form-control" id="moneda">
							<option value="">Seleccione</option>
							<?php foreach ($db->get_currencies() as $key => $value): ?>
								<option value="<?php echo $value->currabrev ?>" <?php if(isset($_SESSION['data']['moneda']) and $_SESSION['data']['moneda']==$value->currabrev){ echo 'selected';} ?>><?php echo $value->currency ?></option>
							<?php endforeach ?>
						</select>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>BTC</label>
						<input type="text" required="required" value="<?php echo isset($_SESSION['data']['btc']) ? $_SESSION['data']['btc'] : '' ?>" class="form-control" name="btc" id="btc">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Monto</label>
						<input type="text" required="required" value="<?php echo isset($_SESSION['data']['monto']) ? $_SESSION['data']['monto'] : '' ?>" class="form-control" name="monto" id="monto">
					</div>
				</div>
			</div>
			


			<div class="form-group">
				<label>Observacion</label>
				<textarea name="observacion" required="required" id="observacion" class="form-control" cols="30" rows="2"> <?php echo isset($_SESSION['data']['observacion']) ? $_SESSION['data']['observacion'] : '' ?></textarea>
			</div>
			<input type="submit" class="btn btn-success" name="guardar" id="guardar" value="Guardar">
			<input type="reset" class="btn btn-default" name="reset" id="reset" value="Reset" onclick="$('input[type=text]').val('');$('select').val('');$('textarea').val('')">
			<button class="btn btn-danger" onclick="window.close()">Cerrar</button>
		</form>
	</div>
	<div class="col-md-3 col-sm-3"></div>
	
	<?php //var_dump() ?>
</body>
</html>