<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class MLogin extends CI_Model {
	
	public function __construct() {

		parent::__construct();
    }
    
    /* public function login($usuario,$contraseña){
		$this->db->select('usuarios.*, perfiles.nombre as perfil');
		$this->db->join('perfiles', 'perfiles.id = usuarios.id_perfil');
		$this->db->where('perfiles.estatus', 1);
		$this->db->where('usuarios.nombre', $usuario);
		$this->db->where('usuarios.estatus', 1);
		$this->db->where('usuarios.contraseña', $contraseña);		
	    $query = $this->db->get('usuarios');
	} */

	public function login($usuario,$contraseña){
		$this->db->select('usuarios.*, perfiles.nombre as perfil');
		$this->db->join('perfiles', 'perfiles.id = usuarios.id_perfil');
		$this->db->where('perfiles.estatus', 1);
		$this->db->where('usuarios.nombre', $usuario);
		$this->db->where('usuarios.estatus', 1);
		$this->db->where('usuarios.contraseña', $contraseña);		
	    $query = $this->db->get('usuarios');
	    if ($query->num_rows() > 0)
	    {
	    	$resultado = $query->row();
	    	/* $this->db->where("idUsuario", $resultado->id);
	    	if ($resultado->perfil_id == 3 || $resultado->perfil_id == 2 || $resultado->perfil_id == 5 || $resultado->perfil_id == 1) {
	    		$res = $this->db->get("empleados")->row();
	    	}
	    	else {
	    		$res = $this->db->get("alumnos")->row();
	    	} */
	    	if($resultado->estatus == 1)
	    	{
	    		$s_usuario = array(
		    		'nombre' => $resultado->nombre,
		    		'id_usuario' => $resultado->id,	    	
		    		'perfil' => $resultado->perfil,
		    		'contraseña' => $resultado->contraseña,
		    		'id_perfil'	=> $resultado->id_perfil
		    	);	    	
		    	$this->session->set_userdata($s_usuario);
			  	return 1;
	    	}
	    	else
	    	{
	    		return 2;
	    	}
	    	
		}
		else 
		{
		  	return 0;
		}
	}
}