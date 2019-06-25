<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {
    private $sbio_db;

    public function __construct(){
        parent::__construct();
        $this->sbio_db = $this->load->database('sbio', TRUE);
    }

    public function addticket($data) {
        $wssp_db = $this->load->database('wssp', TRUE);
        $wssp_db->insert('tickets_serviciocliente', $data);
        return $wssp_db->insert_id();
    }

    public function checklogin($usuario, $password) {
        
        $this->sbio_db->select('Codigo, Nombre, Apellido, Cedula, CodDpto, Clave');
        $this->sbio_db->where('Cedula', $usuario);
        $this->sbio_db->where('Clave', $password);
		$query =  $this->sbio_db->get('Empleados');
		$resultSet = $query->row();
		return $resultSet;
    }

    public function getAllDataBaseList() {
		$query =  $this->sbio_db->get('Empresas_WF');
		$resultSet = $query->result();
		return $resultSet;
    }


}