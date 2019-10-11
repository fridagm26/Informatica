<div class="alert alert-danger" id="msg-error" style="text-align:left;">
    <strong>¡Importante!</strong> Corregir los siguientes errores.
    <div class="list-errors">
    	
    </div>
</div>
<form role="form" id="formulario" autocomplete="off">
	<div class="container-fluid">
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtDescripcion" class="control-label">Nombre</label>
				<input  name="txtDescripcion" data-info="<?php echo (isset($materiales[0]->descripcion)) ? $materiales[0]->descripcion : '' ?>"  data-id="<?php echo(isset($materiales[0]->id)) ? $materiales[0]->id : '' ?>" value="<?php echo(isset($materiales[0]->descripcion)) ? $materiales[0]->descripcion : '' ?>" class="form-control LetrasNumeros" id="txtDescripcion" placeholder="Ingrese la descripcion">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtCantidadExistencia" class="control-label">Cantidad Existencia</label>
				<input  name="txtCantidadExistencia" data-info="<?php echo(isset($materiales[0]->cantidadExistencia)) ? $materiales[0]->cantidadExistencia : '' ?>" value="<?php echo(isset($materiales[0]->cantidadExistencia)) ? $materiales[0]->cantidadExistencia : '' ?>" class="form-control LetrasNumeros" id="txtCantidadExistencia" placeholder="Ingrese la cantidad del producto">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="cmbCategorias">Categoria</label>
				<select class="form-control" name="cmbCategorias" id="cmbCategorias" data-info="<?php echo(isset($materiales[0]->id_categoria)) ? $materiales[0]->id_categoria : '' ?>" value="<?php echo(isset($materiales[0]->id_categoria)) ? $materiales[0]->id_categoria : '' ?>">
					<option value="0">Seleccione la categoria</option>
					<option value="2">Material</option>
					<option value="1">Equipo</option>
					<?php /* foreach($categorias as $categoria):?>
							<option value="<?php echo $categoria->id ?>" ><?php echo $categoria->descripcion ?></option>
					<?php endforeach; */ ?>
				</select>
			</div>	
		</div>
    </div> 
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validaciones.js"></script>
<script type="text/javascript">
	$("#msg-error").hide();
	
</script>