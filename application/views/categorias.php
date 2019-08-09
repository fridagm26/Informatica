<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<!-- MODAL -->
<div class="modal" id="modal-añadir" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newcat" action="<?php echo base_url() ?>index.php/Categorias/agregarCategoria" method="POST">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control form-control-lg" name="descripcion" placeholder="Ingrese Descripción">
                        <small class="form-text text-muted">Escriba una breve descripcion de la categoria.</small>
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
                <h5 class="modal-title">Modificar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modificarCategoria" action="<?php echo base_url() ?>index.php/Categorias/modificarCategoria" method="POST">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="descripcionModificar" placeholder="Ingrese Descripción">
                        <small class="form-text text-muted">Escriba una breve descripcion de la categoria.</small>
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
       <section class="content">
			 	<h1>Categorias</h1>
       	<div class="row">
				 <!-- Empieza tabla -->
				 <table class="table ta" id="tablaCategorias">
					<thead>
						<tr>
                            <th scope="col">Descripción</th>
							<th scope="col">Estado</th>
                            <th scope="col">Acción</th>
						</tr>
					</thead>
					<tbody>
                    <div id="recargar">
                        <?php 
                            foreach($categorias as $categoria){
                                $estado='<button type="button" onclick="estadoCategoria(\''.$categoria->id.'\',\''.$categoria->estado.'\')" class="btn btn-success">Activar</button>';
                                if($categoria->estado==1){
                                    $estado='<button type="button" onclick="estadoCategoria(\''.$categoria->id.'\',\''.$categoria->estado.'\')" class="btn btn-danger">Desactivar</button>';
                                }
                                echo 
                                    '<tr>
                                        <td>'.$categoria->descripcion.'</td>
                                        <td>'.$estado.'</td>
                                        <td><button type="button" onclick="modificarCategoria(\''.$categoria->descripcion.'\', '.$categoria->id.')" class="btn btn-primary">Modificar</button></td>
                                    </tr>';
                            }
                        ?>
                    </div>    
					</tbody>
				</table>
				<!-- Termina tabla -->
				<!-- <div class="botones"> -->
					<button type="button" class="btn btn-primary col-md-2" onclick="añadirCategoria()">Añadir</button>
				<!-- </div> -->
        </div>
       </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>

<script>
   /*  $('#profileTable').DataTable(); -----PARA LA TABLA*/ 
    function añadirCategoria(){
        $("#modal-añadir").modal('show');
        $('input[name="descripcion"]').val('');
    }

    $('#newcat').submit(function() {
        if($('input[name="descripcion"]').val() !== "") {
            $.ajax({
                url: 'Categorias/agregarCategoria', 
                type: "post",
                data: $('#newcat').serialize(),
                success: function( response ) {
                    response = JSON.parse(response);
                    let estadoBoton= '<button type="button" onclick="estadoCategoria(\''+response.id+'\',\''+response.estado+'\')" class="btn btn-success">Activar</button>';
                    if(response.estado==1){
                        estadoBoton='<button type="button" onclick="estadoCategoria(\''+response.id+'\',\''+response.estado+'\')" class="btn btn-danger">Desactivar</button>';
                    }
                    $('#tablaCategorias tbody').prepend(
                        '<tr>'+
                            '<td>'+response.descripcion+'</td>'+
                            '<td>'+estadoBoton+'</td>'+
                            '<td><button type="button" onclick="modificarCategoria(\''+response.descripcion+'\', '+response.id+')" class="btn btn-primary">Modificar</button></td>'+
                        '</tr>'
                    );
                    $("#modal-añadir").modal('hide');
                    alert("Se ha guardado la categoria");
                }
            });
        }
        else {
            alert('Favor de llenar todos los campos.');
        }
        return false;
    });
    
    var categoriaModificando = 0;
    function modificarCategoria(descripcion, id) {
        $('input[name="descripcionModificar"]').val( descripcion );
        categoriaModificando = id;
        $("#modal-modificar").modal('show');
    }

    $('#modificarCategoria').submit(function() {
        if($('input[name="descripcionModificar"]').val() !== "") {
            $.ajax({
                url: 'Categorias/modificarCategoria', 
                type: "post",
                data: $('#modificarCategoria').serialize()+"&idCategoria="+categoriaModificando,
                success: function( response ) {
                    if(response == 1) {
                        alert("Se ha modificado correctamente la categoria.");
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
    var estatusCategoria = 0;    
    function estadoCategoria(id,estado){
        idEstado = id;
        estatusCategoria = estado;
        console.log(idEstado);
        console.log(estatusCategoria);

        $.ajax({
                url: 'Categorias/modificarEstado', 
                type: "post",
                data: {idEstado:idEstado, estatusCategoria:estatusCategoria},
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