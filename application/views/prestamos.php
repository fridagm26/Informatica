<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<div class="content-wrapper">
  <section class="content py-2 text-xs-center">
        <div class="container-fluid">
            <div class="row">
                <blockquote style=" border-left: 5px solid #264d78;">
                    <h1 class="text-justify">Categorias</h1>
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
                            <th scope="col">Descripción</th>
							<th scope="col">Estado</th>
                            <th scope="col">Acción</th>
						</tr>
					</thead>
					<tbody>
                        <?php 
                            foreach($prestamos as $prestamo){
                                $estado='<button type="button" onclick="estadoPrestamo()" class="btn btn-success">Aceptar</button>';
                                $estado2='<button type="button" onclick="estadoPrestamo()" class="btn btn-danger">Rechazar</button>';
                                if($prestamo->estado==1){
                                    $estado='<button type="button" onclick="estadoPrestamo()" class="btn btn-danger">Rechazar</button>';
                                }
                                echo 
                                    '<tr>
                                        <td>'.$prestamo->id_prestamo.'</td>
                                        <td>'.$estado.'</td>
                                        <td>'.$estado2.'</td>
                                        <td><button type="button" onclick="modificarPrestamo()" class="btn btn-primary">Detalles</button></td>
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