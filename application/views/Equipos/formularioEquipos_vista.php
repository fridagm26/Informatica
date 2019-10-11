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
				<input  name="txtDescripcion" data-info="<?php echo (isset($equipos[0]->descripcion)) ? $equipos[0]->descripcion : '' ?>"  data-id="<?php echo(isset($equipos[0]->id)) ? $equipos[0]->id : '' ?>" value="<?php echo(isset($equipos[0]->descripcion)) ? $equipos[0]->descripcion : '' ?>" class="form-control LetrasNumeros" id="txtDescripcion" placeholder="Ingrese la descripcion">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtNumInv" class="control-label">Numero de Inventario</label>
				<input  name="txtNumInv" data-info="<?php echo(isset($equipos[0]->numInventario)) ? $equipos[0]->numInventario : '' ?>" value="<?php echo(isset($equipos[0]->numInventario)) ? $equipos[0]->numInventario : '' ?>" class="form-control LetrasNumeros" id="txtNumInv" placeholder="Ingrese el numero de inventario">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtSerie" class="control-label">Numero de Serie</label>
				<input  name="txtSerie" data-info="<?php echo(isset($equipos[0]->serie)) ? $equipos[0]->serie : '' ?>" value="<?php echo(isset($equipos[0]->serie)) ? $equipos[0]->serie : '' ?>" class="form-control LetrasNumeros" id="txtSerie" placeholder="Ingrese el numero de serie">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtResguardo" class="control-label">Resguardo</label>
				<input  name="txtResguardo" data-info="<?php echo(isset($equipos[0]->resguardo)) ? $equipos[0]->resguardo : '' ?>" value="<?php echo(isset($equipos[0]->resguardo)) ? $equipos[0]->resguardo : '' ?>" class="form-control LetrasNumeros" id="txtResguardo" placeholder="Ingrese el resguardo">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="cmbCategorias">Categoria</label>
				<select class="form-control" name="cmbCategorias" id="cmbCategorias" data-info="<?php echo(isset($equipos[0]->id_categoria)) ? $equipos[0]->id_categoria : '' ?>" value="<?php echo(isset($equipos[0]->id_categoria)) ? $equipos[0]->id_categoria : '' ?>">
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