<div class="container-fluid">
	<div class="table-responsive">
		<table class="table no-margin" id="tabla">
			<thead>
				<tr>
					<th>Relacion</th>
					<th>Nombre</th>
					<th>Descripción</th>
				</tr>
			</thead>
			<tbody id="tablaModulos">
				<?php
					foreach ($modulosx as $modulo) {
	     				echo '<tr>';
		     			if($modulo->tiene == "si") {
		     				echo '	<td><input id="modulo'.$modulo->id.'"  checked type="checkbox" class="checkModulos" data-id_modulo="'.$modulo->id.'" ></td>';
		     			}
		     			else {
		     				echo '	<td><input id="modulo'.$modulo->id.'"  type="checkbox" class="checkModulos" data-id_modulo="'.$modulo->id.'" ></td>';
		     			}
						echo '	<td>'.$modulo->nombre.'</td>';
						echo '	<td>'.$modulo->descripcion.'</td>';
						echo '</tr>';						  
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.checkModulos').checkboxpicker({
			html: true,
			offLabel: '<span class="glyphicon glyphicon-remove">',
			onLabel: '<span class="glyphicon glyphicon-ok">'
		});
		
		var tabla = insertarPaginado("tabla",10,true);
		var $idPerfil = "<?php echo $id_perfil;?>";

		$(".checkModulos").change(function() {
		  	var doc = $(this);
	      	var $idModulo = doc.data('id_modulo');

		 	if($(this).is(":checked")){
		  		BootstrapDialog.confirm({
		            title: 'Asignar modulo',
		            message: 'Se va asignar un modulo al perfil¿Desea continuar?',		            
		            btnCancelLabel: 'Cancelar',
		            btnOKLabel: 'Continuar', 
		            btnOKClass: 'btn-primary', 
		            callback: function(result) {
		            	var no=0;
		            	console.log(result);
		             	if(result){
		             		$.ajax({
						        url:base_url+"index.php/Perfiles/asignarModuloPerfil/",
						        type:"POST",
						        data: {
						        		id_perfil 	 : $idPerfil,
							        	id_modulo	 : $idModulo
							    },
					            success:function(respuesta){
						            
						        },
						        error:function(jqXHR, textStatus, errorThrown){
					                console.log('error:: '+ errorThrown);
					            }
					        });
		             		no = 1;		             		
		             	}
		             	else if(!result){		             		
		             		$("#modulo"+ id_modulo).prop('checked', false);		             		
		             	}
		            }
		        });
		 	} 
		  	else{
			  	BootstrapDialog.confirm({
		            title: 'Advertencia',
		            message: 'Va a eliminar un modulo al perfil ¿Desea continuar?',
		            type: BootstrapDialog.TYPE_WARNING, 
		            btnCancelLabel: 'Cancelar',
		            btnOKLabel: 'Continuar', 
		            btnOKClass: 'btn-danger', 
		            callback: function(result) {
		            	console.log(result);
		            	var no=0;
		             	if(result) {
		             		$.ajax({
						        url:base_url+"index.php/Perfiles/eliminarModuloPerfil/",
						        type:"POST",
						        data: {
					        		id_perfil 	 : $idPerfil,
						        	id_modulo	 : $idModulo
							    },
					            success:function(respuesta){
					            	console.log(respuesta);						            
						        },
						        error:function(jqXHR, textStatus, errorThrown){
					                console.log('error:: '+ errorThrown);
					            }
					        });		             		
		             		no = 1;
		             	}
		             	else if(!result){
		             		$("#modulo"+id_modulo).prop('checked', true);		             		 
		             	}
		            }
		        });
		  	}
		});	
	});
</script>