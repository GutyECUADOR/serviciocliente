<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {


	private $codeDB;

	public function __constructor() {
		parent::__construct();
    }
    
    public function test() {
        echo 'Controller registro listo';
    }

	public function index(){

		if ($this->session->userdata('logged_in')) { 
				$arraybodegas = $this->getbodegas();
				$this->load->view('ticketlist_view', compact('arraybodegas'));
				
			}else{
				$databasesArray = $this->usuario->getAllDataBaseList();
				$this->load->view('login', compact('databasesArray'));
		}
			
	}
	

	public function register() {
		
		if (!empty($_POST)) {
			
			$empresa = strtoupper($this->input->post('empresa'));
            $bodega = strtoupper($this->input->post('bodega'));
			$facturaID = strtoupper($this->input->post('facturaID'));
			$referencia = $this->input->post('referencia');
			$titulo = $this->input->post('titulo');
			$problema = $this->input->post('txt_problema');
			$solucion = $this->input->post('txt_solucion');
		
            // Checking if everything is there
            if ($bodega && $facturaID && $referencia &&  $titulo && $problema ) {

				$ticket = $this->newticket();
				
                $data = array(
					'codigo' => $ticket,
					'empresa' => $empresa,
					'bodega' => $bodega,
					'facturaID' => $facturaID,
					'encargadoID' => $this->session->userdata('cedula'),
					'fecha' => date('Ymd'),
					'referencia' => $referencia,
					'titulo' => $titulo,
					'problema' => $problema,
					'solucion' => $solucion,
					'estado' => 0
                );
                
                if ($ID = $this->usuario->addticket($data)) {
					
					$response = array(
						'error'     => FALSE, 
						'message'     => 'Registro exitoso. ', 
						'nuevo_id'  => $ID
						);
              
					echo json_encode($response);
				}
				
			}else{
				$response = array('error'=> TRUE, 'message' => 'Lo sentimos, no se han ingresado todos los parametros, reintente');
				echo json_encode($response);
			}
			
        }else{
			$response = array('error'=> TRUE, 'message' => 'Lo sentimos, peticion nula, reintente');
			echo json_encode($response);
		}
        
		
    }

    public function gettickets($search='KAO'){
		$resultSet = $this->usuario->gettickets($search);
	
        echo json_encode(array('data' => $resultSet));
	}

	public function newticket(){
		$resultSet = $this->usuario->generaticket();
		return $resultSet;
	}
	
	
	public function getbodegas(){
		$resultSet = $this->usuario->getBodegasByEmpresa();
        return $resultSet;
    }
	
	public function chengeStatusTicket($status=0){

		$resultSet = $this->usuario->chengeStatusTicket($status);
		
		echo json_encode($resultSet);
			
	}
	
	


}
