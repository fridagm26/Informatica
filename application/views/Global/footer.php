<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.0
    </div>
    <strong>Copyright &copy; 2018 <a href="<?php echo base_url(); ?>">Almancen Informatica</a>.</strong> Todos los Derechos Reservados <strong>Proyectos especiales</strong> by UPSIN.
</footer>

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-dialog.min.js'); ?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/js/jquery.sparkline.min.js'); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/js/jquery.knob.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets/js/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/js/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?php echo base_url('assets/js/dashboard.js'); ?>"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/js/demo.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/moment.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/moment-with-locales.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-dialog.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-checkbox.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-filestyle.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datepicker.min.js"); ?>"></script>


</div>
</body>
</html>
<script>
    $( document ).ajaxStart(function() {$("#load").show();});
    $( document ).ajaxStop(function() {$("#load").hide();});
	var base_url = '<?php echo base_url(); ?>';
	function insertarPaginado(id,length=10,search=false){
	  return $(`#${id}`).DataTable({
	     'paging'       : true,
	     'lengthChange' : false,
	     'searching'    : search,
	     'ordering'     : true,
	     'info'         : true,
	     'scrollx'      :true,
	     'autoWidth'    : false,
	     'destroy'      : true,
	     "iDisplayLength": length,
	    //  "language"     : {  "url": `<?php echo base_url()?>assets/files/SpanishT.json`  }
	  });

	}
    
    // window.onload=hora;
    
    // fecha = new Date("<?php echo date('Y-m-d H:i:s', time()); ?>");

    // function hora(){
    //    // console.log(fecha);
    //     var hora=fecha.getHours();
    //     var minutos=fecha.getMinutes();
    //     var segundos=fecha.getSeconds();
    //     if(hora<10){ hora='0'+hora;}
    //     if(minutos<10){minutos='0'+minutos; }
    //     if(segundos<10){ segundos='0'+segundos; }
    //     fech=hora+":"+minutos+":"+segundos;
    //     document.getElementById('hora').innerHTML=fech;
    //     fecha.setSeconds(fecha.getSeconds()+1);
    //     setTimeout("hora()",1000);
    // }
</script>