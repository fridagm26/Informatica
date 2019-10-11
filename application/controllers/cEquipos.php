<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CEquipos extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('mEquipos');
        $this->load->model('Modulos_model');
        $this->load->helper(array('ayuda_helper','url'));
    }
    
	public function index(){
        $data['modulos'] = $this->Modulos_model->obtenerModulos();  
        $this->load->view('Equipos/vEquipos', $data);
    }

    public function formularioEquipos($id = ''){
        if (empty($id)) {
            $this->load->view('Equipos/formularioEquipos_vista');
        }
        else{
            $resultado['equipos'] = $this->mEquipos->obtenerEquiposPorId($id);
            $this->load->view('Equipos/formularioEquipos_vista', $resultado);
        }  
    }

    public function obtenerEquiposPorEstado($estatus){
        $equipos = $this->mEquipos->obtenerEquiposPorEstado($estatus);
        echo json_encode($equipos);
    }

    public function cambiarEstatusEquipo(){
        $id = $this->input->post('id');
        $estatus = $this->input->post('estatus');
        $equipo = $this->mEquipos->cambiarEstatusEquipo($id, $estatus);
        echo $equipo;
    }

    public function agregarEquipo(){
        if ($this->input->is_ajax_request())
        {    
            $descripcion = $this->input->post('txtDescripcion');
            $numInventario = $this->input->post('txtNumInv');
            $serie = $this->input->post('txtSerie');
            $resguardo = $this->input->post('txtResguardo');
            $idCategoria = $this->input->post('cmbCategorias');
            $this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'required');
            $this->form_validation->set_rules('txtNumInv', 'Numero de Inventario', 'required');
            $this->form_validation->set_rules('txtSerie', 'Serie', 'required');
            $this->form_validation->set_rules('txtResguardo', 'Resguardo', 'required');
            $this->form_validation->set_rules("cmbCategorias", "Categoria", "required|is_natural_no_zero");
            if ($this->form_validation->run()) 
            {
                $fecha = date("Y-m-d H:i:s");
                $nuevafecha = strtotime('-8 hour', strtotime($fecha)); 
                $data = array(
                    'descripcion' => $descripcion,
                    'numInventario' => $numInventario,
                    'serie' => $serie,
                    'resguardo' => $resguardo,
                    'id_usuario' => 5,
                    'fecha_registro' => date("Y-m-d H:i:s",$nuevafecha),
                    'id_categoria' => $this->input->post("cmbCategorias")
                );
                $resultado = $this->mEquipos->agregarEquipo($data);
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

    public function editarEquipo(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $id = $this->input->post('id');         
            $descripcion = $this->input->post('txtDescripcion');
            $numInventario = $this->input->post('txtNumInv');
            $serie = $this->input->post('txtSerie');
            $resguardo = $this->input->post('txtResguardo');
            $idCategoria = $this->input->post('cmbCategorias');
            $this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'required');
            $this->form_validation->set_rules('txtNumInv', 'Numero de Inventario', 'required');
            $this->form_validation->set_rules('txtSerie', 'Serie', 'required');
            $this->form_validation->set_rules('txtResguardo', 'Resguardo', 'required');
            $this->form_validation->set_rules("cmbCategorias", "Categoria", "required|is_natural_no_zero");
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'descripcion' => $descripcion,
                    'numInventario' => $numInventario,
                    'serie' => $serie,
                    'resguardo' => $resguardo,
                    'id_categoria' => $idCategoria
                );
                $resultado = $this->mEquipos->editarEquipo($id,$data);
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