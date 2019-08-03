<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Perfiles_model');

	}
	public function index()
	{
        $data['perfiles'] = $this->Perfiles_model->mostrarPerfiles();
        $this->load->view('perfiles',$data);
    }

/*     public function mostrarPerfiles(){
        echo json_encode($this->Perfiles_model->mostrarPerfiles());
    } */

    public function agregarPerfil(){
        $data['nombre']=$this->input->post('nombre');
        $data['descripcion']=$this->input->post('descripcion');
        $idPerfil = $this->Perfiles_model->agregarPerfil($data);
        echo json_encode( $this->Perfiles_model->mostrarPerfil($idPerfil) );
    }

    public function modificarPerfil(){
        $data['nombre']=$this->input->post('nombreModificar');
        $data['descripcion']=$this->input->post('descripcionModificar');
        $id=$this->input->post('idPerfil');
        echo json_encode( $this->Perfiles_model->modificarPerfil($data,$id) );
    }

    public function modificarEstado(){
        $id=$this->input->post('idEstado');
        $estado=$this->input->post('estatusPerfil');
        if($estado == 1){
            $num = 0;
            echo json_encode($this->Perfiles_model->modificarEstado($id,$num));
        }
        else{
            $num = 1 ;
            echo json_encode($this->Perfiles_model->modificarEstado($id,$num));
        }
    }
}
