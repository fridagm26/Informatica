<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorios extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->Model("Lab_modelo");
        $this->load->Model("Modulos_model");
    }

    public function index(){
        $data['modulos'] = $this->Modulos_model->obtenerModulos();   
        $this->load->view('Laboratorios/laboratorios',$data);
        /* if (validacion()){ */
            /* $data['informacion'] = informacionInicial('Laboratorios'); */
            /* $data['modulos'] = modulos(); */
            /* $data['laboratorios'] = $this->Lab_modelo->mostrarLaboratorios(); */   
            
        /* }  */
    }

    public function formulario($id = ''){
        if (empty($id)) {
            $this->load->view('Laboratorios/formulario');
        }
        else{
            $resultado['laboratorios'] = $this->Lab_modelo->obtenerLaboratoriosPorId($id);
            $this->load->view('Laboratorios/formulario', $resultado);
        }  

    }

    /*** P R O C E S O S ***/
    public function obtenerLaboratoriosPorEstado($estatus){
        $usuarios = $this->Lab_modelo->obtenerLaboratoriosPorEstado($estatus);
        echo json_encode($usuarios);
    }

    public function cambiarEstatusLaboratorio(){
        $id = $this->input->post('id');
        $estado = $this->input->post('estado');
        $usuarios = $this->Lab_modelo->cambiarEstatusLaboratorio($id, $estado);
        echo $usuarios;
    }

    public function agregarLaboratorio(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $nombre = $this->input->post('txtnombre');
            $ubicacion = $this->input->post('txtubicacion');
            $capacidad = $this->input->post('txtcapacidad');
            //Validaciones
            $this->form_validation->set_rules('txtnombre', 'Nombre', 'required');
            $this->form_validation->set_rules('txtubicacion', 'Ubicación', 'required');
            $this->form_validation->set_rules('txtcapacidad', 'Capacidad', 'required');
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'id' => '',
                    'nombre' => $nombre,
                    'ubicacion' => $ubicacion,
                    'capacidad' => $capacidad,
                    'estado' => 1
                );
                $resultado = $this->Lab_modelo->agregarLaboratorio($data);
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

    public function editarLaboratorio(){
        if($this->input->is_ajax_request()){ // solo se puede entrar por ajax 
            $nombre = $this->input->post('txtnombre');
            $ubicacion = $this->input->post('txtubicacion');
            $capacidad = $this->input->post('txtcapacidad');
            $id = $this->input->post('id');            
            $this->form_validation->set_rules('txtnombre', 'Nombre', 'required');
            $this->form_validation->set_rules('txtubicacion', 'Ubicación', 'required');
            $this->form_validation->set_rules('txtcapacidad', 'Capacidad', 'required');
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'nombre' => $nombre,
                    'ubicacion' => $ubicacion,
                    'capacidad' => $capacidad,
                );
                $resultado = $this->Lab_modelo->editarLaboratorio($id,$data);
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