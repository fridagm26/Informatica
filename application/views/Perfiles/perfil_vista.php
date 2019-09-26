<!-- MENU MENU MENU MENU MENU -->
  <?php $this->load->view('Global/header'); ?>
  <?php $this->load->view('Global/menu'); ?>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  
  <div class="content-wrapper">
     <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <blockquote style=" border-left: 5px solid #2f4159;">
                        <h1 class="text-justify">Perfiles</h1>
                        <!--<small id="verDocumentacion"><cite title="Source Title"><strong>Dar clic para ver la información requerida</strong></cite></small>-->
                    </blockquote>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <select name="estado" id="estado" class="form-control">
                            <option value="-1">Todos</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <br><br> 
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-inbox"></i>  Listado de perfiles</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                        	<div class="table-responsive">
                        		<table id="tablaPerfiles" class="table no-margin" style="width:100%">
                                    <thead>
                                        <tr> 
    						                <th>ID</th>
    						                <th>Nombre</th>
    						                <th>Descripción</th>
                                            <th>Estado</th>
    						                <th>Opciones</th>
    						            </tr>
    						        </thead>
    						        <tbody id="contenidoTabla">
        						           
    						        </tbody>
        					    </table>
                                <button type="button" class="btn btn-primary btn-lg" id="agregarPerfil" style="background-color: #264d78;">Agregar Perfil de usuario</button> 
                        	</div>
                        </div>
                    </div>
               </div>
          </div>
     </section><!-- /.content -->
</div>

