<!-- MENU MENU MENU MENU MENU -->
  <?php $this->load->view('Global/header'); ?>
  <?php $this->load->view('Global/menu'); ?>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  
  <div class="content-wrapper">
     <section class="content">
          <div class="container-fluid">
               <div class="row">
                    <blockquote style=" border-left: 5px solid #2f4159;">
                        <h1 class="text-justify">Usuarios</h1>
                        <!--<small id="verDocumentacion"><cite title="Source Title"><strong>Dar clic para ver la información requerida</strong></cite></small>-->
                    </blockquote>
               </div>
               <div class="row">
                    <div class="col-md-4">
                        <select name="estado" id="estado" class="form-control">
                            <option value="3">Seleccione una opción</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
               </div>
               <br><br> 
               <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-users"></i>  Listado de usuarios</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                    	   <div class="table-responsive">
                    		    <table id="tablaUsuarios" class="table table-striped no-margin" style="width:100%">
                    	            <thead>
        						        <tr> 
        						            <th>ID</th>
        						            <th>Usuario</th>
        						            <th>Tipo</th>
                                            <th>Estado</th>
        						            <th>Opciones</th>
        						        </tr>
        						    </thead>
        						    <tbody id="contenidoTabla">
        						           
        						    </tbody>
        						</table>
                                <button type="button" class="btn btn-primary btn-lg" id="agregarUsuario" style="background-color: #264d78;">Agregar usuario</button> 
                    	   </div>
                        </div>
                    </div>
               </div>
            </div>
        </section><!-- /.content -->
    </div>

<!--<div class="block" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 8000;opacity: .8; background-color: black;">-->
    
    
   
<!--</div>-->

<?php $this->load->view('Global/footer')?>


<script>
    $(document).ready(function(){
        //Inicialize
        var x = $("#estado").val();
        obtenerDatos(x);
        //Declaro la tabla
        var tabla = insertarPaginado("tablaUsuarios",10,true);
        $('#estado').change(function(){
            var estado = $(this).val();
            obtenerDatos(estado);
        });
        function obtenerDatos(estatus){
            $.ajax({
                url:"<?php base_url() ?>Usuarios/obtenerUsuarios/"+estatus,
                type:"POST",
                success:function(respuesta){
                    respuesta = JSON.parse(respuesta);
                    var x = "";
                    var varStatus = '';
                    var ac = '';
                    //Borrar Contenido Tabla
                    tabla.clear().draw();
                    $.each(respuesta,function(index, item){
                        if (item['estatus'] == '0') {
                            ac = 'Inactivo';
                            varStatus = "<a href='#' class='cambiarEstatus' data-id="+item['id']+" data-actual="+item['estatus']+" ><span class='fa fa-toggle-off' style='font-size: 2.3em; color: #264d78;'></span></a>";
                        }
                        else if(item['estatus'] == '1'){
                            ac = 'Activo';
                            varStatus = "<a href='#' class='cambiarEstatus' data-id="+item['id']+" data-actual="+item['estatus']+" ><span class='fa fa-toggle-on' style='font-size: 2.3em; color: #264d78;'></span></a>";
                        }
                        //Agregar una nueva fila
                        var  fila = tabla.row.add([
                            item['id'], //Una celda
                            item['nombre_usuario'],
                            item['nombre'],
                            ac,
                            "<a href='#' class='editarPerfil' data-id="+item['id']+" ></a>&nbsp;&nbsp;&nbsp;&nbsp;"+varStatus+'&nbsp;&nbsp;&nbsp;&nbsp'
                        ]).draw(false).node();
                    });
                },
                error:function(jqXHR, textStatus, errorThrown){
                    console.log('error:: '+ errorThrown);
                }
            });
        }
        $('#contenidoTabla').delegate(".cambiarEstatus","click", function(){
            var dodo = $(this); //Acceder al contenido de la etiqueta 'a'
            var actualid = dodo.data('id');
            var actualado = dodo.data('actual');
            var msg = "";
            if (actualado == '1') {
                actualado = 0;
                msg ="<br><br> <strong>Nota:</strong> A dar de baja un usuario, no se podra acceder al sistema";
            }
            else{
                actualado = 1;
            }
            BootstrapDialog.confirm({
                title: 'Advertencia',
                message: 'Se cambiará el estatus del usuario ¿Desea continuar?'+msg,
                type: BootstrapDialog.TYPE_DANGER, 
                btnCancelLabel: 'Cancelar', 
                btnOKLabel: 'Continuar', 
                btnOKClass: 'btn-danger', 
                callback: function(result) {
                    if(result){
                        $.ajax({
                            url:"<?php base_url() ?>Usuarios/cambiarEstatusUsuarios",
                            type:"POST",
                            data:{
                                id: actualid,
                                estatus: actualado
                            },
                            beforeSend: function(){
                                //avisoCargando.open();
                                $('#load').show();
                            },
                            success:function(respuesta){
                                if (respuesta) {
                                    var x = $("#estado").val()
                                    obtenerDatos(x);
                                }
                                else{
                                    BootstrapDialog.show({
                                    title: 'No se actualizó',
                                    message: 'No se modificó el estatus del perfil seleccionado'
                                    });
                                }  
                            },
                            error:function(jqXHR, textStatus, errorThrown){
                                console.log('error:: '+ errorThrown);
                            },
                            complete: function(){
                                //avisoCargando.close();
                                $('#load').hide();
                            }
                        });
                    }
                }
            });
        });
        // NAKUPANDA EXAMPLE BOOTSTRAPDIALOG
        $('#agregarUsuario').click(function()
        {
            BootstrapDialog.show({
                title: "Agregar Usuario",
                size: BootstrapDialog.SIZE_WIDE,
                draggable: true,
                message: function(dialog) {
                    $mensaje = $("<div></di>");
                    $mensaje.load(dialog.getData("pageToLoad"));
                    return $mensaje;
                },
                data: 
                {
                    "pageToLoad": "<?php base_url() ?>Usuarios/formularioUsuarios"
                },
                buttons:
                [
                    {
                        label: "Guardar",
                        cssClass: "btn-primary",
                        action:function(dialog) {
                            $.ajax({
                                url : "<?php base_url() ?>Usuarios/agregarUsuarios",
                                type: "POST",
                                data: $("#formulario").serialize(),
                                success:function(resp) {  
                                    console.log(resp);                          
                                    switch(parseInt(resp)) {
                                        case 1:
                                            obtenerDatos($("#estado").val());
                                            dialog.close();
                                            break;
                                        case 0:
                                            BootstrapDialog.show({
                                                title: 'Error',
                                                message: 'Oops ah surgido un error. Recargar la página',
                                                type: BootstrapDialog.TYPE_DANGER
                                            });
                                            break;
                                        case 2:
                                            BootstrapDialog.show({
                                                title:"Error",
                                                message: 'El Usuario ingresado no es válida.',
                                                type: BootstrapDialog.TYPE_DANGER,
                                                size: BootstrapDialog.SIZE_SMALL
                                            });
                                            break; 
                                        default:
                                            $('#msg-error').show();
                                            $('.list-errors').html(resp);
                                            break;
                                    }                               
                                },
                                error(jqXHR, textStatus, errorThrown) {
                                    console.error("Error::" + errorThrown);
                                }
                            });
                        }
                    },
                    {
                        label: "Cancelar",
                        cssClass: "btn-danger",
                        action:function(dialog) {
                            dialog.close();
                        }           
                    }                     
                ]                    
            });
        });
    });
</script>
