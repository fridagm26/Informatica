<div class="alert alert-danger" id="msg-error" style="text-align:left;">
    <strong>¡Importante!</strong> Corregir los siguientes errores.
    <div class="list-errors">
    	
    </div>
</div>
<form role="form" id="formulario" autocomplete="off">
	<div class="container-fluid">
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtnombre" class="control-label">Nombre</label>
				<input  name="txtnombre" data-info="<?php echo (isset($laboratorios[0]->descripcion)) ? $laboratorios[0]->descripcion : '' ?>"  data-id="<?php echo(isset($laboratorios[0]->id)) ? $laboratorios[0]->id : '' ?>" value="<?php echo(isset($laboratorios[0]->descripcion)) ? $laboratorios[0]->descripcion : '' ?>" class="form-control LetrasNumeros" id="txtnombre" placeholder="Ingrese el nombre">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="txtubicacion">Ubicacion</label>
				<input name="txtubicacion" data-info="<?php echo(isset($laboratorios[0]->ubicacion)) ? $laboratorios[0]->ubicacion : '' ?>" value="<?php echo(isset($laboratorios[0]->ubcacion)) ? $laboratorios[0]->ubicacion : '' ?>" class="form-control LetrasNumeros" id="txtubicacion" placeholder="Ingrese ubicacion">
			</div>
		</div>
        <div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="txtcapacidad">Capacidad</label>
				<input name="txtcapacidad" data-info="<?php echo(isset($laboratorios[0]->capacidad)) ? $laboratorios[0]->capacidad : '' ?>" value="<?php echo(isset($laboratorios[0]->capacidad)) ? $laboratorios[0]->capacidad : '' ?>" class="form-control Numeros" id="txtcapacidad" placeholder="Ingrese capacidad">
			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validaciones.js"></script>
<script type="text/javascript">
	$("#msg-error").hide();
	
</script>