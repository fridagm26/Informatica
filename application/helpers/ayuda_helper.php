<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 if(!function_exists('informacionInicial')){
     function informacionInicial($titulo){
         $ci =& get_instance();//asignamos a $ci el super objeto de codeigniter//$ci será como $this
         $ci->load->model("Modulos_model");        
         $data['imagen'] = "desarollador.png";
         $data['nombre'] = $ci->session->userdata('perfil')." - ".$ci->session->userdata('nombre');
         $data['icono'] = $ci->Modulos_model->getIcono($titulo);
         $data['titulo'] = $titulo;
         return $data;
     }
 }
 if(!function_exists('validacion')){
     function validacion(){
         $ci =& get_instance();//asignamos a $ci el super objeto de codeigniter//$ci será como $this
         $url = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"],"index.php"));//--TOMO EL URL A QUE SE QUIERE ACCEDER
         $ci->load->Model('Modulos_model');
         if($ci->session->userdata('id_perfil') == true){//-- SI EL 'id_usuario' EXISTE EN LA SESSION QUIERE DECIR QUE SI HUBO ALGUIEN LOGUEADO
             if($ci->Modulos_model->validarPerfil($ci->session->userdata('id_perfil'),$url)==true){//--VALIDA QUE EL PERFIL LOGUEADO LE PERTENECE EL MODULO AL QUE DESEA ACCEDER.
               return true;
             }
             else{
               header('Location: '.base_url().'index.php/Inicio/index');
             }
         }
         else{
           header('Location: '.base_url().'index.php/Inicio/index');
         }
     }
 }
 if(!function_exists('modulos'))
 {
     function modulos()
     {
         $ci =& get_instance();//asignamos a $ci el super objeto de codeigniter//$ci será como $this
         $ci->load->Model('Unidades_modelo');
         return $ci->Modulos_model->obtenerModulosXPerfil($ci->session->userdata('id_perfil'));
     }        
 }
 
 function SendEmail($entidad,$tema,$htmlContent,$msgSuccess,$email,$adjunto=null)
 {
     $ci =& get_instance();//asignamos a $ci el super objeto de codeigniter//$ci será como $this
     $ci->load->library('email');
     $config   =   array(
                   'protocol'  => 'smtp',
                   'smtp_host' => 'ssl://smtp.googlemail.com',
                   'smtp_port' => 465,
                   'smtp_user' => 'almacenUPSIN.pruebas@gmail.com',
                   'smtp_pass' => 'UPSINalmacen',
                   'mailtype'  => 'html',
                   'charset'   => 'utf-8'
                   );
     $ci->email->initialize($config);
     $ci->email->set_mailtype("html");
     $ci->email->set_newline("\r\n");
 
     $ci->email->to($email);
     $ci->email->from('almacenUPSIN.pruebas@gmail.com',$entidad);
     $ci->email->subject($tema);
     $ci->email->message($htmlContent);
     if($adjunto)
     {
       $ci->email->attach($adjunto.'.pdf');
     }
     //$this->load->library('encrypt');
     if($ci->email->send())
       return $msgSuccess;
     else
       return 'No se pudo enviar el correo a la dirección: '.$email;
 }
 
 
 // ----------------------------------------------------------- Envio de correos
 /*
 _____________________________________
                                           INSTRUCCIONES
                             Funcion para enviar correos electrónicos
       SendEmail_all recibe los siguientes parametros:
         $entidad      ->    tipo de dato: string    [nombre del remitente]                      obligatorio
         $tema         ->    tipo de dato: string    [motivo del correo]                         obligatorio
         $htmlContent  ->    tipo de dato: string    [contenido del correo en HTML]              obligatorio
         $msgSuccess   ->    tipo de dato: string    [mensaje de exito para el envio de correo]  obligatorio
         $email        ->    tipo de dato: string    [correo electronico del receptor]           obligatorio
         $adjunto      ->    tipo de dato: string    [ruta y nombre del archivo adjunto (PDF) no se agrega la extención (.pdf)]   opcional
 
         en caso de no adjuntar un archivo se debe enviar un (null) en ese espacio.
         ejemplo:
         //enviar correo con adjunto
 
   $ruta_and_name  = $_SERVER['DOCUMENT_ROOT'].'/rvoe/assets/documentos/oficios/oficio_favorable/oficio_favorable';  
 
   $this->SendEmail_all("Secretario Técnico","saludo","<div>hola</div>","Se ha enviado el correo electronico","user@dominio.com",$ruta_and_name);
 
         //enviar correo sin adjunto
 
   $this->SendEmail_all("Secretario Técnico","saludo","<div>hola</div>","Se ha enviado el correo electronico","user@dominio.com",null);
 //end application/helpers/inicio_helper.php
 */
 
 
 
 // ----------------------------------------------------------- Generador de PDF  
 /*
 ___________________________________________________________________________________________________________
                                           INSTRUCCIONES
                                   Funcion para generar un PDF
       GenerarPDF recibe los siguientes parametros:
         $contenidoPDF ->    tipo de dato: string    [contenido del PDF en HTML]                 obligatorio
         $leterAction  ->    tipo de dato: string    [letra resultado PDF ]                      obligatorio
         $ruta_and_Name->    tipo de dato: string    [ruta y nombre del archivo adjunto (PDF) no se agrega la extención (.pdf)]              obligatorio
         
         ejemplo:
         //Generar un PDF que se descarga automaticamente
 
   $ruta_and_name  = $_SERVER['DOCUMENT_ROOT'].'/rvoe/assets/documentos/oficios/oficio_favorable/oficio_favorable';  
 
   $this->GenerarPDF($contPDF,'F',$ruta_and_name);
 ___________________________________________________________________________________________________________
 */
  function GenerarPDFLogo($contenidoPDF,$leterAction,$ruta_and_Name,$title){
     $ci =& get_instance();//asignamos a $ci el super objeto de codeigniter//$ci será como $this
       $ci->load->library('PdfLogo');
       $pdf = new PdfLogo('P', 'mm', 'A4', true, 'UTF-8', false);
       $pdf->SetCreator(PDF_CREATOR);
       $pdf->SetAuthor('SIAlmacen');
       $pdf->SetTitle($title);
       $pdf->SetSubject('Proyecto especiales');
       $pdf->SetKeywords('Proyecto especiales, UPSIN, SIAlmacen');  
  
 // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config esta carpeta esta en ejemplos buscar ese archivo,en caso solo buscar sin al_alt al final.
         $pdf->SetHeaderData(PDF_HEADER_LOGOSENCILLO, PDF_HEADER_LOGO_WIDTH);
         $pdf->setFooterData();
 // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
         $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
         $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 // se pueden modificar en el archivo tcpdf_config.php de libraries/config
         $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 // se pueden modificar en el archivo tcpdf_config.php de libraries/config
         //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); //-linea original
         $pdf->SetMargins(PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
 
         $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
         $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 // se pueden modificar en el archivo tcpdf_config.php de libraries/config
         $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 //relación utilizada para ajustar la conversión de los píxeles
         $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 // establecer el modo de fuente por defecto
         $pdf->setFontSubsetting(true);
 // Establecer el tipo de letra
 //Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
 // Helvetica para reducir el tamaño del archivo.freemono
         $pdf->SetFont('Helvetica', '', 10, '', true);
 // Añadir una página
 // Este método tiene varias opciones, consulta la documentación para más información.
         $pdf->AddPage();
 // Imprimimos el texto con writeHTMLCell()
       // $params = $pdf->serializeTCPDFtagParameters(array('CODE 39', 'C39', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>true, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
       // $contenidoPDF .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';
       $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $contenidoPDF, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
  
 // ---------------------------------------------------------
 // Cerrar el documento PDF y preparamos la salida
 // Este método tiene varias opciones, consulte la documentación para más información.
         #$nombre_archivo = base_url('/assets/documentos/oficios_secretario_tecnico/'.utf8_decode("oficio_favorable.pdf"));
         $nombre_archivo = $ruta_and_Name.'.pdf';
           ob_end_clean();
         //echo $nombre_archivo; die();
           //i muestra el archivo y la D lo baja 
         $pdf->Output($nombre_archivo, $leterAction);
     }
 //end application/helpers/inicio_helper.php