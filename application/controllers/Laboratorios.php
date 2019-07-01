<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorios extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Modulos_model');
        $this->load->model('Lab_modelo');

	}
	public function index()
	{
        $data['modulos'] = $this->Modulos_model->obtenerModulos();
        $data['laboratorios'] = $this->Lab_modelo->mostrarLaboratorios();
        $this->load->view('laboratorios',$data);
    }

    public function agregarLaboratorio(){
        $data['descripcion']=$this->input->post('descripcion');
        $data['ubicacion']=$this->input->post('ubicacion');
        $data['capacidad']=$this->input->post('capacidad');
        $idLaboratorio = $this->Lab_modelo->agregarLaboratorio($data);
        echo json_encode( $this->Lab_modelo->mostrarLaboratorio($idLaboratorio) );
    }

    public function modificarLaboratorio(){
        $data['descripcion']=$this->input->post('descripcionModificar');
        $data['ubicacion']=$this->input->post('ubicacionModificar');
        $data['capacidad']=$this->input->post('capacidadModificar');
        $id=$this->input->post('idLaboratorio');
        echo json_encode( $this->Lab_modelo->modificarLaboratorio($data,$id) );


    }

    public function modificarEstado(){
        $id=$this->input->post('idEstado');
        $estado=$this->input->post('estatusLaboratorio');
        if($estado == 1){
            $num = 0;
            echo json_encode($this->Lab_modelo->modificarEstado($id,$num));
        }
        else{
            $num = 1 ;
            echo json_encode($this->Lab_modelo->modificarEstado($id,$num));
        }
    }
}
