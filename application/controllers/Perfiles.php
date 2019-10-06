<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->Model("Perfiles_modelo");
        $this->load->Model("Modulos_model");
        // $this->load->helper(array('ayuda_helper','url'));
    }

    // ======================================================================================================================
    //          P E R F I L E S
    // ======================================================================================================================
    /*** V I S T A S ***/
    public function index(){
        $data['modulos']=$this->Modulos_model->obtenerModulos();
        $this->load->view('Perfiles/perfil_vista', $data);
        // if (validacion()){
        //     $data['informacion'] = informacionInicial('Perfiles');
        //     $data['modulos'] = modulos();
        //     $this->load->view('Perfiles/perfil_vista',$data);
        // }
    }

   // Vista del modal cargado para asignar o eliminar modulos 
    public function agregarModulos_modal($id_perfil){
        $data['id_perfil'] = $id_perfil;
        $data['modulosx'] = $this->Modulos_model->modulosXPerfil($id_perfil);
        $this->load->view('Perfiles/listado_modulos',$data);
    }

    public function formularioPerfiles($id = ''){
        if (empty($id)) {
            $this->load->view('Perfiles/formularioPerfiles_vista');
        }
        else{
            $resultado['perfiles'] = $this->Perfiles_modelo->obtenerPerfilesPorId($id);
            $this->load->view('Perfiles/formularioPerfiles_vista', $resultado);
        }  
    }

    /*** P R O C E S O S ***/
    public function obtenerPerfilesPorEstado($estatus){
        $usuarios = $this->Perfiles_modelo->obtenerPerfilesPorEstado($estatus);
        echo json_encode($usuarios);
    }

    public function cambiarEstatusPerfil(){
        $id = $this->input->post('id');
        $estatus = $this->input->post('estatus');
        $usuarios = $this->Perfiles_modelo->cambiarEstatusPerfil($id, $estatus);
        echo $usuarios;
    }

    public function agregarPerfil(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $nombre = $this->input->post('txtnombre');
            $descripcion = $this->input->post('txtdescripcion');
            //Validaciones
            $this->form_validation->set_rules('txtnombre', 'Nombre', 'required');
            $this->form_validation->set_rules('txtdescripcion', 'Descripción', 'required');
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'id' => '',
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'estatus' => 1
                );
                $resultado = $this->Perfiles_modelo->agregarPerfil($data);
                echo $resultado;
            }
            else{
                echo validation_errors('<li>', '</li>');
            }
        }
        else{
            show_404();
        }
    }

    public function editarPerfil(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $nombre = $this->input->post('txtnombre');
            $descripcion = $this->input->post('txtdescripcion');
            $id = $this->input->post('id');            
            $this->form_validation->set_rules('txtnombre', 'Nombre', 'required');
            $this->form_validation->set_rules('txtdescripcion', 'Descripción', 'required');
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                );
                $resultado = $this->Perfiles_modelo->editarPerfil($id,$data);
                echo $resultado;
            }
            else{
                echo validation_errors('<li>', '</li>');
            }
        }
        else{
            show_404();
        }
    }

    public function asignarModuloPerfil(){
        if($this->input->is_ajax_request()) {
            $id_perfil = $this->input->post("id_perfil"); 
            $id_modulo = $this->input->post("id_modulo"); 
            $datos = array(
                'id_perfil'      => $id_perfil,
                'id_modulo'      => $id_modulo
            );
            echo $this->Perfiles_modelo->agregarModulo($datos);
        }
        else {
            show_404();
        }
    }

    public function eliminarModuloPerfil(){
        if ($this->input->is_ajax_request()) {
            $idPerfil = $this->input->post("id_perfil"); 
            $idModulo = $this->input->post("id_modulo"); 
            echo $this->Perfiles_modelo->eliminarModulo($idPerfil, $idModulo);
        }
        else{
            show_404();
        }
    }
}