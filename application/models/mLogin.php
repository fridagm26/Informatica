<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class MLogin extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function ingresar($usu,$contra){
        $this->db->select('u.id, u.nombre, u.contraseña, u.fecha_registro, p.nombre, p.descripcion');
        $this->db->from('usuarios u');
        $this->db->join('perfiles p', 'p.id = u.id_perfil');
        $this->db->where('u.nombre',$usu);
        $this->db->where('u.contraseña',$contra);

        $resultado = $this->db->get();
        
        if ($resultado->num_rows() == 1) {
            $r = $resultado->row();

            $s_usuario = array(
                's_id' => $r->id,
                's_usuario' => $r->nombre
            );

           $this->session->set_userdata("DatosUsuarios",$s_usuario);
           /**Este es una variable que contiene los datos de session */
           //var_dump($this->session->userdata("DatosUsuarios"));

            return 1;
        } else {
            return 0;
        }
    }

	
}