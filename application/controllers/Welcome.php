<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __constructor() {
		parent::__contructor();
		$this->load->database();
       
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	function getfactura() {
		
        $query = $this->db->query("SELECT * FROM dbo.VEN_CAB WHERE ID='992014FVE00056894'");
		$resultSet = $query->result_array();
		echo  json_encode($resultSet);

	}

}
