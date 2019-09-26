<div class="alert alert-danger" id="msg-error" style="text-align:left;">
    <strong>¡Importante!</strong> Corregir los siguientes errores.
    <div class="list-errors">
    	
</div>
</div>
<form role="form" id="formulario" autocomplete="off">
	<div class="container-fluid">
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="txtusuario">Usuario</label>
				<input name="txtusuario" data-info="<?php echo(isset($usuario)) ? $usuario->nombre_usuario : '' ?>"  value="<?php echo(isset($usuario)) ? $usuario->nombre_usuario : '' ?>" class="form-control LetrasNumeros" id="txtusuario" placeholder="Ingrese el Usuario">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="txtcontraseña">Contraseña</label>
				<input type="password" name="txtcontraseña"  class="form-control LetrasNumeros" id="txtcontraseña" placeholder="Ingrese Contraseña">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label" for="txtcontraseña2">Confirmación Contraseña</label>
				<input type="password" name="txtconfirmcontraseña" class="form-control LetrasNumeros" id="txtcontraseña2" placeholder="Ingrese Confirmación Contraseña">
			</div>
		</div>
		<div class="form-group col-md-6">
			<label class="control-label" for="cmbPerfiles">Perfil</label>
			<select class="form-control" name="cmbPerfiles" id="cmbPerfiles">
				<option value="0">Seleccione el Perfil</option>
				<?php foreach($perfiles as $perfil):?>
						<option value="<?php echo $perfil->id ?>" ><?php echo $perfil->nombre?></option>						
				<?php endforeach; ?>
			</select>
		</div>
	</div>
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validaciones.js"></script>
<script type="text/javascript">
	$("#msg-error").hide();	
</script>