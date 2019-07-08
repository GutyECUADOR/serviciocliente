<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturas extends CI_Controller {

	public function __constructor() {
		parent::__contructor();
		
	}

	public function index()
	{
		if ($this->session->userdata('logged_in')) {
			$arraybodegas = $this->getbodegas();
			$this->load->view('ticketlist_searchfact', compact('arraybodegas'));
			
		}else{
			$databasesArray = $this->usuario->getAllDataBaseList();
			$this->load->view('login', compact('databasesArray'));
	}
		
	}

	public function getFacturas(){
		$search = $this->input->get('search');
		$dbcode = $this->input->get('dbcode');

		if ($search && $dbcode) {
			$resultSet = $this->usuario->getfacturas($search, $dbcode);
        	echo json_encode(array('ERROR' => FALSE, 'data' => $resultSet));
		}else{
			echo json_encode(array('ERROR' => TRUE, 'data' => ''));
		}
		
	}

	public function getFactura(){
		$VEN_CAB = $this->input->get('ID');
		$dbcode = $this->input->get('dbcode');

		if ($VEN_CAB && $dbcode) {
			
			if ($resultSetCAB = $this->usuario->getfacturaByID($VEN_CAB, $dbcode)) {
				$resultSetMOV = $this->usuario->getfacturaMOVByID($VEN_CAB, $dbcode);
				echo json_encode(array('ERROR' => FALSE, 
									'documento' => $resultSetCAB,
									'movimientos' => $resultSetMOV
									));
			}else {
				echo json_encode(array('ERROR' => TRUE, 'documento' => '', 'message'=>'No se pudo comlpetar la operacion'));
			}
        	
		}else{
			echo json_encode(array('ERROR' => TRUE, 'documento' => '', 'message'=>'Codigo o ID de factura no valido'));
		}
		
	}

	public function getbodegas(){
		$resultSet = $this->usuario->getBodegasByEmpresa();
        return $resultSet;
    }


	
}
