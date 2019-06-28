<!-- MENU MENU MENU MENU MENU -->
  <?php $this->load->view('Global/header'); ?>
  <?php $this->load->view('Global/menu',$modulos); ?>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
       <section class="content">
       	<div class="row">
       		<div class="clear">
           <a href="#">Aqui jalo Usuario</a>  
					 <?php
						 foreach($modulos as $modulo)
						 {
							echo "<br>" .$modulo->nombre;
							echo "<br>" .$modulo->ruta;
             }
             
					 ?>
       		</div>
            
            
         </div>
       </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>
<?php $this->load->view('Global/footer')?>

<script src="<?php echo base_url('assets/js/header.js'); ?>"></script>