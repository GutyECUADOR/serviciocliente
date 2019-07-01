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
			$titulo = $this->input->post('titulo');
			$problema = $this->input->post('txt_problema');
			$solucion = $this->input->post('txt_solucion');
		
            // Checking if everything is there
            if ($bodega && $facturaID && $titulo && $problema && $solucion ) {
				
                $data = array(
					'codigo' => 'KAO000001',
					'empresa' => $empresa,
					'bodega' => $bodega,
					'facturaID' => $facturaID,
					'encargadoID' => $this->session->userdata('cedula'),
					'fecha' => date('Ymd'),
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
	
	
	public function getbodegas(){
		$resultSet = $this->usuario->getBodegasByEmpresa();
        return $resultSet;
    }
	
	public function chengeStatusTicket($status=0){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$this->db->update('inscripciones', array('asistencia'=> $status));
		
		$updated_status = $this->db->affected_rows();
       
		echo json_encode($updated_status);
	}
	
	


}
