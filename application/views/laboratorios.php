<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<!-- MODAL -->
<div class="modal" id="modal-añadir" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Laboratorio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newlab" action="<?php echo base_url() ?>index.php/Laboratorios/agregarLaboratorio" method="POST">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="descripcion" placeholder="Ingrese Descripción">
                        <small class="form-text text-muted">Escriba una breve descripcion del laboratorio.</small>
                    </div>
                    <div class="form-group">
                        <label>Ubicacion</label>
                        <input type="text" class="form-control" name="ubicacion" placeholder="Ingrese Ubicacion">
                    </div>
                    <div class="form-group">
                        <label>Capacidad</label>
                        <input type="text" class="form-control" name="capacidad" placeholder="Ingrese Capacidad">
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" name="idUsuario" placeholder="Usuario" value="5">
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
                <h5 class="modal-title">Modificar Laboratorio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modificarLaboratorio" action="<?php echo base_url() ?>index.php/Laboratorios/modificarLaboratorio" method="POST">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="descripcionModificar" placeholder="Ingrese Descripción">
                        <small class="form-text text-muted">Escriba una breve descripcion del laboratorio.</small>
                    </div>
                    <div class="form-group">
                        <label>Ubicacion</label>
                        <input type="text" class="form-control" name="ubicacionModificar" placeholder="Ingrese Ubicacion">
                    </div>
                    <div class="form-group">
                        <label>Capacidad</label>
                        <input type="text" class="form-control" name="capacidadModificar" placeholder="Ingrese Capacidad">
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" name="idUsuarioModificar" placeholder="Usuario" value="5">
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
  <section class="content py-2 text-xs-center">
        <div class="container-fluid">
            <div class="row">
                <blockquote style=" border-left: 5px solid #264d78;">
                    <h1 class="text-justify">Laboratorios</h1>
                </blockquote>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <input type="search" class="form-control" placeholder="Buscar">
                    </div>
                </div>
            </div>
       	<div class="row">
           <div class="box box-primary">
                    <div class="clear">
				 <!-- Empieza tabla -->
				 <table class="table table-striped no-margin" style="width:100%" id="tablaLaboratorios">
					<thead class="thead-dark">
						<tr>
                            <th scope="col">Descripción</th>
                            <th scope="col">Ubicacion</th>
                            <th scope="col">Capacidad</th>
							<th scope="col">Estado</th>
                            <th scope="col">Acción</th>
						</tr>
					</thead>
					<tbody>
                        <?php 
                            foreach($laboratorios as $laboratorio){
                                $estado='<button type="button" onclick="estadoLaboratorio(\''.$laboratorio->id.'\',\''.$laboratorio->estado.'\')" class="btn btn-success">Activar</button>';
                                if($laboratorio->estado==1){
                                    $estado='<button type="button" onclick="estadoLaboratorio(\''.$laboratorio->id.'\',\''.$laboratorio->estado.'\')" class="btn btn-danger">Desactivar</button>';
                                }
                                echo 
                                    '<tr>
                                        <td>'.$laboratorio->ubicacion.'</td>
                                        <td>'.$laboratorio->descripcion.'</td>
                                        <td>'.$laboratorio->capacidad.'</td>
                                        <td>'.$estado.'</td>
                                        <td><button type="button" onclick="modificarLaboratorio(\''.$laboratorio->ubicacion.'\', \''.$laboratorio->descripcion.'\', \''.$laboratorio->capacidad.'\', '.$laboratorio->id.')" class="btn btn-primary">Modificar</button></td>
                                    </tr>';
                            }
                        ?>
					</tbody>
				</table>
				<!-- Termina tabla -->
				<!-- <div class="botones"> -->
					<button style="margin-top: 20px" type="button" class="btn btn-primary col-md-2" onclick="añadirLaboratorio()">Añadir</button>
				<!-- </div> -->
        </div>
       </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>

<script>
   /*  $('#profileTable').DataTable(); -----PARA LA TABLA*/ 
    function añadirLaboratorio(){
        $("#modal-añadir").modal('show');
        $('input[name="descripcion"]').val('');
        $('input[name="ubicacion"]').val('');
        $('input[name="capacidad"]').val('');
    }

    $('#newlab').submit(function() {
        if($('input[name="descripcion"]').val() !== "" && $('input[name="ubicacion"]').val() !== "" && $('input[name="capacidad"]').val() !== "") {
            $.ajax({
                url: 'Laboratorios/agregarLaboratorio', 
                type: "post",
                data: $('#newlab').serialize(),
                success: function( response ) {
                    response = JSON.parse(response);
                    let estadoBoton= '<button type="button" onclick="estadoLaboratorio(\''+response.id+'\',\''+response.estado+'\')" class="btn btn-success">Activar</button>';
                    if(response.estado==1){
                        estadoBoton='<button type="button" onclick="estadoLaboratorio(\''+response.id+'\',\''+response.estado+'\')" class="btn btn-danger">Desactivar</button>';
                    }
                    $('#tablaLaboratorios tbody').prepend(
                        '<tr>'+
                            '<td>'+response.ubicacion+'</td>'+
                            '<td>'+response.descripcion+'</td>'+
                            '<td>'+response.capacidad+'</td>'+
                            '<td>'+estadoBoton+'</td>'+
                            '<td><button type="button" onclick="modificarLaboratorio(\''+response.ubicacion+'\', \''+response.descripcion+'\', \''+response.capacidad+'\', '+response.id+')" class="btn btn-primary">Modificar</button></td>'+
                        '</tr>'
                    );
                    $("#modal-añadir").modal('hide');
                    alert("Se ha guardado el laboratorio");
                }
            });
        }
        else {
            alert('Favor de llenar todos los campos.');
        }
        return false;
    });
    
    var laboratorioModificando = 0;
    function modificarLaboratorio(ubicacion, descripcion, capacidad, id) {
        $('input[name="ubicacionModificar"]').val( ubicacion );
        $('input[name="descripcionModificar"]').val( descripcion );
        $('input[name="capacidadModificar"]').val( capacidad );
        laboratorioModificando = id;
        $("#modal-modificar").modal('show');
    }

    $('#modificarLaboratorio').submit(function() {
        if($('input[name="ubicacionModificar"]').val() !== "" && $('input[name="descripcionModificar"]').val() !== "" && $('input[name="capacidadModificar"]').val() !== "") {
            $.ajax({
                url: 'Laboratorios/modificarLaboratorio', 
                type: "post",
                data: $('#modificarLaboratorio').serialize()+"&idLaboratorio="+laboratorioModificando,
                success: function( response ) {
                    if(response == 1) {
                        alert("Se ha modificado correctamente el laboratorio.");
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
    var estatusLaboratorio = 0;    
    function estadoLaboratorio(id,estado){
        idEstado = id;
        estatusLaboratorio = estado;
        console.log(idEstado);
        console.log(estatusLaboratorio);

        $.ajax({
                url: 'Laboratorios/modificarEstado', 
                type: "post",
                data: {idEstado:idEstado, estatusLaboratorio:estatusLaboratorio},
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