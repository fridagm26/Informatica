<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CMateriales extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('mMateriales');
        $this->load->model('Modulos_model');

	}
	public function index(){
        $data['modulos'] = $this->Modulos_model->obtenerModulos();
        $data['result'] = $this->mMateriales->getMateriales();
        $data['categorias'] = $this->mMateriales->getCategorias();    
        $this->load->view('vMateriales', $data);
    }
    
    public function altaMateriales(){
        $this->mMateriales->agregarMaterial();
    }

    public function modificarEstado(){
        $id=$this->input->post('idEstado');
        $estado=$this->input->post('estatusMaterial');
        if($estado == 1){
            $num = 0;
            echo json_encode($this->mMateriales->modificarEstado($id,$num));
            redirect('cMateriales');
        }
        else{
            $num = 1 ;
            echo json_encode($this->mMateriales->modificarEstado($id,$num));
            redirect('cMateriales');
        }
    }

    public function modificarMaterial(){
        $data['descripcion']=$this->input->post('descripcion');
        $data['cantidadExistencia']=$this->input->post('cantidadExistencia');
        $data['slctCategoria']=$this->input->post('slctCategoria');
        $id=$this->input->post('id_material');
        echo json_encode( $this->mMateriales->modificarMaterial($data,$id) );
    }

}