<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('db.php');
include_once('message.php');
$db = new Db();
if (isset($_SESSION['data'])) {
	foreach ($_SESSION['data'] as $key => $value) {
		$_POST[$key]=$vallue;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BitCoinAdministration</title>
	<link rel="stylesheet" href="css/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/css/bootstrap-datepicker.min.css">
	<style type="text/css">
		.wrap{
			margin-top:10px;
			margin-bottom:10px;
		}
		.table-condensed tr:hover{
			background-color: #eee;
		}
	</style>
	<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.es.min.js"></script>



</head>
<body>
	<div class="text-center">
		<h2>Lista de Transacciones</h2>
		<form action="" style="width:800px;margin:auto" class="form-inline">
			<div class="form-group">
				<label>Moneda</label>
				<select name="moneda" class="form-control" id="moneda">
					<option value="">Seleccione</option>
					<?php foreach ($db->get_currencies() as $key => $value): ?>
						<?php if (isset($_GET['moneda']) and $_GET['moneda'] == $value->currabrev): ?>
							
							<option value="<?php echo $value->currabrev ?>" selected><?php echo $value->currency ?></option>
					<?php else: ?>
							<option value="<?php echo $value->currabrev ?>"><?php echo $value->currency ?></option>

						<?php endif ?>
					<?php endforeach ?>
				</select>
	            <div class="form-group">
	                <div class='input-group date' id='datetimepicker1'>
	                    <input type='text' name="created" class="form-control" value="<?php if(isset($_GET['created'])): echo $_GET['created']; endif; ?>" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
				<input type="submit" class="btn btn-default" name="buscar" value="Buscar">
				<a href="index.php" class="btn btn-default">Agregar Transaccion</a>
			</div>
		</form>
	</div>
	<div class="wrap container">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<table class="table table-condensed table-bordered">
					<?php if (isset($_GET['moneda']) and $_GET['moneda']): ?>
						<?php $promedio = $db->get_promedio($_GET['moneda']) ?>
						<?php $btc_suma = 0; ?>
						<?php $monto_suma = 0; ?>
						<?php foreach ($promedio as $key => $value): ?>
								<?php $btc_suma = $btc_suma + str_replace(',', '.', $value->btc) ?>
								<?php $monto_suma = $monto_suma + (float)str_replace(',','.',str_replace('.', '', $value->monto)) ?>
							</tr>
						<?php endforeach ?>
					<?php endif; ?>
					<tr>
						<td id="display_btc_suma1" class="text-center"><?php echo number_format($btc_suma,8,'.',',') ?></td>
						<td id="display_monto_suma1" class="text-center"><?php echo number_format($monto_suma,2,'.',',') ?></td>
						<td id="display_division1" class="text-center"><?php echo number_format((float)$monto_suma/$btc_suma,2,'.',',') ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="text-center"><b>Promedio Compra</b></td>
					</tr>
				</table>
				<div class="text-center">
					<h3>Compra</h3>
				</div>
				<table class="table table-condensed table-bordered" id="compra">
					<thead>
						<th>#</th>
						<th>Moneda</th>
						<th>BTC</th>
						<th>Monto</th>
						<th>Ref.Pago</th>
						<!-- <th>Observacion</th> -->
						<th>Tasa</th>
					</thead>
					<?php $transaction = $db->get_transaction() ?>
					<?php if (isset($_GET['moneda']) and $_GET['moneda']): ?>
						<?php $transaction = $db->get_by_moneda($_GET['moneda']) ?>
					<?php endif ?>
					<?php if (count($transaction)): ?>
					<?php $btc_suma = 0; ?>
					<?php $monto_suma = 0; ?>
					<?php $cantidad_compras = 0 ?>
						<?php foreach ($transaction as $key => $value): ?>
							<tr>
								<td><?php echo $value->idoperacion ?></td>
								<td><?php echo $value->moneda ?></td>
								<td><?php echo str_replace(',', '.', $value->btc) ?></td>
								<td><?php echo number_format(str_replace(',','.',str_replace('.', '', $value->monto)),2,'.',',') ?></td>
								<td><?php echo $value->ref_pago ?></td>
								<!--<td><?php echo $value->observacion ?></td>-->
								<td>
									<?php echo number_format((float)str_replace(',','.',str_replace('.', '', $value->monto))/(float)str_replace(',', '.', $value->btc),2,'.',',') ?>
								</td>
							</tr>
						<?php $cantidad_compras++ ?>
						<?php endforeach ?>
					<?php else: ?>
						<th colspan="8" class="text-center">
							<h2>No hay registros</h2>
						</th>
					<?php endif ?>
				</table>
			</div>
			<div class="col-md-6 col-sm-6">
				<table class="table table-condensed table-bordered">
					<?php if (isset($_GET['moneda']) and $_GET['moneda']): ?>
						<?php $promedio = $db->get_promedio($_GET['moneda'],'venta') ?>
						<?php $btc_suma = 0; ?>
						<?php $monto_suma = 0; ?>
						<?php foreach ($promedio as $key => $value): ?>
								<?php $btc_suma = $btc_suma + str_replace(',', '.', $value->btc) ?>
								<?php $monto_suma = $monto_suma + (float)str_replace(',','.',str_replace('.', '', $value->monto)) ?>
							</tr>
						<?php endforeach ?>
					<?php endif; ?>
					<tr>
						<td id="display_btc_suma1" class="text-center"><?php echo number_format($btc_suma,8,'.',',') ?></td>
						<td id="display_monto_suma1" class="text-center"><?php echo number_format($monto_suma,2,'.',',') ?></td>
						<td id="display_division1" class="text-center"><?php echo number_format((float)$monto_suma/$btc_suma,2,'.',',') ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="text-center"><b>Promedio Venta</b></td>
					</tr>
				</table>
				<div class="text-center">
					<h3>Venta</h3>
				</div>
				<table class="table table-condensed table-bordered" id="venta">
					<thead>
						<th>#</th>
						<th>Moneda</th>
						<th>BTC</th>
						<th>Monto</th>
						<th>Ref.Pago</th>
						<!-- <th>Observacion</th> -->
						<th>Tasa</th>
					</thead>
					<?php $transaction = $db->get_transaction('venta') ?>
					<?php if (isset($_GET['moneda']) and $_GET['moneda']): ?>
					
						<?php $transaction = $db->get_by_moneda($_GET['moneda'],'venta') ?>
					<?php endif ?>
					<?php if (count($transaction)): ?>
					<?php $btc_suma2 = 0; ?>
					<?php $monto_suma2 = 0; ?>
					<?php $cantidad_ventas = 0; ?>
						<?php foreach ($transaction as $key => $value): ?>
							<tr>
								<td><?php echo $value->idoperacion ?></td>
								<td><?php echo $value->moneda ?></td>
								<td><?php echo str_replace(',', '.', $value->btc) ?></td>
								<td><?php echo number_format(str_replace(',','.',str_replace('.', '', $value->monto)),2,'.',',') ?></td>
								<td><?php echo $value->ref_pago ?></td>
								<!-- <td><?php echo $value->observacion ?></td> -->
								<td>
									<?php echo number_format((float)str_replace(',','.',str_replace('.', '', $value->monto))/(float)str_replace(',', '.', $value->btc),2,'.',',') ?>
								</td>
							</tr>
							<?php $cantidad_ventas++ ?>
						<?php endforeach ?>
					<?php else: ?>
						<th colspan="8" class="text-center">
							<h2>No hay registros</h2>
						</th>
					<?php endif ?>
				</table>
			</div>
		</div>
		
		
		<script type="text/javascript">
			$(document).ready(function() {
				$('#datetimepicker1').datetimepicker({
					format : 'YYYY-MM-DD HH:mm:ss'
				});
			    $('#compra,#venta').DataTable({
			    	"aaSorting": [],
			    	language:{
					    "sProcessing":     "Procesando...",
					    "sLengthMenu":     "Mostrar _MENU_ registros",
					    "sZeroRecords":    "No se encontraron resultados",
					    "sEmptyTable":     "Ningún dato disponible en esta tabla",
					    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
					    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
					    "sInfoPostFix":    "",
					    "sSearch":         "Buscar:",
					    "sUrl":            "",
					    "sInfoThousands":  ",",
					    "sLoadingRecords": "Cargando...",
					    "oPaginate": {
					        "sFirst":    "Primero",
					        "sLast":     "Último",
					        "sNext":     "Siguiente",
					        "sPrevious": "Anterior"
					    },
					    "oAria": {
					        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
					    }
					}
			    });
			} );
		</script>
	</div>


</body>
</html>