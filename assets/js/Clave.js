var ruta_base="";

$(document).ready(function(){   
    ruta_base = window.location.origin+'/index.php/';
});

// -------------------------------------------------------------- recibe la url

$('#btnEnviar_de_la_clave').click(function(){
   $.ajax({
            type:"POST",
            url: ruta_base+'Registro/SendCla',
            data:{
                'clave':              $('#txtclave').val(),
            },
            success:function (data){
                var tipoALERT   =   BootstrapDialog.TYPE_INFO;
                var exito       =   true;
                if(JSON.parse(data)!="Su cuenta ha sido activada exitosamente."){
                    tipoALERT   =   BootstrapDialog.TYPE_DANGER;
                    exito       =   false;
                }
                BootstrapDialog.show({
                    type: tipoALERT,
                    title: '¡ATENCIÓN!',
                    message: $('<div class="text-center"><strong>'+JSON.parse(data)+'</strong></div>'),
                    buttons: [{
                        label: 'Aceptar',
                        cssClass: 'btn btn-info',
                        action: function(dialogItself){
                            dialogItself.close();
                            if(exito)
                                location.replace(window.location.origin);
                        }
                        }]
                });
            },
            error:function(jqXHR, textStatus, errorThrown){
                alert("Error al guardar la información.");
            }
    });
});








