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
				<input  name="txtnombre" data-info="<?php echo (isset($perfiles[0]->nombre)) ? $perfiles[0]->nombre : '' ?>"  data-id="<?php echo(isset($perfiles[0]->id)) ? $perfiles[0]->id : '' ?>" value="<?php echo(isset($perfiles[0]->nombre)) ? $perfiles[0]->nombre : '' ?>" class="form-control LetrasNumeros" id="txtnombre" placeholder="Ingrese el nombre">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="txtdescripcion">Descripción</label>
				<input name="txtdescripcion" data-info="<?php echo(isset($perfiles[0]->descripcion)) ? $perfiles[0]->descripcion : '' ?>" value="<?php echo(isset($perfiles[0]->descripcion)) ? $perfiles[0]->descripcion : '' ?>" class="form-control LetrasNumeros" id="txtdescripcion" placeholder="Ingrese una breve descripción">
			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validaciones.js"></script>
<script type="text/javascript">
	$("#msg-error").hide();
	
</script>
