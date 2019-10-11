<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CMateriales extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('mMateriales');
        $this->load->model('Modulos_model');
        $this->load->helper(array('ayuda_helper','url'));
    }
    
	public function index(){
        $data['modulos'] = $this->Modulos_model->obtenerModulos();  
        $this->load->view('Materiales/vMateriales', $data);
    }

    public function formularioMateriales($id = ''){
        if (empty($id)) {
            $this->load->view('Materiales/formularioMateriales_vista');
        }
        else{
            $resultado['materiales'] = $this->mMateriales->obtenerMaterialesPorId($id);
            $this->load->view('Materiales/formularioMateriales_vista', $resultado);
        }  
    }

    public function obtenerMaterialesPorEstado($estatus){
        $materiales = $this->mMateriales->obtenerMaterialesPorEstado($estatus);
        echo json_encode($materiales);
    }

    public function cambiarEstatusMaterial(){
        $id = $this->input->post('id');
        $estatus = $this->input->post('estatus');
        $material = $this->mMateriales->cambiarEstatusMaterial($id, $estatus);
        echo $material;
    }

    public function agregarMateriales(){
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("txtDescripcion", "Nombre", "required");
            $this->form_validation->set_rules("txtCantidadExistencia", "Cantidad", "required");
            $this->form_validation->set_rules("cmbCategorias", "Categoria", "required|is_natural_no_zero");
            if ($this->form_validation->run()) 
            {
                $fecha = date("Y-m-d H:i:s");
                $nuevafecha = strtotime('-8 hour', strtotime($fecha)); 
                $data = array(
                    'descripcion' => $this->input->post("txtDescripcion"),
                    'cantidadExistencia' => $this->input->post("txtCantidadExistencia"),
                    'id_usuario' => 5,
                    'fecha_registro' => date("Y-m-d H:i:s",$nuevafecha),
                    'id_categoria' => $this->input->post("cmbCategorias")
                );
                $resultado = $this->mMateriales->agregarMaterial($data);
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

    public function editarMaterial(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $id = $this->input->post('id');         
            $descripcion = $this->input->post('txtDescripcion');
            $cantidadExistencia = $this->input->post('txtCantidadExistencia');
            $idCategoria = $this->input->post('cmbCategorias');
            $this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'required');
            $this->form_validation->set_rules('txtCantidadExistencia', 'Cantidad', 'required');
            $this->form_validation->set_rules("cmbCategorias", "Categoria", "required|is_natural_no_zero");
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'descripcion' => $descripcion,
                    'cantidadExistencia' => $cantidadExistencia,
                    'id_categoria' => $idCategoria
                );
                $resultado = $this->mMateriales->editarMaterial($id,$data);
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

}