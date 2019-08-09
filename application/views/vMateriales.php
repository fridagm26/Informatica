<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
  <?php $this->load->view('Global/menu'); ?>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

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
                        <input type="search" class="form-control" placeholder="Buscar">
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
                                <form id="form-agregar">
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
                    <table class="table table-striped no-margin" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Existencia</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="tMateriales">
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
        /* $('input[name="descripcion"]').val('');
        $('input[name="cantidadExistencia"]').val('');
        $('select[name="slctCategoria"]').val(''); */
    }

    $('#form-agregar').submit(function (e){
        const postData = {
            descripcion: $('#descripcion').val(),
            cantidadExistencia: $('#cantidadExistencia').val(),
            categoria: $('#slctCategoria').val()
        };
        console.log(postData);
        $.post('cMateriales/altaMateriales', postData, function (response){
            console.log(response);
        });

        e.preventDefault();
    });






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
    

</script> 
<?php $this->load->view('Global/footer')?>

<script src="<?php echo base_url('assets/js/header.js'); ?>"></script>