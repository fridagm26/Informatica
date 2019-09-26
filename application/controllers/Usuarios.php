<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->Model('Usuarios_modelo');
        $this->load->Model('Perfiles_model');
        
    }
    // ======================================================================================================================
    //          USUARIOS
    // ======================================================================================================================
    /*** V I S T A S ***/
    public function index(){
        $this->load->view('Administrador/usuarios_vista');
       /*  if (validacion()){
            $data['informacion'] = informacionInicial('Usuarios');
            $data['modulos'] = modulos();
            $this->load->view('Administrador/usuarios_vista', $data);
        } */
    }
    public function formularioUsuarios($id = ''){
        $data['perfiles'] = $this->Perfiles_modelo->obtenerPerfilesPorEstado(1);
        if (empty($id)) {
            $this->load->view('Administrador/formularioUsuarios_vista',$data);
        }
        else{
            $resultado['usuarios'] = $this->Usuarios_modelo->obtenerUsuariosEditar($id);
            $this->load->view('Administrador/formularioUsuarios_vista', $resultado);
        }
    }
    /*** P R O C E S O S ***/
    public function obtenerUsuarios($estado){
        if($this->input->is_ajax_request()){
            $resultado = $this->Usuarios_modelo->obtenerUsuarios($estado);
            echo json_encode($resultado);
        }
        else{
            show_404();
        }
    }
    public function agregarUsuarios(){
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("txtusuario", "Usuario", "trim|required|is_unique[usuarios.nombre_usuario]");
            $this->form_validation->set_rules("txtcontraseña", "Contraseña", "trim|required");
            $this->form_validation->set_rules("txtconfirmcontraseña", "Confirmación Contraseña", "required|matches[txtcontraseña]");
            $this->form_validation->set_rules("cmbPerfiles", "Perfil", "required|is_natural_no_zero");
            if ($this->form_validation->run()) 
            {
                $fecha = date("Y-m-d H:i:s");
                $nuevafecha = strtotime('+16 hour', strtotime($fecha)); // +16 para aumentar las horas al reloj del servidor
                $perfil_id = $this->input->post("cmbPerfiles");
                //$contra = rand(10000,99999);  Contraseña de manera aleatoria
                if (!$this->Perfiles_modelo->obtenerPerfilesPorEstado($perfil_id))
                    return 2;
                $data = array(
                    'nombre_usuario' => $this->input->post("txtusuario"),
                    'contraseña'=> md5($this->input->post("txtcontraseña")),
                    'perfil_id'=> $perfil_id, 
                    'registro'=> date("Y-m-d H:i:s",$nuevafecha),
                    'estatus' => 1
                );
                $resultado = $this->Usuarios_modelo->agregarUsuarios($data);
                echo $resultado;
            }
            else
                echo validation_errors("<li>", "</li>");
        }
        else
        {
            show_404();
        }
    }
    public function cambiarEstatusUsuarios(){
        $id = $this->input->post('id');
        $estatus = $this->input->post('estatus');
        $resultado = $this->Usuarios_modelo->cambiarEstatusUsuarios($id, $estatus);
        echo $resultado;
    }
}