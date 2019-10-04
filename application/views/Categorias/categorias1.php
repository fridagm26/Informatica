<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
  <?php $this->load->view('Global/menu'); ?>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  
<div class="content-wrapper">
     <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <blockquote style=" border-left: 5px solid #2f4159;">
                        <h1 class="text-justify">Categorias</h1>
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
                            <h3 class="box-title"><i class="fa fa-inbox"></i>Listado de categorias</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                        	<div >
                        		<table id="tablaCategorias" class="table no-margin" style="width:100%">
                                    <thead>
                                        <tr> 
                                            <th>ID</th>
    						                <th>Descripcion</th>
                                            <th>Estado</th>
    						                <th>Opciones</th>
    						            </tr>
    						        </thead>
    						        <tbody id="contenidoTabla">
        						           
    						        </tbody>
        					    </table>
                                <button type="button" class="btn btn-primary btn-lg" id="agregarCategoria" style="background-color: #264d78;">Agregar Categoria</button> 
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
        var tabla = insertarPaginado("tablaCategorias",15,true);
        
        $('#estado').change(function(){
            var estado = $(this).val();
            obtenerDatos(estado);
        });

        function obtenerDatos(estado) {
            $.ajax({
                url:base_url+"index.php/Categorias/obtenerCategoriasPorEstado/" + estado,
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
                            ac,
                            "<a href='#' class='editarCategoria' data-id="+item['id']+" ><span class='fa fa-edit' style='font-size: 2.3em;color: #264d78;'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;"+varStatus
                        ]).draw(false).node();
                        $('td:eq(0)',fila).attr('id', item['id']);
                    });
                },
                error:function(jqXHR, textStatus, errorThrown){
                    console.log('error:: '+ errorThrown);
                }
            });
        }

        $('#contenidoTabla').delegate(".editarCategoria","click", function() {
            var dodo = $(this); //Acceder al contenido de la etiqueta 'a'
            var actualid = dodo.data('id');
            BootstrapDialog.show({
                title: 'Editar Categoria', // Aquí se pone el título
                size: BootstrapDialog.SIZE_WIDE, //Indica el tamaño
                message: function(dialog) { 
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad); //Cargamos la vista
                    return $message;
                },
                data: {
                    'pageToLoad': base_url+'index.php/Categorias/formulario'
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
                      	    var descripcionViejo = $("#txtdescripcion").data('info'); 
                      	    var descripcion = $("#txtdescripcion").val(); 
                      	    var id = $("#txtdescripcion").data('id');
                      	    //Terminamos de obtener la informacion desde php
                          	if(descripcion != descripcionViejo){//Comparamos si se hizo un cambio con la informacion que ya se tenia
                          		BootstrapDialog.confirm({
        				            title: 'Información',
        				            message: 'La siguiente categoria va ser modificado ¿Desea continuar?',
        				            //type: BootstrapDialog.TYPE_INFO, 
        				            btnCancelLabel: 'Cancelar', 
        				            btnOKLabel: 'Continuar', 
        				            btnOKClass: 'btn-info', 
        				            callback: function(result) {
        				            	if(result){
        				            		var formData = new FormData($('#formulario')[0]);
        		                    		formData.append('id', id);
        				                    $.ajax({
        				                        url:base_url+"index.php/Categorias/editarLaboratorio",
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
                                                                message: 'El nombre '+$('#txtdescripcion').val()+' ya existe. Por favor, ingrese uno diferente'
                                                            });
                                                            $('#txtdescripcion').val('');
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
        				            message: 'Para editar una categoria, debe cambiar al menos un campo',
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
                msg ="<br><br> <strong>Nota:</strong> A dar de baja una categoria, es posible que no aparezca para ser seleccionado";
            }
            else{
                actualado = 1;
            }
            BootstrapDialog.confirm({
                title: 'Advertencia',
                message: 'Se cambiará el estatus de la categoria ¿Desea continuar?'+msg,
                type: BootstrapDialog.TYPE_DANGER, 
                btnCancelLabel: 'Cancelar', 
                btnOKLabel: 'Continuar', 
                btnOKClass: 'btn-danger', 
                callback: function(result) {
                    if(result){
                        $.ajax({
                            url:base_url+"index.php/Categorias/cambiarEstatusCategoria/",
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
        
       
        $('#agregarCategoria').click(function(){
            BootstrapDialog.show({
                title: 'Nuevo Categoria', 
                size: BootstrapDialog.SIZE_WIDE, 
                message: function(dialog) { 
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': base_url+'index.php/Categorias/formulario'
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
                                url:base_url+"index.php/Categorias/agregarCategoria",
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
                                                message: 'El nombre '+$('#txtdescripcion').val()+' ya existe. Por favor, ingrese uno diferente'
                                            });
                                            $('#txtdescripcion').val('');
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
