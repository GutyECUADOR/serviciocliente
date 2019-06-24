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
		$response = array('error'=> TRUE, 'message' => 'Lo sentimos, no hemos podido completar tu registro, reintente mas tarde');

		if (!empty($_POST)) {
            $nombres = strtoupper($this->input->post('nombres'));
			$apellidos = strtoupper($this->input->post('apellidos'));
			$telefono = $this->input->post('telefono');
            $celular = $this->input->post('celular');
			$email = $this->input->post('email');

			$tipoinstitucion = strtoupper($this->input->post('tipoinstitucion'));
			$nombreinstitucion = strtoupper($this->input->post('nombreinstitucion'));
			$cargo = strtoupper($this->input->post('cargo'));
			
			$ruc = $this->input->post('ruc');
			$formapago = $this->input->post('formapago');
			$fechamaxima = $this->input->post('fechamaxima');
			$contactoconta = $this->input->post('contactoconta');
			$emailconta = $this->input->post('emailconta');
			$reemplazo = $this->input->post('reemplazo');

			$observaciones = $this->input->post('observaciones');

			
            // Checking if everything is there
            if ($nombres && $apellidos && $celular && $email ) {
				
				// Loading model
				$this->load->model('usuario');
				
                $data = array(
					'titulo' => null,
					'nombres' => $nombres,
					'apellidos' => $apellidos,
					'cargo' => $cargo,
					'telefono' => $telefono,
					'celular' => $celular,
					'correo' => $email,
					'tipoinstitucion' => $tipoinstitucion,
					'nombreinstitucion' => $nombreinstitucion,
					'estado' => 'PENDIENTE PAGO',
					'ruc' => $ruc,
					'direccion' => '',
					'formapago' => $formapago,
					'fechamaxima' => $fechamaxima,
					'contactoconta' => $contactoconta,
					'emailconta' => $emailconta,
					'reemplazo' => $reemplazo,
					'observaciones' => $observaciones,
					'asistencia' => '0',
					'pago' => '0',
                );
                
                if ($ID = $this->usuario->addinscripcion($data)) {
					
					$response = array(
						'error'     => FALSE, 
						'message'     => 'Registro exitoso, Bienvenido '.$nombres, 
						'nuevo_id'  => $ID
						);
              
					
				}
				
			}
			
        }
        
		echo json_encode($response);
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
