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
                <h1 class="text-justify">Equipos</h1>
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
                            <h5 class="modal-title" id="exampleModalLabel">Añadir Equipo</h5>
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
                            <th scope="col">Serie</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Accion</th>
                            </tr>
                        </thead>
                        <tbody id="tEquipos">
                        </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="agregarEquipo()">Añadir</button>
                </div>
                </div>
            </div>
        </div>
       </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>
<script>

</script>
<?php $this->load->view('Global/footer')?>

<script src="<?php echo base_url('assets/js/header.js'); ?>"></script>

