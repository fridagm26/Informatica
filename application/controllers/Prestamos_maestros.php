<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prestamos_maestros extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Modulos_model');
        $this->load->model('Prestamos_maestros_modelo');
        
	}
	public function index(){
        $data['modulos'] = $this->Modulos_model->obtenerModulos();
        $data['prestamos'] = $this->Prestamos_maestros_modelo->mostrarPrestamos();
        $data['materiales'] = $this->Prestamos_maestros_modelo->mostrarMateriales();
        $data['detalle_prestamo'] = $this->Prestamos_maestros_modelo->mostrarDetallesP();
        $data['categorias'] = $this->Prestamos_maestros_modelo->mostrarCategorias();
        /* $this->load->view('prestamos/formularioMaestro',$data); */
        $this->load->view('Profesor/prestamos_maestros',$data);
        }
        public function getEquipoId($id){
        //regresa un valor a la peticion
       echo json_encode($this->Prestamos_maestros_modelo->getEquipoId($id)->result());
        }
        public function agregarPrestamo(){
                $data['fecha_prestamo']=$this->input->post('fechaPrestamo');
                $data['fecha_devolucion']=$this->input->post('fechaDevolucion');
                $data['']=$this->input->post('Categoria');
                $data['']=$this->input->post('fechaDevolucion');
                $data['cantidad']=$this->input->post('Cantidad');
                $idPrestamo = $this->Prestamos_maestros_maestros->agregarPrestamo($data);
                echo json_encode( $this->Prestamos_maestros_maestros->mostrarPrestamo($idPrestamo) );
        }
}    