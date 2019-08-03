<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class MMateriales extends CI_Model {
	
	public function __construct() {
		parent::__construct();
    }
    
    public function getCategorias(){
        $categorias = $this->db->select('*')->from('categorias')->where('estado',1)->get();
        return $categorias;
   }


   /* public function agregar($parametro){
        $campos = array(
            'descripcion' => $parametro['descripcion'],
            'cantidadExistencia' => $parametro['cantidadExistencia'],
            'id_usuario' => $parametro['id_usuario'],
            'id_categoria' => $parametro['id_categoria']
        );

        $this->db->insert('materiales', $campos);
        redirect('cMateriales', 'refresh');
    }  */  

    /* public function dataMateriales(){
        $data = array(
            'descripcion' => $this->input->post('descripcion'),
            'cantidadExistencia' => $this->input->post('cantidadExistencia'),
            'id_usuario' => 5,
            'id_categoria' => $this->input->post('slctCategoria'),
        );
        $this->db->insert('materiales', $data);
    } */

    public function agregarMaterial(){
        if(isset($_POST['descripcion'])){
            $descripcion = $_POST['descripcion'];
            $cantidadExistencia = $_POST['cantidadExistencia'];
            $categoria = $_POST['categoria'];
            echo "$descripcion $cantidadExistencia $categoria";
            $this->db->query('INSERT INTO materiales(descripcion, cantidadExistencia, id_categoria, id_usuario) 
            VALUES ('.$descripcion.', '.$cantidadExistencia.', '.$categoria.' 5)')->result();
        }
    }

    public function getMateriales(){
        $query = $this->db->query('SELECT * FROM materiales');
        return $query->result();
    }	

    public function modificarEstado($id,$num){
        $estado= array('estado'=>$num);
        $this->db->where('id',$id)->update('materiales',$estado);
        return $this->db->affected_rows();
    }

    public function modificarMaterial($data,$id){
        $material=array(
            'descripcion'=>$data['descripcion'],
            'cantidadExistencia'=>$data['cantidadExistencia'],
            'id_categoria'=>$data['slctCategoria']
        );
        $this->db->where('id',$id)->update('materiales',$material);
        return $this->db->affected_rows();
    }


}