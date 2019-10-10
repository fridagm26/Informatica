<?php $this->load->view("Global/header"); ?>
<?php $this->load->view("Global/menu"); ?>
<div class="content-wrapper">
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="clear">&nbsp;&nbsp;</div>
				
			</div>
			<div class="clear">&nbsp;</div>
			<div class="row">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-list"></i> Listado de entradas</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><li class="fa fa-minus"> </li></button>
						</div>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="tblPreEntradas" class="table table-striped no-margin" style="width: 100%">
								<thead>
									<tr>
										<th>Código</th>
										<th>Producto</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Monto</th>
										<th>Tipo producto</th>
										<th>No. Serie</th>
										<th>No. Inventario</th>										
										<th>Remover</th>
									</tr>
								</thead>
								<tbody id="contenidoTabla">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<button type="button" class="btn btn-primary btn-lg" id="agregarPrestamo" style="background-color: #264d78">Registrar</button>
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-4" style="padding-left: 0px; padding-right: 0px; ">
							<h4>Sub total: </h4>
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-9">
									<h4 class="pull-right" id="subtotal" data-value="0">0</h4>
								</div>
							</div>							
						</div>						 
					</div>
					<div class="row">
						<div id="impuestos">							
							<?php if (isset($impuestos)): ?>
								<?php foreach ($impuestos as $impuesto): ?>
									<div class="row">
										<div class="col-md-3">
											<h4><?php echo strtoupper($impuesto->nombre) ?>:</h4>
										</div>
										<div class="col-md-9">
											<div class="row">
												<div class="col-md-9">
													<h4 class="impuesto pull-right" data-porcentaje="<?php echo $impuesto->porcentaje ?>" id="<?php echo $impuesto->nombre ?>"><?php echo $impuesto->porcentaje."%" ?></h4>
												</div>
											</div>
										</div>
									</div>							 
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="row">
						<div id="flette">							
							<button type="button" class="btn btn-sm btn-success" id="btn-flette">Aplicar Flette</button>						
							<h4 class="col-md-3" style="padding-left: 0px; padding-right: 0px; display: none;">Flette: </h4>
							<span class="col-md-9" style="display: none; padding-left: 0px; padding-right: 0px;">
								<div class="row">
									<div class="col-md-9">
										<input type='number' class='Numeros form-control' id='txtFlette' name='txtFlette' placeholder="0">
									</div>
									<div class=" col-md-2">
										<button type='button' id='btn-del-flette' class='btn btn-sm btn-danger' title='Remover Flette'><i class='fa fa-times'></i></button>
									</div>
								</div>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3" style="padding-left: 0px; padding-right: 0px;">
							<h4>Total: </h4>
						</div>
						<div class="col-md-9">
							<div class="row">
								<div class="col-md-9">
									<h4 class="pull-right" id="total" data-value="0">0</h4>
								</div>
							</div>
						</div>						 
					</div>
				</div>
			</div>
			<div class="row">
				<a class="btn btn-primary btn-lg pull-right" href="<?php echo base_url("index.php/Entradas/verEntradas")?>" style="background-color: #264d78">Ver todas las entradas registradas</a>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view("Global/footer"); ?>
