<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Modulos_model');
        $this->load->model('Categorias_modelo');

	}
	public function index()
	{
        $data['modulos'] = $this->Modulos_model->obtenerModulos();
        $data['categorias'] = $this->Categorias_modelo->mostrarCategorias();
        $this->load->view('categorias',$data);
    }

    public function agregarCategoria(){
        $data['descripcion']=$this->input->post('descripcion');
        $idCategoria = $this->Categoria_modelo->agregarCategoria($data);
        echo json_encode( $this->Categoria_modelo->mostrarCategoria($idCategoria) );
    }

    public function modificarCategoria(){
        $data['descripcion']=$this->input->post('descripcionModificar');
        $id=$this->input->post('idCategoria');
        echo json_encode( $this->Categoria_modelo->modificarCategoria($data,$id) );


    }

    public function modificarEstado(){
        $id=$this->input->post('idEstado');
        $estado=$this->input->post('estatusCategoria');
        if($estado == 1){
            $num = 0;
            echo json_encode($this->Categoria_modelo->modificarEstado($id,$num));
        }
        else{
            $num = 1 ;
            echo json_encode($this->Categoria_modelo->modificarEstado($id,$num));
        }
    }
}
