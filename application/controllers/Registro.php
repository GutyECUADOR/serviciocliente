<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

	public function __constructor() {
		parent::__construct();
    }
    
    public function test() {
        echo 'Controller registro listo';
    }

	public function index(){

		if ($this->session->userdata('logged_in'))
		{ 
			$arrayInscritos = $this->getAllInscritos();
        	$this->load->view('inscripciones', compact('arrayInscritos'));
			
			
		}else{
			redirect('registro/nuevo');
		}
		
	}
	
	public function nuevo(){
		$this->load->view('nuevainscripcion');
	}

	public function detalle(){
		
		if ($this->session->userdata('logged_in'))
		{ 
			$arrayInscritos = $this->getAllInscritos();
        	$this->load->view('detalleinscripcion');
			
			
		}else{
			redirect('registro/nuevo');
		}
		
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

    public function getinscritos(){
		$arrayInscritos = $this->getAllInscritos();
        echo json_encode(array('data' => $arrayInscritos));
    }
	
	public function updateasistencia($status=0){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$this->db->update('inscripciones', array('asistencia'=> $status));
		
		$updated_status = $this->db->affected_rows();
       
		echo json_encode($updated_status);
	}
	
	public function updatepago($pago=0){

		if ($this->session->userdata('logged_in') && $this->session->userdata('role') == 'PAGOS_ROLE' )
		{ 
			$id = $this->input->get('id');
			$this->db->where('id', $id);
			$this->db->update('inscripciones', array('pago'=> $pago));
			
			$rowsaffected = $this->db->affected_rows();
			$response = array(
				'error'     => FALSE, 
				'message'     => 'Actualizacion exitosa', 
				'rowsaffected'  => $rowsaffected
				);
	  
		
			echo json_encode($response);
			
			
		}else{
			$response = array(
				'error'     => TRUE, 
				'message'     => 'Permisos insuficientes, ingrese como cuanta de pagos', 
				'rowsaffected'  => 0
				);
	  
			echo json_encode($response);
		}
		
	}
	
	public function getinscrito($ruc='9999999999999'){
		$this->db->like('nombres', $ruc);
		$this->db->or_like('apellidos', $ruc);
		$query = $this->db->get('inscripciones');
		$resultSet = $query->result_array();
		echo json_encode($resultSet);
    }
    
	function getAllInscritos() {
		
		$query = $this->db->query('SELECT * FROM inscripciones');
		$resultSet = $query->result_array();
		return $resultSet;

	}
	


}