<?php $this->load->view('Global/footer')?>
<script>
    $(document).ready(function(){

        var avisoCargando = new BootstrapDialog({
            title: 'Cargando',
            closable: false,
            message: 'Porfavor espere, cargando la informacion'
        });

        //Inicialize
        var x = $("#estado").val()
        obtenerDatos(x);

        //Declaro la tabla
        var tabla = insertarPaginado("tablaPerfiles",15,true);
        
        $('#estado').change(function(){
            var estado = $(this).val();
            obtenerDatos(estado);
        });

        function obtenerDatos(estado) {
            $.ajax({
                url:'<?php base_url() ?>Perfiles/obtenerPerfilesPorEstado/' + estado,
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
                            item['nombre'],
                            item['descripcion'],
                            ac,
                            "<a href='#' class='editarPerfil' data-id="+item['id']+" ><span class='fa fa-edit' style='font-size: 2.3em;color: #264d78;'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;"+varStatus+'&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" data-id="'+item['id']+'" class="btn btn-primary btnModulos" style="background-color: #264d78;">Modulos<i class="entypo-layout"></i> </button>'
                        ]).draw(false).node();
                        $('td:eq(0)',fila).attr('id', item['id']);
                    });
                },
                error:function(jqXHR, textStatus, errorThrown){
                    console.log('error:: '+ errorThrown);
                }
            });
        }

        $('#contenidoTabla').delegate(".btnModulos","click", function() {
            var dodo = $(this); 
            var actualid = dodo.data('id');
            BootstrapDialog.show({
                title: 'Listado de modulos', 
                size: BootstrapDialog.SIZE_WIDE, 
                message: function(dialog) { 
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad); 
                    return $message;
                },
                data: {
                    'pageToLoad': '<?php base_url() ?>Perfiles/agregarModulos_modal/'+actualid
                },
                buttons: [
                    { 
                        label: 'Aceptar',
                        cssClass: 'btn-primary',
                        action: function(dialogItself) { 
                            dialogItself.close();
                        }
                    }
                ] 
            });
        });

        $('#contenidoTabla').delegate(".editarPerfil","click", function() {
            var dodo = $(this); //Acceder al contenido de la etiqueta 'a'
            var actualid = dodo.data('id');
            BootstrapDialog.show({
                title: 'Editar perfil', // Aquí se pone el título
                size: BootstrapDialog.SIZE_WIDE, //Indica el tamaño
                message: function(dialog) { 
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad); //Cargamos la vista
                    return $message;
                },
                data: {
                    'pageToLoad':'<?php base_url() ?>Perfiles/formularioPerfiles/'+actualid
                },
                buttons: [
                    { //agrega los botones del modal
                        label: 'Cancelar',
                        cssClass: 'btn-danger',
                        action: function(dialogItself) { // Funciones del boton del modal. El atributo es obligatorio para cerrarlo
                            dialogItself.close();
                        }
                    },
                    { //agrega los botones del modal
                        label: 'Guardar',
                        cssClass: 'btn-primary',
                        action: function(dialogItself) { // Funciones del boton del modal. El atributo es obligatorio para cerrarlo
                      	    //Obtendremos la informacion desde php que contiene el formulario
                      	    var nombreViejo = $("#txtnombre").data('info');
                      	    var descripcionViejo = $("#txtdescripcion").data('info');
                      	    var nombre = $("#txtnombre").val();
                      	    var descripcion = $("#txtdescripcion").val();
                      	    var id = $("#txtnombre").data('id');
                      	    //Terminamos de obtener la informacion desde php
                          	if(nombre != nombreViejo || descripcion != descripcionViejo){//Comparamos si se hizo un cambio con la informacion que ya se tenia
                          		BootstrapDialog.confirm({
        				            title: 'Información',
        				            message: 'El siguiente perfil va ser modificado ¿Desea continuar?',
        				            //type: BootstrapDialog.TYPE_INFO, 
        				            btnCancelLabel: 'Cancelar', 
        				            btnOKLabel: 'Continuar', 
        				            btnOKClass: 'btn-info', 
        				            callback: function(result) {
        				            	if(result){
        				            		var formData = new FormData($('#formulario')[0]);
        		                    		formData.append('id', id);
        				                    $.ajax({
        				                        url:"<?php base_url() ?>Perfiles/editarPerfil",
        				                        type:"POST",
        				                        data:formData,
        				                        cache:false,
        				                        contentType:false,
        				                        processData:false,				                        
        				                        success:function(respuesta){
        				                            switch(parseInt(respuesta)){
        				                                case 1: 
        			                                        var x = $("#estado").val();
        				                                    obtenerDatos(x);
        				                                    dialogItself.close();
        				                                    break;
        				                                case 0:
        				                                    BootstrapDialog.alert({
                                                                title: 'Error',
        				                                        message: 'Ups ah surgido un error. Recargar la pagina'
        				                                    });
        				                                    break;
        				                                case 2: 
                                                            BootstrapDialog.alert({
                                                                title: 'Error',
                                                                message: 'El nombre '+$('#txtnombre').val()+' ya existe. Por favor, ingrese uno diferente'
                                                            });
                                                            $('#txtnombre').val('');
        				                                    break;
            				                            default :
            				                                $('#msg-error').show();
            				                                $('.list-errors').html(respuesta);
            				                                break;
        				                            }
        				                          
        				                        },
                                                error:function(jqXHR, textStatus, errorThrown){
        				                            console.log('error:: '+ errorThrown);
        				                        },				                        
        				                    });
        				            	} // if
        				            }
        				        });
                          	}//Si no se hizo ningun cambio entonces le mostramos una alerta
                          	else {
                          		BootstrapDialog.alert({
        				            title: 'Modificar al menos un campo',
        				            message: 'Para editar un perfil, debe cambiar al menos un campo',
        				            type: BootstrapDialog.TYPE_DANGER				      
        				        });                  		                  	
                          	}
                        },
                }]//buttons
            });
        });
       
        $('#contenidoTabla').delegate(".cambiarEstatus","click", function(){
            var dodo = $(this); //Acceder al contenido de la etiqueta 'a'
            var actualid = dodo.data('id');
            var actualado = dodo.data('actual');
            var msg = "";
            if (actualado == '1') {
                actualado = 0;
                msg ="<br><br> <strong>Nota:</strong> A dar de baja un perfil, todos los usuarios ligados a este perfil no podran acceder";
            }
            else{
                actualado = 1;
            }
            BootstrapDialog.confirm({
                title: 'Advertencia',
                message: 'Se cambiará el estatus del perfil ¿Desea continuar?'+msg,
                type: BootstrapDialog.TYPE_DANGER, 
                btnCancelLabel: 'Cancelar', 
                btnOKLabel: 'Continuar', 
                btnOKClass: 'btn-danger', 
                callback: function(result) {
                    if(result){
                        $.ajax({
                            url:"<?php base_url() ?>Perfiles/cambiarEstatusPerfil/",
                            type:"POST",
                            data: {
                                id: actualid,
                                estatus: actualado
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
                            }                    
                        });
                    }
                }
            });
        });
        
       
        $('#agregarPerfil').click(function(){
            BootstrapDialog.show({
                title: 'Nuevo perfil', 
                size: BootstrapDialog.SIZE_WIDE, 
                message: function(dialog) { 
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': '<?php base_url() ?>Perfiles/formularioPerfiles'
                },
                buttons: [
                    { 
                        label: 'Cancelar',
                        cssClass: 'btn-danger',
                        action: function(dialogItself) { 
                            dialogItself.close();
                        }
                    },
                    { 
                        label: 'Guardar',
                        cssClass: 'btn-primary',
                        action: function(dialogItself) { 
                            var formData = new FormData($('#formulario')[0]);                    
                            $.ajax({
                                url:"<?php base_url() ?>Perfiles/agregarPerfil",
                                type:"POST",
                                data:formData,
                                cache:false,
                                contentType:false,
                                processData:false,                        
                                success:function(respuesta){
                                    switch(parseInt(respuesta)){
                                        case 1: 
                                            var x = $("#estado").val();
                                            obtenerDatos(x);
                                            dialogItself.close();
                                            break;
                                        case 0:
                                            BootstrapDialog.show({
                                                title: 'Error',
                                                message: 'ups ah surgido un error. Recargar la pagina'
                                            });
                                            break;
                                        case 2: 
                                            BootstrapDialog.alert({
                                                title: 'Error',
                                                message: 'El nombre '+$('#txtnombre').val()+' ya existe. Por favor, ingrese uno diferente'
                                            });
                                            $('#txtnombre').val('');
                                            break;
                                        default :
                                            $('#msg-error').show();
                                            $('.list-errors').html(respuesta);
                                            break;
                                    }                          
                                },
                                error:function(jqXHR, textStatus, errorThrown){
                                    console.log('error:: '+ errorThrown);
                                }                      
                            });                
                        },
                    }
                ]
            });
        });
    });
</script>
