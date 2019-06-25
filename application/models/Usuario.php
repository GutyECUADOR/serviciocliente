<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {
    private $sbio_db;
    private $wssp_db;
    private $empresa_db;

    public function __construct(){
        parent::__construct();
        $this->codeDB = $this->session->userdata('codedatabase');
        $this->sbio_db = $this->load->database('sbio', TRUE);
        $this->wssp_db = $this->load->database('wssp', TRUE);

        if ($this->codeDB) { 
            $this->empresa_db = $this->load->database($this->codeDB, TRUE);
        }else {
            $this->empresa_db = $this->load->database('default', TRUE);
        }
        
    }

    public function addticket($data) {
       
        $this->wssp_db->insert('tickets_serviciocliente', $data);
        return $this->wssp_db->insert_id();
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
		$query = $this->sbio_db->get('Empresas_WF');
		$resultSet = $query->result();
		return $resultSet;
    }

    public function getBodegasByEmpresa() {
		$query = $this->empresa_db->get('INV_BODEGAS');
		$resultSet = $query->result_array();
		return $resultSet;
    }

    public function gettickets($search='KAO'){
        $codeempresa = $this->session->userdata('codedatabase');
		$query = $this->empresa_db->query("
			SELECT TOP 100
				VEN_CAB.ID,
				bodega.NOMBRE as nombreBodega,
				cliente.CODIGO as codCliente,
				cliente.RUC as ruc,
				cliente.NOMBRE as nombreCliente,
				ticket.*
			FROM 
				dbo.VEN_CAB
				INNER JOIN dbo.COB_CLIENTES as cliente on cliente.CODIGO = VEN_CAB.CLIENTE
				INNER JOIN dbo.INV_BODEGAS as bodega on bodega.CODIGO = VEN_CAB.BODEGA
				INNER JOIN KAO_wssp.dbo.tickets_serviciocliente as ticket on ticket.facturaID collate Modern_Spanish_CI_AS = VEN_CAB.ID
			WHERE ticket.empresa ='$codeempresa' AND (cliente.NOMBRE LIKE '$search%' or ticket.codigo LIKE '$search%')
            
            ");
		return $query->result_array();
	
       
	}


}