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
		$_POST[$key]=$value;
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
	<style type="text/css">
		.wrap{
			margin-top:10px;
			margin-bottom:10px;
		}
		.table-condensed tr:hover{
			background-color: #eee;
		}
		.eliminar:hover{
			cursor:pointer;
		}
	</style>
	<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.es.min.js"></script>
	<link rel="stylesheet" href="css/css/bootstrap-datepicker.min.css">




</head>
<body>

	<div class="text-center">
		<h2>Lista de Transacciones</h2>
		<?php new Message() ?>
		<div class="container" style="position:relative">
			<div style="position:absolute;left:20px;top:-60px">
				<table class="">
				
					<tr>
						<td><img src="bitcoin-495997_640.png" alt="" width="150px"></td>
					</tr>
				</table>
			</div>
			<div style="position:absolute;right:20px;top:-40px">
				<table class="table table-bordered">
					<thead>
						<th class="text-center">Cartera</th>
					</thead>
					<tr>
						<td><?php echo $db->get_saldo() ?></td>
					</tr>
				</table>
			</div>
		</div>
		<form action="" style="width:100%;margin:auto" class="form-inline">
			<div class="form-group">
				<label>Moneda</label>
				<select name="moneda" class="form-control" id="moneda">
					<?php foreach ($db->get_currencies() as $key => $value): ?>
						<?php if (isset($_GET['moneda']) and $_GET['moneda'] == $value->currabrev): ?>
							
							<option value="<?php echo $value->currabrev ?>" selected><?php echo $value->currency ?></option>
					<?php else: ?>
							<option value="<?php echo $value->currabrev ?>"><?php echo $value->currency ?></option>

						<?php endif ?>
					<?php endforeach ?>
				</select>
	            <select name="created" class="form-control" id="created">
	            	<option value="hoy" <?php if(isset($_GET['created']) and $_GET['created'] == 'hoy'): echo "selected"; endif; ?>>Hoy</option>
	            	<option value="mes" <?php if(isset($_GET['created']) and $_GET['created'] == 'mes'): echo "selected"; endif; ?>>Mes</option>
	            	<option value="todo" <?php if(isset($_GET['created']) and $_GET['created'] == 'todo'): echo "selected"; endif; ?>>Todo</option>
	            </select>
				<input type="submit" class="btn btn-default" name="buscar" value="Buscar">
				<a href="index.php" class="btn btn-default" onclick="window.open('index.php', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');return false;" >Agregar Transaccion</a>
			</div>
		</form>
	</div>
	<div class="wrap container">

		<div class="row">
			<div class="col-md-6 col-sm-6">
				<table class="table table-condensed table-bordered">
					<?php if (isset($_GET['moneda']) and $_GET['moneda']): ?>
						<?php $suma_result = $db->get_suma_compra($_GET['moneda']) ?>
						<?php $monto_result = $db->get_suma_monto($_GET['moneda']) ?>

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
						<td id="display_btc_suma1" class="text-center"><?php echo $suma_result ?></td>
						<td id="display_monto_suma1" class="text-center"><?php echo number_format($monto_result,2,'.',',') ?></td>
						<?php if (isset($btc_suma) and $btc_suma): ?>
							
						<td id="display_division1" class="text-center"><?php echo number_format((float)$monto_suma/$btc_suma,2,'.',',') ?></td>
						<?php endif ?>
					</tr>
					<tr>
						<td class="text-center"><b>Total Compra</b></td>
						<td class="text-center"><b>Total Monto</b></td>
						<td class="text-center"><b>Promedio Compra</b></td>
					</tr>
				</table>
				<div class="text-center bg-info" >
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
					<?php //$transaction = $db->get_transaction() ?>
					<?php if (isset($_GET['moneda']) and $_GET['moneda']): ?>
						<?php $transaction = $db->get_by_moneda($_GET['moneda']) ?>
					<?php endif ?>
					<?php if (count($transaction)): ?>
					<?php $btc_suma = 0; ?>
					<?php $monto_suma = 0; ?>
					<?php $cantidad_compras = 0 ?>
						<?php foreach ($transaction as $key => $value): ?>
							<tr class='eliminar' id="<?php echo $value->idoperacion ?>">
								<td><?php echo $value->idoperacion ?></td>
								<td><?php echo $value->moneda ?></td>
								<td><?php echo str_replace(',', '.', $value->btc) ?></td>
								<td><?php echo number_format(str_replace(',','.',str_replace('.', '', $value->monto)),2,'.',',') ?></td>
								<td><?php echo $value->ref_pago ?></td>
								<!--<td><?php echo $value->observacion ?></td>-->
								<td title="<?php echo $value->created.' | '.$value->observacion ?>">
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
						<?php $suma_result = $db->get_suma_compra($_GET['moneda'],'venta') ?>
						<?php $monto_result = $db->get_suma_monto($_GET['moneda'],'venta') ?>
						<?php $btc_suma = 0; ?>
						<?php $monto_suma = 0; ?>
						<?php foreach ($promedio as $key => $value): ?>
								<?php $btc_suma = $btc_suma + str_replace(',', '.', $value->btc) ?>
								<?php $monto_suma = $monto_suma + (float)str_replace(',','.',str_replace('.', '', $value->monto)) ?>
							</tr>
						<?php endforeach ?>
					<?php endif; ?>
					<tr>
						<td id="display_btc_suma1" class="text-center"><?php echo $suma_result ?></td>
						<td id="display_monto_suma1" class="text-center"><?php echo number_format($monto_result,2,'.',',') ?></td>
						<?php if (isset($btc_suma) and $btc_suma): ?>
							
						<td id="display_division1" class="text-center"><?php echo number_format((float)$monto_suma/$btc_suma,2,'.',',') ?></td>
						<?php endif ?>
					</tr>
					<tr>
						<td class="text-center"><b>Total Venta</b></td>
						<td class="text-center"><b>Total Monto</b></td>
						<td class="text-center"><b>Promedio Venta</b></td>
					</tr>
				</table>
				<div class="text-center bg-success">
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
					<?php //$transaction = $db->get_transaction('venta') ?>
					<?php if (isset($_GET['moneda']) and $_GET['moneda']): ?>
					
						<?php $transaction = $db->get_by_moneda($_GET['moneda'],'venta') ?>
					<?php endif ?>
					<?php if (count($transaction)): ?>
					<?php $btc_suma2 = 0; ?>
					<?php $monto_suma2 = 0; ?>
					<?php $cantidad_ventas = 0; ?>
						<?php foreach ($transaction as $key => $value): ?>
							<tr class='eliminar' id="<?php echo $value->idoperacion ?>">
								<td><?php echo $value->idoperacion ?></td>
								<td><?php echo $value->moneda ?></td>
								<td><?php echo str_replace(',', '.', $value->btc) ?></td>
								<td><?php echo number_format(str_replace(',','.',str_replace('.', '', $value->monto)),2,'.',',') ?></td>
								<td><?php echo $value->ref_pago ?></td>
								<!-- <td><?php echo $value->observacion ?></td> -->
								<td title="<?php echo $value->created.' | '.$value->observacion ?>">
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
				$('#datetimepicker1,#datetimepicker2').datetimepicker({
					format : 'YYYY-MM-DD HH:mm:ss'
				});

				$('.eliminar').on("contextmenu", function(evt) {
					evt.preventDefault();
					if (confirm('Esta Seguro que desea eliminar la transaccion #'+$(this).attr("id"))) {
					    location.href='delete.php?idoperacion='+$(this).attr("id");
					};
					return false;
				});
				
				<?php if (count($db->get_by_moneda($_GET['moneda']))): ?>
			    $('#compra').DataTable({
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
				<?php endif; ?>
				<?php if (count($db->get_by_moneda($_GET['moneda'],'venta'))): ?>

			    $('#venta').DataTable({
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
				<?php endif; ?>
			} );
		</script>
	</div>


</body>
</html>