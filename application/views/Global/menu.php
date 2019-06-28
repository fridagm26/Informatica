<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-right info">
        </div>
        <div class="clear">&nbsp;</div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Modulos</li>
          <?php 
           foreach($modulos as $modulo){ ?>
          <!--  {
             
            echo "<br>" .$modulo->nombre;
            echo "<br>" .$modulo->ruta;
           } -->
          <!--Menu-->
          <li><a href="<?php echo base_url($modulo->ruta);?>"><i class="fa fa-file"></i><?php echo $modulo->nombre?></a></li>
          <?php }?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>