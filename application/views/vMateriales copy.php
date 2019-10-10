<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
  <?php $this->load->view('Global/menu'); ?>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
       <section class="content py-2 text-xs-center">
        <div class="container-fluid">
            <div class="row">
                <blockquote style=" border-left: 5px solid #264d78;">
                    <h1 class="text-justify">Materiales</h1>
                </blockquote>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <input type="search" class="form-control" placeholder="Buscar" id="txtBuscar" name="txtBuscar">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="box box-primary">
                    <div class="clear">
                        <!-- Modal Agregar-->
                        <div class="modal fade" id="modal-agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Añadir Material</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-agregar" action="<?php echo base_url() ?>index.php/cMateriales/agregarMaterial" method="POST">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Descripcion</label>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion" aria-describedby="emailHelp" placeholder="Descripcion">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Existencia</label>
                                        <input type="text" class="form-control" name="cantidadExistencia" id="cantidadExistencia" aria-describedby="emailHelp" placeholder="Existencia">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Categoria</label>
                                        <select id="slctCategoria" class="form-control" name="slctCategoria">
                                        <option value="" disabled selected>Selecciona una categoria</option>
                                            <?php
                                                //Aqui se muestran todas las categorias disponibles en la base de datos 
                                                foreach($categorias->result() as $categoria){
                                                    echo "<option value=".$categoria->id.">".$categoria->descripcion."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div> <!-- /.form-group -->
                                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary" value="save">Añadir</button>
                                    </div>
                                    </div>
                                </form>
                        </div>
                        </div>
                    <table class="table table-striped no-margin" style="width:100%" id="tablaMateriales">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Existencia</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($result as $row){
                                    $estado='<button type="button" onclick="estadoMaterial(\''.$row->id.'\',\''.$row->estado.'\')" class="btn btn-success">Activar</button>'; 
                                    //$estado='<input id="checkboxOff" type="checkbox" data-toggle="toggle" onclick="estadoMaterial(\''.$row->id.'\',\''.$row->estado.'\')">';
                                    if($row->estado==1){
                                    // $estado='<input id="checkboxOn" type="checkbox" checked data-toggle="toggle" onclick="estadoMaterial(\''.$row->id.'\',\''.$row->estado.'\')">';
                                        $estado='<button type="button" onclick="estadoMaterial(\''.$row->id.'\',\''.$row->estado.'\')" class="btn btn-danger">Desactivar</button>'; 
                                    }

                                    echo 
                                        '<tr>
                                            <td>'.$row->id.'</td>
                                            <td>'.$row->descripcion.'</td>
                                            <td>'.$row->cantidadExistencia.'</td>
                                            <td>'.$estado.'</td>
                                            <td><input type="button" id="'.$row->id.'" name="modificar" value="Modificar" class="btn btn-primary edit_data"></td>                                        
                                        </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                            <button type="button" class="btn btn-primary" onclick="agregarMaterial()">Añadir</button>
                    </div>
                </div>
            </div>
        </div>
       </section>

  </div>
  <div class="control-sidebar-bg"></div>
</div>

<script>

    function agregarMaterial(){
        $("#modal-agregar").modal('show');
        $('input[name="descripcion"]').val('');
        $('input[name="cantidadExistencia"]').val('');
        $('select[name="slctCategoria"]').val(''); 
    }

    $('#form-agregar').submit(function() {
        if($('input[name="descripcion"]').val() !== "" && $('input[name="cantidadExistencia"]').val() !== "") {
            $.ajax({
                url: 'cMateriales/agregarMaterial', 
                type: "post",
                data: $('#form-agregar').serialize(),
                success: function( response ) {
                    response = JSON.parse(response);
                    let estadoBoton= '<button type="button" onclick="estadoMaterial(\''+response.id+'\',\''+response.estado+'\')" class="btn btn-success">Activar</button>';
                    if(response.estado==1){
                        estadoBoton='<button type="button" onclick="estadoMaterial(\''+response.id+'\',\''+response.estado+'\')" class="btn btn-danger">Desactivar</button>';
                    }
                    $('#tablaMateriales tbody').prepend(
                        '<tr>'+
                            '<td>'+response.id+'</td>'+
                            '<td>'+response.descripcion+'</td>'+
                            '<td>'+response.cantidadExistencia+'</td>'+
                            '<td>'+estadoBoton+'</td>'+
                            '<td><button type="button" onclick="modificarPerfil(\''+response.nombre+'\', \''+response.descripcion+'\', '+response.id+')" class="btn btn-primary">Modificar</button></td>'+
                        '</tr>'
                    );
                    $("#modal-agregar").modal('hide');
                    alert("Se ha guardado el Material");
                }
            });
        }
        else {
            alert('Favor de llenar todos los campos.');
        }
        return false;
    });

    $('#tablaMateriales').DataTable();

    var idEstado = 0;
    var estatusMaterial = 0;    
    function estadoMaterial(id,estatus){
        idEstado = id;
        estatusMaterial = estatus;
        console.log(idEstado);
        console.log(estatusMaterial);
        $.ajax({
                url: 'cMateriales/modificarEstado', 
                type: "post",
                data: {idEstado:idEstado, estatusMaterial:estatusMaterial},
                success: function( response ) {

                }
            }); 
    }

    $(document).on('click', '.edit_data', function(){
        var id_material = $(this).attr("id");
        console.log(id_material);
        $.ajax({
            url: 'cMateriales/modificarMaterial',
            method: "POST",
            data:{id_material:id_material},
            dataType: "json",
            success:function(data){
                $('#descripcion').val(data.descripcion);
                $('#cantidadExistencia').val(data.cantidadExistencia);
                $('#slctCategoria').val(data.slctCategoria);
                $('#id_materiall').val(data.id_materiall);
                $('#insert').val("Actualizar");
                $('#modal-modificar').modal('show');
            }
        });
    });

    function mostrarDatos(valor) {
        var base_url = '<?php echo base_url(); ?>';
        $.ajax({
            url: base_url+"cMateriales/buscar",
            type: "POST",
            data:{buscar:valor},
            success:function(respuesta){
                alert(respuesta);
            }
        });
    }


    

</script> 
<?php $this->load->view('Global/footer')?>

<script src="<?php echo base_url('assets/js/header.js'); ?>"></script>