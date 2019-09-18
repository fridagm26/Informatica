<!DOCTYPE html>
<html lang="en">
<head>
	<title>Inicio de Sesion</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/Logo-Upsin.png">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  	<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  	<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/hamburgers.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/select2.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/util.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
	<style>
     #load{height: 100%;width: 100%;}
     #load{
        position: fixed;
        z-index: 99999;
        top: 0;
        left: 0;
        overflow: hidden;
        text-indent: 100%;
        font-size: 0;
        opacity: 0.6;
        background: #E0E0E0 url(<?php echo base_url('assets/images/loading.gif');?>) center no-repeat;
     }
	 #logoupsin{
		margin-top: -70px;
	 }
   </style>

</head>

<body>
	<div hidden id="load">Please Wait...</div>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt id="div-img">
					<img src="<?php echo base_url();?>assets/images/Logo-Upsin.png" alt="IMG" id="logoupsin">
				</div>
				<form class="login100-form validate-form" id="login">
					<div class="col-md-12"  id="error">
						<div class="box box-danger box-solid">
							<div class="box-header with-border">
								<h4 class="box-title text-center">Inicio de sesión fallido</h4>
							</div>
							<div class="box-body text-center" style="color:red;" id="contenido">

							</div>
						</div>
				    </div>
				    
					<span class="login100-form-title">
						Inicio de sesión
					</span>
					
					<div class="wrap-input100 validate-input" id="erroru" data-validate = "El usuario es requerido">
						<input class="input100" type="text" name="usuario" placeholder="Usuario" id="usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" id="errorc" data-validate = "Contraseña es requerida">
						<input class="input100" type="password" name="contraseña" id="contraseña" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn" id="btnInicio">
							Entrar
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Olvidó
						</span>
						<button class="txt2" type="button" id="olvidarU">
							Usuario / Contraseña
						</button>
					</div>

					
				</form>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-dialog.min.js'); ?>"></script>	
	<script src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/tilt.jquery.min.js'); ?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
</body>
</html>
<script>
	$(document).ready(function(){
		var base_url = '<?php echo base_url(); ?>';

		$("#error").hide();

		$('#olvidarU').click(function()
		{
			BootstrapDialog.show(
			{
				title: "Recuperar Cuenta",
                draggable: true,
                message: function (dialog) {
                	$mensaje = '<div class="form-group">'+
                        	'<label>Correo:</label>' +
                        	' <input type="text" required class="form-control" name="txtCorreo" id="txtCorreo" placeholder="Escriba un correo electrónico valido para recuperar su cuenta">'+
                        '</div>';
                    return $mensaje;
                },
                buttons:
                [	
                	{
	                	label: "Aceptar",
                		cssClass: "btn-primary",
                		action:function(dialogMotivo)
                		{
                			//dialog.close();
                			BootstrapDialog.show(
							{
				                title: "Aviso",
				                draggable: true,
				                message: '¿Seguro que desea continuar con el proceso?',
				                buttons:
				                [	
					                {
					                	label: "Aceptar",
					                	cssClass: "btn-primary",
					        			action:function(dialog)
					        			{
					        				dialog.close();
					        				$.ajax(
					        				{
					            				url : base_url + "index.php/Inicio/recuperar",
					            				data: 
					            				{
													correo: $("#txtCorreo").val() 
												},
					            				type: "POST",
					            				beforeSent: function()
					            				{
					            					$('#load').show();
					            				},
					            				complete: function()
					            				{
					            					$('#load').hide();
 
					            				},
					            				success: function(resp) 
					            				{
					            					console.log(resp)
                                                    switch(parseInt(resp)) 
                                                    {
                                                        case 0:
                                                        	dialog.close();
                                                            BootstrapDialog.show({
                                                                title: 'Error',
                                                                message: 'Su Correo no es Valido',
                                                                type: BootstrapDialog.TYPE_DANGER
                                                            });
                                                            break;
                                                        case 1:
                                                            dialog.close();
                                                            BootstrapDialog.alert({
                                                                title:"Cambio Exitoso",
                                                                message: 'La contraseña se ha cambiado Correctamente. Revisa Tu Correo',
                                                                type: BootstrapDialog.TYPE_PRIMARY,
                                                                size: BootstrapDialog.SIZE_SMALL
                                                            });
                                                            dialogMotivo.close();
                                                            break;  
                                                        default:
                                                            $("#msg-error").show();
                                                            $("#msg-error").html(resp);
                                                            break;
                                                    }
                                                },
                                                error:function(jqXHR, textStatus, errorThrown) {
                                                    console.error("Error::" + errorThrown);
                                                    console.log(jqXHR);
                                                    console.log(textStatus);
                                                    $('#load').hide();
                                                } 
					            			});
					            		}
				                	},
					                {
				            			label: "Cancelar",
				            			cssClass: "btn-danger",
				            			action:function(dialog) 
				            			{
				            				dialog.close();
			            				}     			
			            			}
			               		]
			               	});
                		}
	                },
	                {	label: "Cancelar",
            			cssClass: "btn-danger",
            			action:function(dialog) 
            			{
            				dialog.close();
        				}
        			}
                ]
			});	
		});

		$('#btnInicio').click(function(){
			var x="";
			if($('#contraseña').val() == ""){
				var thisAlert = $('#contraseña').parent();
				$(thisAlert).addClass('alert-validate');
				$(location).attr('href','#contraseña');
				$("#error").show();
				x += "<li>Ingresar una contraseña</li>";
				$('#errorc').addClass('alert-validate');
			}

			if($('#contraseña').val() != ""){
				$('#errorc').removeClass('alert-validate');
			}

			if($('#usuario').val() == ""){
				$(location).attr('href','#usuario');
				$("#error").show();
				x += "<li>Ingresar un usuario</li>";
				$('#erroru').addClass('alert-validate');
			}

			if($('#usuario').val() != ""){
				$('#erroru').removeClass('alert-validate');
			}

			$("#contenido").html(x);

			if($('#usuario').val() != "" && $('#contraseña').val() != "" ){
				var formData = new FormData($("#login")[0]);
				$.ajax({
					url:base_url+"index.php/cLogin/ingresar/",
					type:"POST",
					data:formData,
					cache:false,
					contentType:false,
					processData:false,
					success:function(respuesta)
					{
						if (respuesta == 1) 
						{
							$("#error").hide();		
																		 
							window.location.href = base_url+'index.php/cLogin/index';						 
						}
						else if (respuesta == 2) 
						{
							
							var x = "<li>El usuario esta deshabilitado.</li>";
							$("#error").show();
							$("#contenido").html(x);					 
						}
						else 
						{
							var x = "<li>El usuario ó contraseña invalido.</li>";
							$("#error").show();
							$("#contenido").html(x);
						}
					  
					}
				});
			}
		});

		$('#usuario').keyup(function (e) {
			if (e.keyCode === 13) {
				if($('#contraseña').val() == ""){
					$(location).attr('href','#contraseña');
				}
				else{
					$( "#btnInicio" ).trigger( "click" );
				} 
			}
		});

		$('#contraseña').keyup(function (e) {
			if (e.keyCode === 13) {
				if($('#usuario').val() == ""){
					$(location).attr('href','#usuario');
				}
				else{
					$( "#btnInicio" ).trigger( "click" );
				} 
			}
		});
	});
</script>