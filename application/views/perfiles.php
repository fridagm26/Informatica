<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<!-- MODAL -->
<div class="modal" id="modal-añadir" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="nuevoPerfil" action="<?php echo base_url() ?>index.php/Perfiles/agregarPerfil" method="POST">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese Nombre">
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="descripcion" placeholder="Ingrese Descripción">
                        <small class="form-text text-muted">Ingrese una pequeña descripción del perfil.</small>
                    </div>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-modificar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modificarPerfil" action="<?php echo base_url() ?>index.php/Perfiles/modificarPerfil" method="POST">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombreModificar" placeholder="Ingrese Nombre">
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="descripcionModificar" placeholder="Ingrese Descripción">
                        <small class="form-text text-muted">Ingrese una pequeña descripción del perfil.</small>
                    </div>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
       <section class="content">
			 	<h1>Perfiles</h1>
       	<div class="row">
				 <!-- Empieza tabla -->
				 <table class="table ta" id="tablaPerfiles">
					<thead>
						<tr>
							<th scope="col">Nombre</th>
							<th scope="col">Descripción</th>
							<th scope="col">Estado</th>
                            <th scope="col">Acción</th>
						</tr>
					</thead>
					<tbody>
                        <?php 
                            foreach($perfiles as $perfil){
                                $estado='<button type="button" onclick="estadoPerfil(\''.$perfil->id.'\',\''.$perfil->estatus.'\')" class="btn btn-success">Activar</button>';
                                if($perfil->estatus==1){
                                    $estado='<button type="button" onclick="estadoPerfil(\''.$perfil->id.'\',\''.$perfil->estatus.'\')" class="btn btn-danger">Desactivar</button>';
                                }
                                echo 
                                    '<tr>
                                        <td>'.$perfil->nombre.'</td>
                                        <td>'.$perfil->descripcion.'</td>
                                        <td>'.$estado.'</td>
                                        <td><button type="button" onclick="modificarPerfil(\''.$perfil->nombre.'\', \''.$perfil->descripcion.'\', '.$perfil->id.')" class="btn btn-primary">Modificar</button></td>
                                    </tr>';
                            }
                        ?>
					</tbody>
				</table>
				<!-- Termina tabla -->
				<!-- <div class="botones"> -->
					<button type="button" class="btn btn-primary col-md-2" onclick="añadirPerfil()">Añadir</button>
				<!-- </div> -->
        </div>
       </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>

<script>
   /*  $('#profileTable').DataTable(); -----PARA LA TABLA*/ 
    function añadirPerfil(){
        $("#modal-añadir").modal('show');
        $('input[name="nombre"]').val('');
        $('input[name="descripcion"]').val('');
    }

    $('#nuevoPerfil').submit(function() {
        if($('input[name="nombre"]').val() !== "" && $('input[name="descripcion"]').val() !== "") {
            $.ajax({
                url: 'Perfiles/agregarPerfil', 
                type: "post",
                data: $('#nuevoPerfil').serialize(),
                success: function( response ) {
                    response = JSON.parse(response);
                    let estadoBoton= '<button type="button" onclick="estadoPerfil(\''+response.id+'\',\''+response.estatus+'\')" class="btn btn-success">Activar</button>';
                    if(response.estatus==1){
                        estadoBoton='<button type="button" onclick="estadoPerfil(\''+response.id+'\',\''+response.estatus+'\')" class="btn btn-danger">Desactivar</button>';
                    }
                    $('#tablaPerfiles tbody').prepend(
                        '<tr>'+
                            '<td>'+response.nombre+'</td>'+
                            '<td>'+response.descripcion+'</td>'+
                            '<td>'+estadoBoton+'</td>'+
                            '<td><button type="button" onclick="modificarPerfil(\''+response.nombre+'\', \''+response.descripcion+'\', '+response.id+')" class="btn btn-primary">Modificar</button></td>'+
                        '</tr>'
                    );
                    $("#modal-añadir").modal('hide');
                    alert("Se ha guardado el perfil");
                }
            });
        }
        else {
            alert('Favor de llenar todos los campos.');
        }
        return false;
    });
    
    var perfilModificando = 0;
    function modificarPerfil(nombre, descripcion, id) {
        $('input[name="nombreModificar"]').val( nombre );
        $('input[name="descripcionModificar"]').val( descripcion );
        perfilModificando = id;
        $("#modal-modificar").modal('show');
    }

    $('#modificarPerfil').submit(function() {
        if($('input[name="nombreModificar"]').val() !== "" && $('input[name="descripcionModificar"]').val() !== "") {
            $.ajax({
                url: 'Perfiles/modificarPerfil', 
                type: "post",
                data: $('#modificarPerfil').serialize()+"&idPerfil="+perfilModificando,
                success: function( response ) {
                    if(response == 1) {
                        alert("Se ha modificado correctamente el perfil.");
                        $("#modal-modificar").modal('hide');
                    }
                    else {
                        alert("Ha ocurrido un error, intentelo más tarde.");
                    }
                }
            });
        }
        else {
            alert('Favor de llenar todos los campos.');
        }
        return false;
    });

    var idEstado = 0;
    var estatusPerfil = 0;    
    function estadoPerfil(id,estatus){
        idEstado = id;
        estatusPerfil = estatus;
        console.log(idEstado);
        console.log(estatusPerfil);
        /* alert("Jajaja no se que hacer help"); */
        $.ajax({
                url: 'Perfiles/modificarEstado', 
                type: "post",
                data: {idEstado:idEstado, estatusPerfil:estatusPerfil},
                success: function( response ) {
                    if(response == 1) {
                        alert("Se ha modificado correctamente el estado.");
                    }
                    else {
                        alert("Ha ocurrido un error, intentelo más tarde.");
                    }
                }
            }); 
    }
</script>
<?php $this->load->view('Global/footer')?>

<script src="<?php echo base_url('assets/js/header.js'); ?>"></script>