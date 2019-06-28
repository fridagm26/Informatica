<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Perfiles_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
        $this->load->database();
	}

    //ACABA VAN LAS FUNCIONES
    public function mostrarPerfiles(){
        return $this->db->get('perfiles')->result();
    }

    public function agregarPerfil($data){
        $perfil=array(
            'nombre'=>$data['nombre'],
            'descripcion'=>$data['descripcion']
        );
        $this->db->insert('perfiles',$perfil);
        return $this->db->insert_id();
    }

    public function modificarPerfil($data,$id){
        $perfil=array(
            'nombre'=>$data['nombre'],
            'descripcion'=>$data['descripcion']
        );
        $this->db->where('id',$id)->update('perfiles',$perfil);
        return $this->db->affected_rows();
    }

    public function mostrarPerfil($idPerfil){
        return $this->db->where('id',$idPerfil)->get('perfiles')->row();
    }

    public function modificarEstado($id,$num){
        $estado= array('estatus'=>$num);
        $this->db->where('id',$id)->update('perfiles',$estado);
        return $this->db->affected_rows();
    }
    
}