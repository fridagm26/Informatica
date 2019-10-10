<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->Model("Categorias_modelo");
        $this->load->Model("Modulos_model");
        /* $this->load->helper(array('ayuda_helper','url')); */
    }

    public function index(){
        /* if (validacion()){ */
            /* $data['categorias'] = $this->Categorias_model->obtenerCategorias();  */
            /* $data['modulos'] = modulos(); */       
            $data['modulos'] = $this->Modulos_model->obtenerModulos();   
            $this->load->view('Categorias/categorias',$data);
        /* }  */
    }

    public function formulario($id = ''){
        if (empty($id)) {
            $this->load->view('Categorias/formulario');
        }
        else{
            $resultado['categorias'] = $this->Categorias_modelo->obtenerCategoriasPorId($id);
            $this->load->view('Categorias/formulario', $resultado);
        }  
    }

    /*** P R O C E S O S ***/
    public function obtenerCategoriasPorEstado($estatus){
        $usuarios = $this->Categorias_modelo->obtenerCategoriasPorEstado($estatus);
        echo json_encode($usuarios);
    }

    public function cambiarEstatusCategoria(){
        $id = $this->input->post('id');
        $estado = $this->input->post('estado');
        $usuarios = $this->Categorias_modelo->cambiarEstatusCategoria($id, $estado);
        echo $usuarios;
    }

    public function agregarCategoria(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $descripcion = $this->input->post('txtdescripcion');
            //Validaciones
            $this->form_validation->set_rules('txtdescripcion', 'Descripcion', 'required');
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'id' => '',
                    'descripcion' => $descripcion,
                    'estado' => 1
                );
                $resultado = $this->Categorias_modelo->agregarCategoria($data);
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

    public function editarCategoria(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $descripcion = $this->input->post('txtdescripcion');
            $id = $this->input->post('id');            
            $this->form_validation->set_rules('txtdescripcion', 'Descripcion', 'required');
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'descripcion' => $descripcion,
                );
                $resultado = $this->Categorias_modelo->editarCategoria($id,$data);
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