<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<div class="modal" id="modal-detalles" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles Prestamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detallesPrestamo" action="<?php echo base_url() ?>index.php/Prestamos/detallesPrestamo" method="POST">
                    <div class="form-group">
                        <label>Fecha de registro</label>
                        <input type="text" class="form-control" name="fechaRegistro">
                    </div>
                    <div class="form-group">
                        <label>Fecha de Prestamo</label>
                        <input type="text" class="form-control" name="fechaPrestamo">
                    </div>
                    <div class="form-group">
                        <label>Fecha de Devolucion</label>
                        <input type="text" class="form-control" name="fechaDevolucion">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
  <section class="content py-2 text-xs-center">
        <div class="container-fluid">
            <div class="row">
                <blockquote style=" border-left: 5px solid #264d78;">
                    <h1 class="text-justify">Prestamos</h1>
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
				 <table class="table table-striped no-margin" style="width:100%" id="tablaPrestamos">
					<thead class="thead-dark">
						<tr>
                            <th scope="col">Fecha de registro</th>
                            

						</tr>
					</thead>
					<tbody>
                        <?php 
                            foreach($prestamos as $prestamo){
                                $estado='<button type="button" onclick="estadoPrestamo()" class="btn btn-success">Aceptar</button>';
                                $estado2='<button type="button" onclick="estadoPrestamo()" class="btn btn-danger">Rechazar</button> ';
                                if($prestamo->estado==1){
                                    $estado='<button type="button" onclick="estadoPrestamo()" class="btn btn-danger">Rechazar</button>';
                                }
                                echo 
                                    '<tr>
                                        <td>'.$prestamo->fecha_registro.'</td>
                                        <td>'.$estado.'</td>
                                        <td>'.$estado2.'</td>
                                        <td><button type="button" onclick="detallesPrestamo(\''.$prestamo->fecha_registro.'\', 
                                        \''.$prestamo->fecha_prestamo.'\', \''.$prestamo->fecha_devolucion.'\', '.$prestamo->id_prestamo.')" 
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
    var prestamoDetalles = 0;
    function detallesPrestamo(fecha_registro, fecha_prestamo, fecha_devolucion, id_prestamo) {
        $('input[name="fechaRegistro"]').val( fecha_registro );
        $('input[name="fechaPrestamo"]').val( fecha_prestamo );
        $('input[name="fechaDevolucion"]').val( fecha_devolucion );
        prestamoDetalles = id_prestamo;
        $("#modal-detalles").modal('show');
    }
</script>

<?php $this->load->view('Global/footer')?>

<script src="<?php echo base_url('assets/js/header.js'); ?>"></script>