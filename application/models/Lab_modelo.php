<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Lab_modelo extends CI_Model {
	
	public function __construct() {
        parent::__construct();
        $this->load->database();
	}

    //ACABA VAN LAS FUNCIONES
    public function mostrarLaboratorios(){
        return $this->db->get('laboratorios')->result();
    }

    public function agregarLaboratorio($data){
        $laboratorio=array(
            'descripcion'=>$data['descripcion'],
            'ubicacion'=>$data['ubicacion'],
            'capacidad'=>$data['capacidad']
        );
        $this->db->insert('laboratorios',$laboratorio);
        return $this->db->insert_id();
    }

    public function modificarLaboratorio($data,$id){
        $laboratorio=array(
            'descripcion'=>$data['descripcion'],
            'ubicacion'=>$data['ubicacion'],
            'capacidad'=>$data['capacidad']
        );
        $this->db->where('id',$id)->update('laboratorios',$laboratorio);
        return $this->db->affected_rows();
    }

    public function mostrarLaboratorio($idLaboratorio){
        return $this->db->where('id',$idLaboratorio)->get('laboratorios')->row();
    }

    public function modificarEstado($id,$num){
        $estado= array('estado'=>$num);
        $this->db->where('id',$id)->update('laboratorios',$estado);
        return $this->db->affected_rows();
    }
    
}