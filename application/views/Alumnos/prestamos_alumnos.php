<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<div class="modal" id="modal-prestamo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Prestamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="nuevoPrestamo" action="<?php echo base_url() ?>index.php/Prestamos_alumnos/nuevoPrestamo" method="POST">
                    <div class="form-group">
                        <label>Fecha de Prestamo</label>
                        
                        <input type="date" class="form-control" name="fechaPrestamo">
                    </div>
                    <div class="form-group">
                        <label>Fecha de Devolucion</label>
                        <input type="date" class="form-control" name="fechaDevolucion">
                    </div>
                    <div class="form-group">
                        <label>Material</label>
                        <!-- <div class="col-sm-9"> -->
                                <select id="Material" class="form-control" name="Material">
                                <option data-material="N/A" value="0">Selecciona un material</option>
                                    <?php if (isset($materiales)): ?>
										<?php foreach($materiales as $mat): ?>										
											<option value="<?php echo $mat->id?>"><?php echo $mat->descripcion?></option>
										<?php endforeach;?>
									<?php endif; ?>
                                </select>
                            <!-- </div> -->
                    </div>
                    <div class="form-group">
                        <label>Cantidad</label>
                        <input type="text" class="form-control" name="Cantidad">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-detalles" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de Prestamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detallesPrestamo" action="<?php echo base_url() ?>index.php/Prestamo_alumno/detallesPrestamo" method="POST">
                    <div class="form-group">
                        <label>Fecha de prestamo</label>
                        <input type="text" class="form-control" name="fPrestamo">
                    </div>
                    <div class="form-group">
                        <label>Fecha de devolucion</label>
                        <input type="text" class="form-control" name="fDevolucion">
                    </div>
                    <div class="form-group">
                        <label>Material</label>
                        <input type="text" class="form-control" name="dMaterial">
                    </div>
                    <div class="form-group">
                        <label>Cantidad</label>
                        <input type="text" class="form-control" name="dCantidad">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
  <section class="content">
        <div class="container-fluid">
            <div class="row">
                <blockquote style=" border-left: 5px solid #264d78;">
                    <h1>Prestamos</h1>
                </blockquote>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <input type="search" class="form-control" placeholder="Buscar" style="width:250px; heigth:100px;">
                        <button style="margin-left:1000px; width:60%; font-size:12pt;" type="submit" class="btn btn-success" onclick="añadirPrestamo()"><span class="fa fa-plus">&nbsp;</span>Nuevo</button>
                    </div>
                </div>
            </div>
       	<div class="row">
           <div class="box box-primary">
                    <div class="clear">
				 <!-- Empieza tabla -->
				 <table class="table ta" id="tablaPrestamos">
					<thead>
						<tr>
                            <th scope="col">Fecha de registro</th>
                            <th></th>
                            <th scope="col">Estado</th>
                            <th scope="col">Detalles</th>
						</tr>
					</thead>
					<tbody>
                        <?php 
                            foreach($prestamos as $prestamo){
                                $estado='<td>En espera</td>';
                                if($prestamo->estado==1){
                                    $estado='<td type="text">Aceptada</td>';
                                }else if($prestamo->estado==0){
                                    $estado='<td type="text">Rechazada</td>';
                                }
                            foreach($detalle_prestamo as $dPrestamo){
                                $material=2;
                            }
                            foreach($materiales as $mat){
                                if($mat->id=$material){
                                    $mate=$mat->descripcion;
                                }
                            }    
                            
                                echo 
                                    '<tr>
                                        <td>'.$prestamo->fecha_registro.'</td>
                                        <td>'.$estado.'</td>
                                        <td><button type="button" onclick="detallesPrestamo(\''.$prestamo->fecha_registro.'\', 
                                        \''.$prestamo->fecha_prestamo.'\', \''.$mate.'\', '.$prestamo->id_prestamo.')" 
                                        class="btn btn-primary">Detalles</button></td>
                                    </tr>';
                            }
                        ?>
					</tbody>
				</table>
				<!-- Termina tabla -->
				<!-- <div class="botones"> -->
				<!-- </div> -->
        </div>
       </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>

<script>
    function añadirPrestamo(){
        $("#modal-prestamo").modal('show');
        $('input[name="fechaPrestamo"]').val('');
        $('input[name="fechaDevolucion"]').val('');
        $('input[name="Material"]').val('');
        $('input[name="Cantidad"]').val('');
    }

    $('#nuevoPrestamo').submit(function() {
        if($('input[name="fechaPrestamo"]').val() !== "" && $('input[name="fechaDevolucion"]').val() !== "" 
        && $('input[name="Material"]').val() !== "" && $('input[name="Cantidad"]').val() !== "") {
            $.ajax({
                url: 'Prestamos_alumnos/nuevoPrestamo', 
                type: "post",
                data: $('#nuevoPrestamo').serialize(),
                success: function( response ) {
                    response = JSON.parse(response);
                    let estadoPrestamo= '<td type="text">En espera</td>';
                    if(response.estatus==1){
                        estadoPrestamo='<td type="text">Aceptada</td>';
                    }else if(response.estatus==0){
                        estadoPrestamo='<td type="text">Rechazada</td>';
                    }

                    $('#tablaPrestamos tbody').prepend(
                        '<tr>'+
                            '<td>'+response.fechaPrestamo+'</td>'+
                            '<td>'+estadoPrestamos+'</td>'+
                            '<td><button type="button" onclick="detallesPrestamo(\''+response.fechaPrestamo+'\', \''+response.fechaDevolucion+'\', \''+response.Material+'\', \''+response.Cantidad+'\', '+response.id+')" class="btn btn-primary">Detalles</button></td>'+
                        '</tr>'
                    );
                    $("#modal-prestamo").modal('hide');
                    alert("Solicitud de prestamo realizada");
                }
            });
        }
        else {
            alert('Favor de llenar todos los campos.');
        }
        return false;
    });

    var prestamoDetalles = 0;
    var temp = 0;
    var temp2 = 0;
    function detallesPrestamo(fecha_prestamo, fecha_devolucion, descripcion, cantidad, id_prestamo, id_categoria, id_equipo_material) {
        $('input[name="fPrestamo"]').val( fecha_prestamo );
        $('input[name="fDevolucion"]').val( fecha_devolucion );
        $('input[name="dMaterial"]').val( descripcion );
        $('input[name="dCantidad"]').val( cantidad );
        temp = id_categoria;
        temp2 = id_equipo_material;
        prestamoDetalles = id_prestamo;
        $("#modal-detalles").modal('show');
    }

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