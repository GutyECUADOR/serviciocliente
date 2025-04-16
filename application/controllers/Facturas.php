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
			$databasesArray = $this->usuario->getAllDataBaseList();
			$this->load->view('ticketlist_searchfact', compact('databasesArray','arraybodegas'));
			
		}else{
			$databasesArray = $this->usuario->getAllDataBaseList();
			$this->load->view('login', compact('databasesArray'));
	}
		
	}

	public function getFacturas(){
		$search = $this->input->get('search');
		$resultSet = $this->usuario->getfacturas($search);
		if ($resultSet) {
			echo json_encode(array('ERROR' => FALSE, 'data' => $resultSet));
		}else{
			echo json_encode(array('ERROR' => TRUE, 'data' => ''));
		}
		
	}

	public function getFactura(){
		$VEN_CAB = $this->input->get('ID');
		$resultSetCAB = $this->usuario->getfacturaByID($VEN_CAB);
		$resultSetMOV = $this->usuario->getfacturaMOVByID($VEN_CAB);
		
		$response = array('documento' => $resultSetCAB,
					'movimientos' => $resultSetMOV
					);
			
        echo json_encode($response);
		
	}

	public function getbodegas(){
		$resultSet = $this->usuario->getBodegasByEmpresa();
        return $resultSet;
    }


	
}
