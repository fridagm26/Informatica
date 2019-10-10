<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<div class="content-wrapper">
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<blockquote style="border-left: 5px solid #2f4159">
					<h1 class="text-justify">Entradas</h1>
				</blockquote>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<label for="cmbTipoEnt">Tipos de entradas</label>
					<select name="cmbTipoEnt" id="cmbTipoEnt" class="form-control">
						<option value="-1" selected>Todos</option>
						<option value="0">No consumible</option>
						<option value="1">Consumible</option>
						<option value="2">Activos</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="txtFecha1">Apartir del día:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>							
						</div>
						<input type="text" class="form-control" id="txtFecha1" name="txtFecha1" placeholder="Selecciona una fecha de inicio">
						<div class="input-group-btn">
							<button class="btn btn-default btnFiltrar" type="button" title="Buscar por fecha"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
				<div class="form-group col-md-4">
					<label for="txtFecha2">Hasta el día:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control" id="txtFecha2" name="txtFecha2" placeholder="Selecciona una fecha de fin">
						<div class="input-group-btn">
							<button class="btn btn-default btnFiltrar" type="button" title="Buscar por fecha"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="clear">&nbsp;</div>						
			<div class="row">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-list"></i> Listado de entradas</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><li class="fa fa-minus"> </li></button>
						</div>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="tblEntradas" class="table table-hover table-striped no-margin" style="width: 100%">
								<thead>
									<tr>
										<th>ID Entrada</th>
										<th>Encargado</th>
										<th>Proveedor</th>
										<th>Registro</th>
										<th>Emision </th>
										<th>Recibido</th>
										<th>Detalles</th>
									</tr>
								</thead>
								<tbody id="contenidoTabla">
									
								</tbody>
							</table>
							<a href="<?php echo base_url("index.php/Entradas")?>" class="btn btn-primary btn-lg" style="background-color: #264d78">Hacer entradas</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> <!-- /.content -->
</div>
<?php $this->load->view('Global/footer')?>
<script>
	$(document).ready(function() {
		var tabla = insertarPaginado("tblEntradas", 10, true);
		var entradas = JSON.parse('<?php echo json_encode($entradas)?>');
		$(".btnFiltrar").click(function () { obtenerDatos(); });
		dibujarTabla(entradas);

		$("#txtFecha1").datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true,
			todayHighlight: true
		}).datepicker("setDate", new Date());

		$("#txtFecha2").datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true,
			todayHighlight: true,			
		}).datepicker("setDate", new Date());

		function fechaJS($fecha) {
			return $fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
		}

		function dibujarTabla (data) {
			tabla.clear().draw();
			$.each(data, function(index, item) {							
				var fila = tabla.row.add([
					item['id'],							
					item['encargado'],
					item['proveedor'],
					fechaJS(item['fecha_entrada']),
					fechaJS(item['fecha_emision']),
					fechaJS(item['fecha_recibido']),
					"<a href='<?php echo base_url("index.php/Entradas/listarDetalle/")?>"+item['id']+"' class='btn btn-primary btn-sm'><span class='fa fa-eye'></span></a>"
				]).draw(false).node();
			});
		}

		function obtenerDatos() {
			var $status = $("#cmbTipoEnt").val(),
				$fechaInicio = $("#txtFecha1").val(),
				$fechaFin = $("#txtFecha2").val();
				console.log($fechaInicio + "\n" + $fechaFin);
			$.ajax({
				url: base_url + "index.php/Entradas/listar",
				data: {
					status: $status,
					fechaInicio: $fechaInicio,
					fechaFin: $fechaFin
				},
				type: "POST",
				success:function(res) {					
					dibujarTabla(JSON.parse(res));
				},
				error:function(jqXHR, textStatus, errorThrown) {
					console.error("Error::" + errorThrown);
				}
			});
		}

		$("#cmbTipoEnt").change( function() { obtenerDatos (); });		
	});
</script>
