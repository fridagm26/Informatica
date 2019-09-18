<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Representa el perfil de administrador.
 * Tiene funciones de redireccion para los perfiles de Almacenista y Administrador.
 */
class CAlumnos extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->Model("Modulos_model");
    }

    public function index(){
        if($this->session->userdata('id_perfil') == '4'){
            $data['modulos'] = $this->Modulos_model->obtenerModulos();
            $this->load->view('Alumnos/inicio', $data);
        }       
        else{
            header('Location: '.base_url().'index.php/cLogin/index');
        }        
    }
}