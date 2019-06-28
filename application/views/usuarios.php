<!-- MENU MENU MENU MENU MENU -->
<?php $this->load->view('Global/header'); ?>
<?php $this->load->view('Global/menu'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<!-- <script src="<?php echo base_url('assets/datatables.min.js') ?>"></script>
<link href="<?php echo base_url('assets/datatables.min.css') ?>" />
<link href="<?php echo base_url('assets/DataTables-1.10.18/dataTables.bootstrap.css') ?>" />
<link href="<?php echo base_url('assets/DataTables-1.10.18/jquery.dataTables.min.css') ?>" /> -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
       <section class="content">
			 	<h1>Perfiles</h1>
       	<div class="row">
          <!-- Empieza tabla -->
				  <table class="table ta" id="tablaPerfiles">
            <thead>
              <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Descripción</th>
                <th scope="col">Estado</th>
                <th scope="col">Acción</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aqui -->
            </tbody>
				</table>
				<!-- Termina tabla -->
        </div>
       </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>

<script>
  
</script>

<?php $this->load->view('Global/footer')?>

<script src="<?php echo base_url('assets/js/header.js'); ?>"></script>