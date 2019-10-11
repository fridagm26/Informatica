<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
  <?php $this->load->view('Global/menu'); ?>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  
<div class="content-wrapper">
     <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <blockquote style=" border-left: 5px solid #2f4159;">
                        <h1 class="text-justify">Laboratorios</h1>
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
                            <h3 class="box-title"><i class="fa fa-inbox"></i>Listado de laboratorios</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                        	<div>
                        		<table id="tablaLaboratorios" class="table no-margin" style="width:100%">
                                    <thead>
                                        <tr> 
    						                <th>ID</th>
    						                <th>Nombre</th>
                                            <th>Ubicacion</th>
                                            <th>Capacidad</th>
                                            <th>Estado</th>
    						                <th>Opciones</th>
    						            </tr>
    						        </thead>
    						        <tbody id="contenidoTabla">
        						           
    						        </tbody>
        					    </table>
                                <button type="button" class="btn btn-primary btn-lg" id="agregarLaboratorio" style="background-color: #264d78;">Agregar Laboratorio</button> 
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
        var tabla = insertarPaginado("tablaLaboratorios",15,true);
        
        $('#estado').change(function(){
            var estado = $(this).val();
            obtenerDatos(estado);
        });

        function obtenerDatos(estado) {
            $.ajax({
                url:"<?php base_url() ?>Laboratorios/obtenerLaboratoriosPorEstado/" + estado,
                type:"POST",            
                success:function(respuesta){
                    respuesta = JSON.parse(respuesta);
                    var x = "";
                    var varStatus = '';
                    var ac = '';
                    //Borrar Contenido Tabla
                    tabla.clear().draw();
                    $.each(respuesta,function(index, item){
                        if (item['estado'] == '0') {
                            ac = 'Inactivo';
                            varStatus = "<a href='#' class='cambiarEstatus' data-id="+item['id']+" data-actual="+item['estado']+" ><span class='fa fa-toggle-off' style='font-size: 2.3em; color: #264d78;'></span></a>";
                        }
                        else if(item['estado'] == '1'){
                            ac = 'Activo';
                            varStatus = "<a href='#' class='cambiarEstatus' data-id="+item['id']+" data-actual="+item['estado']+" ><span class='fa fa-toggle-on' style='font-size: 2.3em; color: #264d78;'></span></a>";
                        }
                        //Agregar una nueva fila
                        var  fila = tabla.row.add([
                            item['id'], //Una celda
                            item['descripcion'],
                            item['ubicacion'],
                            item['capacidad'],
                            ac,
                            "<a href='#' class='editarLaboratorio' data-id="+item['id']+" ><span class='fa fa-edit' style='font-size: 2.3em;color: #264d78;'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;"+varStatus+'&nbsp;&nbsp;&nbsp;&nbsp;'
                        ]).draw(false).node();
                        $('td:eq(0)',fila).attr('id', item['id']);
                    });
                },
                error:function(jqXHR, textStatus, errorThrown){
                    console.log('error:: '+ errorThrown);
                }
            });
        }

        $('#contenidoTabla').delegate(".editarLaboratorio","click", function() {
            var dodo = $(this); //Acceder al contenido de la etiqueta 'a'
            var actualid = dodo.data('id');
            BootstrapDialog.show({
                title: 'Editar laboratorio', // Aquí se pone el título
                size: BootstrapDialog.SIZE_WIDE, //Indica el tamaño
                message: function(dialog) { 
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad); //Cargamos la vista
                    return $message;
                },
                data: {
                    'pageToLoad':'<?php base_url() ?>Laboratorios/formulario/'+actualid
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
                      	    var ubicacionViejo = $("#txtubicacion").data('info');
                            var capacidadViejo = $("#txtcapacidad").data('info');  
                      	    var nombre = $("#txtnombre").val();
                      	    var ubicacion = $("#txtubicacion").val();
                            var capacidad = $("#txtcapacidad").val();  
                      	    var id = $("#txtnombre").data('id');
                      	    //Terminamos de obtener la informacion desde php
                          	if(nombre != nombreViejo || ubicacion != ubicacionViejo || capacidad != capacidadViejo){//Comparamos si se hizo un cambio con la informacion que ya se tenia
                          		BootstrapDialog.confirm({
        				            title: 'Información',
        				            message: 'El siguiente laboratorio va ser modificado ¿Desea continuar?',
        				            //type: BootstrapDialog.TYPE_INFO, 
        				            btnCancelLabel: 'Cancelar', 
        				            btnOKLabel: 'Continuar', 
        				            btnOKClass: 'btn-info', 
        				            callback: function(result) {
        				            	if(result){
        				            		var formData = new FormData($('#formulario')[0]);
        		                    		formData.append('id', id);
        				                    $.ajax({
        				                        url:"<?php base_url() ?>Laboratorios/editarLaboratorio/",
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
        				            message: 'Para editar un laboratorio, debe cambiar al menos un campo',
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
                msg ="<br><br> <strong>Nota:</strong> A dar de baja un laboratorio, es posible que no aparezca paraser seleccionado";
            }
            else{
                actualado = 1;
            }
            BootstrapDialog.confirm({
                title: 'Advertencia',
                message: 'Se cambiará el estatus del laboratorio ¿Desea continuar?'+msg,
                type: BootstrapDialog.TYPE_DANGER, 
                btnCancelLabel: 'Cancelar', 
                btnOKLabel: 'Continuar', 
                btnOKClass: 'btn-danger', 
                callback: function(result) {
                    if(result){
                        $.ajax({
                            url:"<?php base_url() ?>Laboratorios/cambiarEstatusLaboratorio/",
                            type:"POST",
                            data: {
                                id: actualid,
                                estado: actualado
                            },                  
                            success:function(respuesta){
                                if (respuesta) {
                                    var x = $("#estado").val()
                                    obtenerDatos(x);
                                }
                                else{
                                    BootstrapDialog.show({
                                        title: 'No se actualizó',
                                        message: 'No se modificó el estatus del laboratorio seleccionado'
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
        
       
        $('#agregarLaboratorio').click(function(){
            BootstrapDialog.show({
                title: 'Nuevo Laboratorio', 
                size: BootstrapDialog.SIZE_WIDE, 
                message: function(dialog) { 
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': '<?php base_url() ?>Laboratorios/formulario'
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
                                url:"<?php base_url() ?>Laboratorios/agregarLaboratorio",
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
