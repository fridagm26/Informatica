<div class="alert alert-danger" id="msg-error" style="text-align:left;">
    <strong>¡Importante!</strong> Corregir los siguientes errores.
    <div class="list-errors">
    	
    </div>
</div>
<form role="form" id="formulario" autocomplete="off">
	<div class="container-fluid">
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtdescripcion" class="control-label">Descripcion</label>
				<input  name="txtdescripcion" data-info="<?php echo (isset($categorias[0]->descripcion)) ? $categorias[0]->descripcion : '' ?>"  data-id="<?php echo(isset($categorias[0]->id)) ? $categorias[0]->id : '' ?>" value="<?php echo(isset($categorias[0]->descripcion)) ? $categorias[0]->descripcion : '' ?>" class="form-control LetrasNumeros" id="txtdescripcion" placeholder="Ingrese la descripcion">
			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validaciones.js"></script>
<script type="text/javascript">
	$("#msg-error").hide();
	
</script>