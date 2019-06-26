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

	public function getFacturas($search=''){
		$resultSet = $this->usuario->getfacturas($search);
	
        echo json_encode(array('data' => $resultSet));
	}

	
}
