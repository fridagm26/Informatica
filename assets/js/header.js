
/*
var base_url = window.location.origin+'/index.php/';
cambiarTextos();
recargarNotif(-1,-1,-1);
var numNotif = $('.a').length;
$( document ).ready(function() {
    $("#ulDeNoti").on("click",".notif", function(){
        var id = $(this).attr('id');
        recargarNotif(id,-1,1);
        ModalWithInfo(id);
    });

    setInterval(function(){
        recargarNotif(-1,-1,-1);
    }, 1000);

    $("#ulDeNoti").on("click",".ojoN", function(){
        recargarNotif($(this).attr('id'),1,-1);
    });
});

$(".notifiM").on("click", function(){
        var id = $(this).attr('id');
        //recargarNotif(id,-1,1);
        ModalWithInfo(id);
    });
*/
//actualiza las notificaciones de la vista y el header
//cuando se vaya a no se quiere cambiar el estado de ocultar una notificación la variable oculto recibe un -1
/*function recargarNotif(id,oculto,leido){

    var idn = $('.notificacion :nth-child(1)').attr('id');
    $.ajax({
    type: "POST",
    url: base_url+"Header/actualizarNotif",
    data: "idNotif="+id+"&oculto="+oculto+"&leido="+leido,
    cache: false,
    success: function(response)
        {
 
            $("#ulDeNoti").html(response);
            cambiarTextos();
        }
    });
}
*/
//cambiar textos del cuadro de notificaciones en el header
/*function cambiarTextos(){
    var notif = $('.a').length;
    if(notif==0)
    {
        $('#notifCampana').text('');
         $('#liNumNotif').text("No tienes notificaciones recientes pendientes.");
    }
    else if(notif > 10){
        $('#notifCampana').text('+10');
         $('#liNumNotif').text("Tienes +10 notificaciones pendientes.");
    }
    else{
        $('#liNumNotif').text("Tienes "+notif+" notificaciones.");
        $('#notifCampana').text(notif);
    }
}


function ModalWithInfo(idNotificacion)
{
    $.ajax({
        type:"POST",
        url: base_url+'Header/CargarNotModal',
        data:{
        'id' : idNotificacion
        },
        success:function (data){

        var c = JSON.parse(data);
            $.each(c,function(i,item){
                var Div_2 = '';

                item.correo == '-' ? Div_2 : Div_2 = '<div class="form-group col-md-12"><strong>Correo</strong><p>'+item.correo+'</p></div>';; 

                var Div_1 = '<div class="form-group col-md-12"><strong>Nombre</strong><p>'+item.nombre+'</p></div>';
                
                var Div_3 = '<div class="form-group col-md-12" style="width:100%; word-wrap: break-word;"><strong>Descripcion</strong><p>'+item.descripcion+'</p></div>';

                var Full = '<div class="row">'+Div_1+Div_2+Div_3+'</div>';


                BootstrapDialog.show({
            type: BootstrapDialog.TYPE_PRIMARY,
            title: 'Notificación',
            message: $(Full),
                size: BootstrapDialog.SIZE_WIDE,
                tabindex: false,
            buttons: [{
                label: 'Aceptar',
                cssClass: 'btn-success',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
        });
     
            });
        },
        error:function(jqXHR, textStatus, errorThrown){
            alert("Error al guardar la información");
        }
    });   
}*/