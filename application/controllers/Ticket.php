<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {

	public function __constructor() {
		parent::__construct();
    }
    
    public function test() {
        echo 'Controller registro listo';
    }

	public function index(){

		$arraybodegas = $this->getbodegas();

		if ($this->session->userdata('logged_in'))
		{ 
        	$this->load->view('ticketlist_view', compact('arraybodegas'));
			
		}else{
			
			$this->load->view('ticketlist_view', compact('arraybodegas'));
		}
		
	}
	
	public function nuevo(){
		$this->load->view('nuevainscripcion');
	}

	
	public function register() {
		
		if (!empty($_POST)) {
            $bodega = strtoupper($this->input->post('bodega'));
			$facturaID = strtoupper($this->input->post('facturaID'));
			$titulo = $this->input->post('titulo');
            $descripcion = $this->input->post('descripcion');
		
            // Checking if everything is there
            if ($bodega && $facturaID && $titulo && $descripcion ) {
				
				// Loading model
				$this->load->model('usuario');
				
                $data = array(
					'codigo' => 'KAO000004',
					'empresa' => '008',
					'bodega' => $bodega,
					'facturaID' => $facturaID,
					'encargadoID' => '1600505505',
					'fecha' => '2019-06-24',
					'titulo' => $titulo,
					'descripcion' => $descripcion,
					'estado' => 0
                );
                
                if ($ID = $this->usuario->addticket($data)) {
					
					$response = array(
						'error'     => FALSE, 
						'message'     => 'Registro exitoso', 
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
		$query = $this->db->query("
			SELECT TOP 100
				VEN_CAB.ID,
				cliente.CODIGO as codCliente,
				cliente.RUC as ruc,
				cliente.NOMBRE as nombreCliente,
				ticket.*
			FROM 
				dbo.VEN_CAB
			INNER JOIN dbo.COB_CLIENTES as cliente on cliente.CODIGO = VEN_CAB.CLIENTE
			INNER JOIN KAO_wssp.dbo.tickets_serviciocliente as ticket on ticket.facturaID collate Modern_Spanish_CI_AS = VEN_CAB.ID
			WHERE cliente.NOMBRE LIKE '$search%' or ticket.codigo LIKE '$search%'
									");
		$resultSet = $query->result_array();
	
        echo json_encode(array('data' => $resultSet));
	}
	
	public function getbodegas(){
		$query = $this->db->get('INV_BODEGAS');
		$resultSet = $query->result_array();
        return $resultSet;
    }
	
	public function updateasistencia($status=0){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$this->db->update('inscripciones', array('asistencia'=> $status));
		
		$updated_status = $this->db->affected_rows();
       
		echo json_encode($updated_status);
	}
	
	
	public function searchticket($search='KAO'){
		$this->db->like('codigo', $search);
		$this->db->or_like('titulo', $search);
		$query = $this->db->get('tickets_serviciocliente');
		$resultSet = $query->result_array();
		echo json_encode($resultSet);
    }
    


}
