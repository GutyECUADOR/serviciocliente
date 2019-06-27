<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturas extends CI_Controller {

	public function __constructor() {
		parent::__contructor();
		
	}

	public function index()
	{
		if ($this->session->userdata('logged_in')) { 
			$this->load->view('ticketlist_searchfact');
			
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
			echo json_encode(array('ERROR' => TRUE, 'data' => '', 'info'=> $dbcode, ));
		}
		
	}


	public function getticket(){
		$resultSet = $this->usuario->generaticket();
        echo json_encode($resultSet);
	}

	
}