<script type="text/javascript" src="<?php echo base_url("assets/js/validaciones.js")?>"></script>
<script>
	$(document).ready(function() {
		var $productos = JSON.parse('<?php echo json_encode($prods)?>');
		var $impuestos = JSON.parse('<?php echo json_encode($impuestos)?>');
		var tabla = insertarPaginado("tblPreEntradas", 20, true);		
		$(".fecha").datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			todayHighlight: true
		}).datepicker("setDate", new Date());
		
		$("#flette").delegate("#btn-flette", "click", function () {
			flette = $(this).parent()
			$(this).fadeOut("fast", function () {			
				flette.children(":gt(0)").show()
			})
		})

		$("#flette").delegate("#txtFlette", "keyup", recalcularTotal)
		
		$("#flette").delegate("#txtFlette", "change", recalcularTotal)

		$("#flette").delegate("#btn-del-flette", "click", function () {
			$("#flette").children().fadeOut("fast").promise().done( function () {
				$("#flette").children('button').show()	
				$("#txtFlette").prop("placeholder", "0")				
				recalcularTotal()
			})			
		})
		
		$("#txtCodigo").focusin(function () { $("#txtProductos").prop("disabled", true); });

		$("#txtProductos").focusin(function () { $("#txtCodigo").prop("disabled", true); });

		$("#txtProductos").focusout(function () {
			if ($(this).val() == "") {
				$("#txtProductos").val("");
				$("#txtCodigo").prop("disabled", false);
			}			
		});

		$("#txtCodigo").focusout(function () {
			if ($(this).val() == "") {
				$("#txtCodigo").val("");
				$("#txtProductos").prop("disabled", false);
			}
		});			

		$("#txtCantidad").focusout(function () {
			if ($(this).val() == "")
				$(this).val("1");
		});

		$(".enter").keyup(function (event) {
			if ($(this).val().length > 0 && event.keyCode == 13)
				añadirProducto();			
		});	

		function getFecha() {
			return new Date().toLocaleDateString();
		}

		function getHora() {
			return new Date().toLocaleTimeString();
		}	

		function obtenerNumeros ($data, tr, $nS = true, $nI = false) {
			if (!$nS && !$nI)
				return;			
			var numeros = [], Break = {}, clicks = 0, tdS, tdI;
			var $mensaje = 	'<div hidden class="alert alert-danger" id="msg-error" style="text-align:left;">' +
						    '<strong>¡Importante!</strong> Corregir los siguientes errores.<div class="list-errors">' +
						    '</div></div><p class="text-muted">Ingrese ' + $data.producto['cantidad'] + ' números de serie y/o inventario</p><table class="table table-striped table-hover tabla" id="tblNumeros"><thead style="background-color:#111111; color: white;"><th>' + $data.producto['nombre'] + '</th>';								
			if ($nS) {
				tdS = '<td><input type="number" class="form-control numS"></td>';
				$mensaje += '<th>Números de serie</th>';				
			}
			if ($nI) {
				tdI = '<td><input type="number" class="form-control numI"></td>';
				$mensaje += '<th>Números de inventario</th>';				
			}
			$mensaje += "</thead><tbody>";			
			for (i = 0; i < $data.producto['cantidad']; i++)
				$mensaje += "<tr><td>" + (i+1) + "</td>" + (tdS? tdS : tdI) + "</tr>";
			$mensaje += '</tbody></table>';			
			BootstrapDialog.show({
				title: "Agregar Números de serie y/o inventario",
				message: $mensaje,
				draggable: true,
				onhidden: function (dialog) {
					$(tr).removeClass("modificando");
				},
				onshown: function (dialog) {
					$(tr).addClass("modificando");					
					if ($nS && $(tr).attr("numerosserie") != 0) 
						numeros = $(tr).attr("numerosserie").split(",");
					else if ($nI && $(tr).attr("numerosinventario") != 0)
						numeros = $(tr).attr("numerosinventario").split(",")
					if (numeros.length != 0 )
						$.each($("#tblNumeros tbody tr td input"), function (index, input) {							
							$(input).val(numeros[index]);
						});											
				},
				buttons: [
					{
						label: "Guardar",
						cssClass: "btn-primary",
						action: function ( dialog ) {
							$(".list-errors").html("");
							var otrosNumeros = [], haySerieRepetido = false, hayInventarioRepetido = false, hayCamposVacios = false;	
							numeros = [];
							$.each($("#tblNumeros tbody tr td input"), function (index, input) {
								$(input).parent().parent().removeClass("has-error");
								if ($(input).val() == "") {
									$(input).parent().parent().addClass("has-error");
									hayCamposVacios = true;
								}
								else {
									$.each($("#tblNumeros tbody tr td input:gt(" + index + ")"), function (indexTemp, inputTemp) {
										if ($(input).val() == $(inputTemp).val()) {
											$(inputTemp).parent().parent().addClass("has-error");
											if ($nS)
												haySerieRepetido = true;
											else
												hayInventarioRepetido = true;
										}
									});
									if (!haySerieRepetido && !hayInventarioRepetido) {
										numeros.push(parseInt($(input).val()))
										$.each($("#tblPreEntradas tbody tr:not(.modificando)"), function (index, tr) {
											if ($nS && $(tr).attr("numerosserie") != 0) {
												otrosNumeros = $(tr).attr("numerosserie").split(",");
												if (numeros.in(otrosNumeros)) {
													$(input).parent().parent().addClass("has-error");
													haySerieRepetido = true;
												}
											}
											else if ($nI && $(tr).attr("numerosinventario") != 0) {
												otrosNumeros = $(tr).attr("numerosinventario").split(",");
												if (numeros.in(otrosNumeros)) {
													$(input).parent().parent().addClass("has-error");
													hayInventarioRepetido = true;;
												}
											}										
										});
									}
								}
							});
							if (hayCamposVacios) {
								$("#msg-error").show();
								$(".list-errors").html("<li>Hay campos vacios</li>");								
							}
							if (hayInventarioRepetido) {
								$("#msg-error").show();
								$(".list-errors").html($(".list-errors").html() + "<li>Los números de inventario indicado ya existen.</li>")
							}
							if (haySerieRepetido) {
								$("#msg-error").show();
								$(".list-errors").html($(".list-errors").html() + "<li>Los números de serie indicado ya existen.</li>");									
							}
							if (hayCamposVacios || hayInventarioRepetido || haySerieRepetido)
								return;							
							$.ajax({
								url: base_url + "index.php/Entradas/verificarNumeros",
								type: "POST",
								data: {
									nums: numeros,
									tipo: $nS // true para serie y false para inventario
								},
								success: function ( res ) {									
									res = JSON.parse(res);									
									if (typeof res != "boolean") {
										$.each($("#tblNumeros tbody tr td input"), function (index, input) {											
											$.each(res, function (index, num) {
												if (num['num'] == $(input).val()) {
													$(input).parent().parent().addClass("has-error");													
													if ($nS) haySerieRepetido = true;
													else hayInventarioRepetido = true;
												}
											});												
										});																			
									}
									else {
										dialog.close();
										if ($nS) {
											$(tr).attr("numerosserie", numeros);
											$(tr).find(".btnNumS").removeClass("btn-default btn-warning").addClass("btn-primary").attr("title", "Números de serie asignados");
										}
										else {
											$(tr).attr("numerosinventario", numeros);
											$(tr).find(".btnNumI").removeClass("btn-default btn-warning").addClass("btn-primary").attr("title", "Números de inventario asignados");
										}
										$(tr).removeClass("modificando");
									}
									if (haySerieRepetido) {
										$("#msg-error").show();
										$(".list-errors").html($(".list-errors").html() + "<li>Los números de serie indicado ya existe.</li>");										
									}
									if (hayInventarioRepetido) {
										$("#msg-error").show();
										$(".list-errors").html($(".list-errors").html() + "<li>Los números de inventario indicado ya existe.</li>");										
									}	
									
								},
								error: function ( jqXHR, textStatus, errorThrown ) {
									console.error("Error::" + errorThrown);
								}
							});							
						}
					},
					{
						label: "Cancelar",
						cssClass: "btn-danger",
						action: function (dialog) {							
							dialog.close();							
						}
					}									
				]
			});			
		}
		
		function eliminarNumeros ($data, tr) {
			var numerosSerie = $(tr).attr("numerosserie").split(","), numerosInventario = $(tr).attr("numerosinventario").split(",") , Break = {};
			if (numerosSerie == 0)
				numerosSerie = []			
			if (numerosInventario == 0)
				numerosInventario = [];
			var mensaje = "<table class='table table-striped table-hover' id='tblRemover'><thead><th>Selecciona</th><th>No. Serie</th><th>No. Inventario</th></thead><tbody>";
			for (var i = 0; i < $data.producto['cantidad']; i++)
				mensaje += "<tr><td><center><input type='checkbox' style='heigh: 20px; width: 20px;'></center></td><td><input type='text' class='form-control numS'></td><td><input type='text' class='form-control numI'></td></tr>";
			mensaje += "</tbody></table>";
			BootstrapDialog.show({
				title: "Quitar productos de " + $data.producto['nombre'],
				message: mensaje,
				draggable: true,
				onshown: function (dialog) {
					$(tr).addClass("modificando");
					var indiceSerie = 0, indiceInventario = 0;
					$.each($("#tblRemover tbody tr td input[type=text]"), function (index, input) {
						if ($(input).hasClass("numS")) {							
							$(input).val(numerosSerie[indiceSerie]);
							indiceSerie++;
						}
						else {
							$(input).val(numerosInventario[indiceInventario]);
							indiceInventario++;
						}
					});
				},
				onhidden: function (dialog) {
					$(tr).removeClass("modificando");
				},
				buttons: [
					{
						label: "Remover",
						cssClass: "btn-primary",
						action: function (dialog) {
							BootstrapDialog.confirm({
								title: "Confirmar",
								message: "Se eliminaran " + $("#tblRemover tbody tr td input:checked").length + " productos tipo " + $data.producto['nombre'] + ".<br>¿Desea continuar?",
								btnOkLabel: "Sí",
								btnCancelLabel: "No",
								btnOkClass: "btn-primary",
								btnCancelClass: "btn-danger",
								callback: function (ok) {
									if (ok) {
										var cantidadReducida = 0;
										$.each($("#tblRemover tbody tr td input:checked"), function (index, cbx) {
											var tr = $(cbx).parent().parent().parent();												
											numerosSerie.remove($(tr).find(".numS").val());
											numerosInventario.remove($(tr).find(".numI").val());											;
											cantidadReducida++;
										});										
										if (numerosSerie.length == 0 && numerosInventario.length == 0) {
											tabla.row(tr).remove().draw();
										}
										else {
											$("td:eq(2)", tr).text(parseInt($("td:eq(2)", tr).text()) - cantidadReducida);
											$(tr).attr("numerosserie", numerosSerie);
											$(tr).attr("numerosinventario", numerosInventario);
										}										
										if (tabla.rows().count() == 0) {
											limpiarFormulario();
											$("#txtNumFactura").val("");
											$("#txtNumFactura").prop("disabled", false);
											$("#cmbProveedor").prop("disabled", false);
											$("#cmbProveedor option[value=0]").prop("selected", true);
										}
										dialog.close();
									}
								}
							});
						}
					},
					{
						label: "Cancelar",
						cssClass: "btn-danger",
						action: function (dialog) {
							dialog.close();
						}
					},
					{
						label: "Remover todos",
						cssClass: "btn-success pull-left",
						action: function (dialog) {
							BootstrapDialog.confirm({
								title: "Confirmar",
								message: "¿Eliminar todos los productos tipo " + $data.producto['nombre'] + "?",
								btnOkLabel: "Si",
								btnCancelLabel: "No",
								btnOkClass: "btn-primary",
								btnCancelClass: "btn-danger",
								callback: function (ok) {
									if (ok) {
										dialog.close();
										tabla.row($(tr)).remove().draw();										
									}									
								}
							})
						}
					}
				]
			});
		}

		function añadirProducto ($data) {
			$data = verificarProducto();
			if (!$data)
				return;		
			var tipoEnt = "", Break = {};
			if ($data.producto['tipo'] == 0)
				$tipoEnt = "No Consumible";
			else if ($data.producto['tipo'] == 1)
				$tipoEnt = "Consumible";
			else
				$tipoEnt = "Activo";
			try {
				if (tabla.rows().count() != 0) {
					$.each($("#tblPreEntradas tbody tr") , function (index, item) {
						if ($(item).attr("idProd") == $data.producto['id']) {							
							tabla.cell($("td:eq(2)", item)).data(parseInt($("td:eq(2)", item).text()) + $data.producto['cantidad']);
							tabla.cell($("td:eq(4)", item)).data(parseFloat($("td:eq(2)", item).text()) * $data.producto['precio']);							
							if ($(item).attr("numerosserie") != 0) {								
								$(item).find(".btnNumS").removeClass("btn-default btn-primary").addClass("btn-warning");
								$(item).find(".btnNumS").attr("title", "Hay números de serie sin asignar");
							}
							if ($(item).attr("numerosinventario") != 0) {
								$(item).find(".btnNumI").removeClass("btn-default btn-primary").addClass("btn-warning");
								$(item).find(".btnNumI").attr("title", "Hay números de inventario sin asignar");
							}
							let subtotal = tabla.column(4).data().reduce( function (a, b) {	return a + b });							
							$("#subtotal").data("value", subtotal);
							limpiarFormulario();
							recalcularTotal();						
							throw Break;
						}
					});
				}				
				var fila = tabla.row.add([
					$data.producto['codigo'],
					$data.producto['nombre'],					
					$data.producto['cantidad'],
					$data.producto['precio'],
					parseFloat($data.producto['precio'])*parseInt($data.producto['cantidad']),
					$tipoEnt,
					'<a title="Sin números de serie" class="btn btn-default btn-sm btnNumS btnNum"><span class="fa fa-edit"></span></a>',
					'<a title="Sin números de inventario" class="btn btn-default btn-sm btnNumI btnNum"><span class="fa fa-edit"></span></a>',					
					"<a class='btn btn-sm btn-danger btnRemove'><i class='fa fa-minus'></i></a>"
				]).draw(false).node();
				$(tabla.row(fila).node()).attr("idProd", $data.producto['id']);				
				$("td:eq(5)", fila).attr("tipo", $data.producto['tipo']);
				$(tabla.row(fila).node()).attr("numerosserie", 0);
				$(tabla.row(fila).node()).attr("numerosinventario", 0);
				$("#txtNumFactura").prop("disabled", true);
				$("#cmbProveedor").prop("disabled", true);
				$(".cbx", fila).checkboxpicker({
				 	html: true,
				  	offLabel: '<span class="glyphicon glyphicon-remove"> No',
				  	onLabel: '<span class="glyphicon glyphicon-ok"> Si'
				});
				let subtotal = tabla.column(4).data().reduce( function (a, b) { return a + b });
				$("#subtotal").data("value", subtotal);
				limpiarFormulario();
				recalcularTotal();			
			}
			catch (e) {

			}			
		}		

		function recalcularTotal () {
			let subtotal = parseInt($("#subtotal").data("value"))
			$("#subtotal").text(subtotal)
			let impuestos = []
			let total = subtotal
			for (let impuesto of $impuestos)
				total += ((impuesto["porcentaje"] / 100) * subtotal)			
			if ($("#txtFlette").val() != "0" && $("#txtFlette").val() != "" && !isNaN(parseInt($("#txtFlette").val())))
				total += parseFloat($("#txtFlette").val())
			$("#total").data("value", total)
			$("#total").text(total)
		}	

		$("#btnAddProd").click( function () { añadirProducto(); });

		$("#tblPreEntradas").delegate(".btnRemove", "click", function() {
			var tr = $(this).parent().parent();
			if ($(tr).attr("numerosserie") == 0 && $(tr).attr("numerosinventario") == 0) {
				BootstrapDialog.confirm({
					title: "Remover el producto",
					message: "Se eliminara de la Entrada el producto " + $("td:eq(1)", tr).text() + "<br>¿Desea continuar?",
					btnOKLabel: "Sí",
					btnOKClass: "btn-primary",
					btnCancelLabel: "No",
					callback: function (ok) {
						if (ok) {
							tabla.row(tr).remove().draw();
							if (tabla.rows().count() == 0) {
								$("#txtNumFactura").prop("disabled", false);
								$("#cmbProveedor").prop("disabled", false);
								$("#cmbProveedor option[value=0]").prop("selected", true);
								$(".fecha").datepicker("setDate", new Date());
								$("#txtNumFactura").val("");
								$("#txtCodigo").prop("disabled", false);
								$("#txtProductos").prop("disabled", false);
							}
						}
					}					
				});
			}
			else {
				var $data = {producto: []};
				$data.producto['nombre'] = $("td:eq(1)", tr).text();
				$data.producto['cantidad'] = parseInt($("td:eq(2)", tr).text());
				eliminarNumeros($data, tr);
			}			
		});

		function verificarProducto () {
			var $data = {proveedor: [], producto: []}, Break = {}, hay = false;
			var error = new BootstrapDialog({
				type: BootstrapDialog.TYPE_DANGER,
				size: BootstrapDialog.SIZE_SMALL,
				draggable: true,
				buttons: [
					{
						label: "Aceptar",
						action: function (dialog) {
							dialog.close();
						}
					}
				]
			});
			if ($("#txtNumFactura").val() == "") {
				error.setMessage("El número de factura es obligatorio");
				error.setTitle("Error");
				error.open();
				return false;
			}
			if ($("#cmbProveedor").val() == 0) {
				error.setMessage("<strong>No puede agregar un producto sin proveedor</strong>");
				error.setTitle("Selecciona un proveedor primero");
				error.open();
				return false;
			}
			else {
				$data.proveedor['id'] = $("#cmbProveedor").val();
				$data.proveedor['nombre'] = $("#cmbProveedor option:selected").text();
			}
			if ($("#txtCodigo").val().localeCompare("") == 0 && $("#txtProductos").val().localeCompare("") == 0) {
				error.setMessage("<strong>Debe ingresar un código o nombre</strong>");
				error.setTitle("Ingrese producto o código");
				error.open();
				return false;
			}					
			try {
				$.each($productos, function (index, producto) {
					if (producto['codigo'] == $("#txtCodigo").val() || (producto['nombre'] == $("#txtProductos").val())) {
						$data.producto = producto;
						$data.producto['cantidad'] = parseInt($("#txtCantidad").val());
						hay = true;
						throw Break;
					}
				});
			}
			catch (e) {
				if (e !== Break)
					throw e;
			}
			if (!hay) {
				error.setMessage("<strong>El código ingresado no esta registrado.</strong>");
				error.setTitle("Producto no registrado");
				error.open();
				return false;	
			}
			return $data;
		}

		function generarJSON (tabla) {
			var data = [], encabezados = ["codigo", "producto", "cantidad", "precio", "tipoEnt"]
			$.each($("#" + tabla + " tbody tr"), function (index, tr) {
				var producto = {}
				$.each($("td:not(td:last-child)", this), function (index, td) {
					if (index < encabezados.length)
						producto[encabezados[index]] = $(td).text().trim()
					if (index == 0) {						
						producto.numerosSerie = []	
						producto.numerosInventario = []
						if ($(tr).attr("numerosserie").split(",") != 0)
							producto.numerosSerie = $(tr).attr("numerosserie").split(",")						
						if ($(tr).attr("numerosinventario").split(",") != 0)
							producto.numerosInventario = $(tr).attr("numerosinventario").split(",")
						producto.codigo = parseInt(producto.codigo)						
						producto.idProducto = $(tr).attr("idProd")						
					}					
					else if (index == 2)
						producto.cantidad = parseInt(producto.cantidad)
					else if (index == 5)
						producto.tipoEnt = parseInt($(td).attr("tipo"))
					else if (index == 3)
						producto.precio = parseFloat($(td).text())
				})
				data.push(producto)
			})
			return data
		}		

		$("#tblPreEntradas").delegate(".btnNum", "click", function () {
			var $data = {producto: []};
			var tr = $(this).parent().parent();
			$data.producto['cantidad'] = parseInt($("td:eq(2)", tr).text());
			$data.producto['nombre'] = $("td:eq(1)", tr).text();			
			obtenerNumeros($data, tr, $(this).hasClass("btnNumS"), $(this).hasClass("btnNumI"));
		});	

		$("#btnRegistrarProducto").click(function () {
			BootstrapDialog.show({
				draggable: true,
				size: BootstrapDialog.SIZE_WIDE,				
				title: "Agregar nuevo producto",
				message: function (dialog) {
					var $mensaje = $("<div></div>");
					$mensaje.load(dialog.getData("pageToLoad"));
					return $mensaje;
				},
				data: {
					"pageToLoad": base_url + "index.php/Productos/load/frmProductos"
				},
				buttons: [
					{
						label: "Guardar",
						cssClass: "btn-primary",
						action: function(dialog) {							
							$.ajax({
								url: base_url + "index.php/Productos/add",
								data: $("#frmProducto").serialize(),
								type: "POST",
								success: function (res) {
									if (res == false) {
										$('#msg-error').show();
                                        $('.list-errors').html(resp);
									}
									else {
										switch (parseInt(res)) {
											case -1:
												BootstrapDialog.show({
	                								title: "Error",
	                								message: 'Uno de los datos ingresados nos válido.',
	                								type: BootstrapDialog.TYPE_DANGER,
	                								size: BootstrapDialog.SIZE_SMALL
	                							});
												break;
											case 0:
												BootstrapDialog.show({
	                                            	title: 'Error',
	                                            	message: 'Oops ah surgido un error. Recargar la página',
	                                            	type: BootstrapDialog.TYPE_DANGER
	                                        	});
												break;											
											default:												
												$("#productos").append("<option data-id='" + parseInt(res) + "' value='" + $("#frmProducto #txtNombre").val() + "'>" + $("#frmProducto #txtCodigo").val() + "</option>");
												$("#codigos").append("<option data-id='" + parseInt(res) + "' value='" + $("#frmProducto #txtCodigo").val() +"'>" + $("#frmProducto #txtNombre").val() + "</option>");
												BootstrapDialog.show({
													title: "Producto añadido",
													message: "Se agrego 1 producto nuevo a los registros",
													type: BootstrapDialog.TYPE_SUCCESS,
													size: BootstrapDialog.SIZE_SMALL,
													draggable: true,
													buttons: [
														{
															label:"Aceptar",
															cssClass:"btn-default",
															action: function (lastDialog) { 
																lastDialog.close();
																dialog.close();
																cerrado = true;
															}
														}
													]							
												});
	                                            break;
										}
									}									
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.error("Error::" + errorThrown);
								}
							});
						}
					},
					{
						label: "Cancelar",
						cssClass: "btn-danger",
						action: function (dialog) {
							dialog.close();
						}
					}
				]
			});
		});
		
		$("#btnAddProv").click(function () {
			BootstrapDialog.show({
                title: "Agregar Empresa",
                size: BootstrapDialog.SIZE_WIDE,
                draggable: true,
                message: function(dialog) {
                    $mensaje = $("<div></di>");
                    $mensaje.load(dialog.getData("pageToLoad"));
                    return $mensaje;
                },
                data: {
                    "pageToLoad": base_url + "index.php/Entradas/load/frmProveedores"
                },
                buttons:[
                	{
                		label: "Guardar",
                		cssClass: "btn-primary",
                		action:function(dialog) {
                			$.ajax({
                				url : base_url + "index.php/Entradas/regProv",
                				type: "POST",
                				data: $("#frmProvEnt").serialize(),
                				success:function(resp) {
                					if (resp != false) {                						
                						resp = parseInt(resp);
                						$("#cmbProveedor").append("<option value='" + resp + "'>" + $("#txtEmpresa").val() + "</option>");
                						dialog.close();
            							BootstrapDialog.alert({
            								title: "Empresa agregada",
            								message: "<h3>Se agrego la nueva empresa correctamente.</h3>",
            								type: BootstrapDialog.TYPE_SUCCESS,
            								size: BootstrapDialog.SIZE_SMALL,
            								draggable: true,
            								buttons: [
            									{
            										label: "Aceptar",
            										cssClass: "btn-primary",
            										action: function (lastDialog) {
            											lastDialog.close();            											
            										}
            									}
            								]
            							});
                						switch(parseInt(resp)) {
	                						case 1:
	                							break;
	                						default:
	                                            break;
	                					}
                					}
                					else if (resp == 2) {
                						BootstrapDialog.show({
            								title:"Error",
            								message: 'La empresa ingresada no es válida.',
            								type: BootstrapDialog.TYPE_DANGER,
            								size: BootstrapDialog.SIZE_SMALL
            							});
                					}                					
	                				else {
	                					$("#msg-error").show();
	                					$(".list-errors").html(resp);
	                				}                  						
                				},
                				error(jqXHR, textStatus, errorThrown) {
                					console.error("Error::" + errorThrown);
                				}
                			});
                		}
                	},
            		{
            			label: "Cancelar",
            			cssClass: "btn-danger",
            			action:function(dialog) {
            				dialog.close();
            			}     			
            		}                    	
                ]                    
            });
		});	
	
		function imprimirFicha ($idEntrada) {
			window.location = base_url + "index.php/Entradas/imprimir/" + $idEntrada;
		}

		$("#btnAgregar").click(function () {
			console.log(generarJSON("tblPreEntradas"))
			// console.log($("#txtFlette").val() || 0)
			let impuestosId = []
			for (let impuesto of $impuestos) 
				impuestosId.push({"id": impuesto["id"], "valor": impuesto["porcentaje"]})
			var ok = true, Break = {};
			if (tabla.rows().count() == 0){ 
				BootstrapDialog.alert({
					title: "No hay productos",
					message: "Debe ingresar productos primero.",
					type: BootstrapDialog.TYPE_DANGER,
					size: BootstrapDialog.SIZE_SMALL,
					draggable: true,
					buttons: [
						{
							label: "Aceptar",
							action: function (dialog) {
								dialog.close();
							}
						}
					]
				});
				return;
			}
			try {
				$.each($("#tblPreEntradas tbody tr"), function (index, tr) {					
					if ($("td:eq(3)", tr).text().localeCompare("Activo") == 0 && ($(tr).find(".btnNumI").hasClass("btn-default") || $(tr).find(".btnNumI").hasClass("btn-warning"))) {
						BootstrapDialog.alert({
							title: "Error",
							message: "Para ingresar activos tienes que agregar todos los número de inventario",
							type: BootstrapDialog.TYPE_DANGER											
						});
						ok = false;
						throw Break;				
					}
				});
			} catch (e) {

			}
			if (!ok)
				return;
			$.when(
				$.ajax({
					url: base_url + "index.php/Entradas/verificarFactura",
					data: {
						factura: $("#txtNumFactura").val(),
						idProveedor: $("#cmbProveedor").val()
					},
					type: "POST",				
					error: function (jqXHR, textStatus, errorThrown) {
						console.error("Error::" + res);
					}
				})
			).done(function (res) {
				if (res != 0)
					ok = false;
				if (ok) {										
					var $data = generarJSON("tblPreEntradas");
					BootstrapDialog.confirm({
						title: "Confirmar la entrada",
						message: "Se agregaran " +  tabla.rows().count() + " productos<br><label for='txtRepartidor'>Repartidor (opcional):</label><input type='text' class='form-control Letras' id='txtRepartidor' name='txtRepartidor'>",
						draggable: true,
						btnOKLabel: "Confirmar",
						btnOKClass: "btn-primary",
						btnCancelLabel: "Cancelar",
						btnCancelClass: "btn-danger",
						callback: function (ok) {
							if (ok) {
								$.ajax({
									url: base_url + "index.php/Entradas/add",
									type: "POST",
									data: {
										data: $data,
										idProveedor: $("#cmbProveedor").val(),
										numFactura: $("#txtNumFactura").val(),
										fechaEmision: $("#txtFechaEmisionFactura").val(),
										fechaRecepcion: $("#txtFechaRecepcionFactura").val(),
										repartidor: $("#txtRepartidor").val(),
										subtotal: $("#subtotal").data("value"),
										impuestosId: impuestosId,
										total: $("#total").data("value"),
										flette: $("#txtFlette").val() || 0
									},
									success: function (res) {
										res = JSON.parse(res);
										if (res['exito']) {
											BootstrapDialog.show({
												title: "Entrada hecha con exito.",
												message: "Se añadieron " + tabla.rows().count() + " productos.",
												type: BootstrapDialog.TYPE_SUCCESS,
												size: BootstrapDialog.SIEZ_SMALL,
												buttons: [
													{
														label: "Aceptar",
														cssClass: "btn-default",
														action: function (dialog) {
															dialog.close();
														}
													},
													{
														label: "Descargar ficha",
														cssClass: "btn-success",
														action: function (dialog) {
															dialog.close();
															imprimirFicha(res['idEntrada'], $data);
														}
													}
												]
											});
											tabla.clear().draw();
											limpiarFormulario();
											$("#txtNumFactura").prop("disabled", false);
											$("#cmbProveedor").prop("disabled", false);
											$("#txtNumFactura").val("");
											$("#cmbProveedor option[value=0]").prop("selected", true);
										}
										else {											
											BootstrapDialog.alert({
												title: "Error",
												message: function (dialog) {
													var $mensaje = "<p class='has-error'><strong>No se agregador los siguentes productos</strong><p>";
													$mensaje += "<table><thead><th><b>Nombre</b></th><th><b>Código</b></th></thead><tbody>";
													for (key in res) {
														if (arrayHasOwnIndex(res, key)) {
															$mensaje += "<tr><td>" +  res[key]['producto'] + "<td><td>" + res[key]['codigo'] + "</td></tr>";															
														}
													}
													$mensaje += "</tbody></table>";
													return $mensaje;													
												},
												type: BootstrapDialog.TYPE_DANGER,
												size: BootstrapDialog.SIEZ_SMALL,
												buttons: [
													{
														label: "Aceptar",
														cssClass: "btn-default",
														action: function (dialog) {
															dialog.close();
														}
													}
												]
											});
											table.clear().draw();
										}										
									},
									error: function (jqXHR, textStatus, errorThrown) {
										console.error("Error::" +  errorThrown);
									}							
								});
							}					
						}
					});														
				}
				else {
					BootstrapDialog.alert({
						title: "Factura repetida",
						message: "La factura para el proveedor " + $("#cmbProveedor option:selected").text() + " ya existe.",
						type: BootstrapDialog.TYPE_DANGER,
						size: BootstrapDialog.SIZE_SMALL
					});
				}
			});
		});

		function limpiarFormulario() {
			$("#txtCodigo").val("");
			$("#txtCantidad").val("1");
			$("#txtProductos").val("");			
		}

		$("#txtCodigo").change( function () {
			$.each($("#codigos option"), function (index, value) {
				if ($(value).val().localeCompare($("#txtCodigo").val()) == 0)					
					$("#txtProductos").val($(value).text());
			});
		});

		$("#txtProductos").change( function () {
			$.each($("#productos option"), function (index, value) {
				if ($(value).val().localeCompare($("#txtProductos").val()) == 0)					
					$("#txtCodigo").val($(value).text());
			});
		});

		function arrayHasOwnIndex(array, prop) {
		    return array.hasOwnProperty(prop) && /^0$|^[1-9]\d*$/.test(prop) && prop <= 4294967294; // 2^32 - 2
		}	

		if(Array.prototype.in)
		    console.warn("Overriding existing Array.prototype.in. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");		
		Array.prototype.in = function (array) {
		    for (var i = 0; i < this.length; i++)	        
		        for (var j = 0; j < array.length; j++)
		        	if (this[i] == array[j])
		        		return true;
		    return false;
		}		
		Object.defineProperty(Array.prototype, "in", {enumerable: false});
		
		if(Array.prototype.remove)
		    console.warn("Overriding existing Array.prototype.remove. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");		
		Array.prototype.remove = function (element) {
		    var index = this.indexOf(element);
		    if (index > -1)
		    	this.splice(index, 1);		    
		}		
		Object.defineProperty(Array.prototype, "in", {enumerable: false});

	});	
</script>