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
				$databasesArray = $this->usuario->getAllDataBaseList();
				$this->load->view('ticketlist_view', compact('arraybodegas','databasesArray'));
				
			}else{
				$databasesArray = $this->usuario->getAllDataBaseList();
				$this->load->view('login', compact('databasesArray'));
		}
			
	}
	

	public function register() {
		
		if (!empty($_POST)) {
			
			$empresa = $this->session->userdata('codedatabase');
            $bodega = strtoupper($this->input->post('bodega'));
			$facturaID = strtoupper($this->input->post('facturaID'));
			$referencia = $this->input->post('referencia');
			$titulo = $this->input->post('titulo');
			$problema = $this->input->post('txt_problema');
			$procedimiento = $this->input->post('txt_procedimiento');
			$autorizado = $this->input->post('txt_autorizado');
			$solucion = $this->input->post('txt_solucion');
			
		
            // Checking if everything is there
            if ($bodega && $facturaID && $referencia &&  $titulo && $problema && $procedimiento ) {

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
					'procedimiento' => $procedimiento,
					'autorizado' => $autorizado,
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
	
	public function update() {
		
		if (!empty($_POST)) {
			
			$procedimiento = $this->input->post('txt_procedimiento');
			$solucion = $this->input->post('txt_solucion');
			$autorizado = $this->input->post('txt_autorizado');
			$ticket = $this->input->post('ticket');
		
            // Checking if everything is there
            if ( $ticket && $procedimiento && $autorizado) {

                $data = array(
					'procedimiento' => $procedimiento,
					'solucion' => $solucion,
					'autorizado' => $autorizado
                );
                
                if ($ID = $this->usuario->updateTicket($data, $ticket)) {
					
					$response = array(
						'error'     => FALSE, 
						'message'     => 'Registro actualizado correctamente. ', 
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
	
	public function sendEmailCliente() {

		$codigo = $this->input->get('ticket'); //Ticket KAO00000X
		$ticketINFO = $this->usuario->getTicketByCodigo($codigo);

		$email = trim($ticketINFO->emailCliente);
		$solucion = trim($ticketINFO->solucion);

		if (empty($email)) {
			$response = array('error' => TRUE, 'message' => 'Email vacio, indique correo valido para enviar notificacion' );
			echo json_encode($response);
			return;
		}

		// Remover luego de modificar los HTML Email
			/* $response = array('error' => TRUE, 'message' => 'Envio de email ha sido negado' );
			echo json_encode($response);
			return; */
		// Fin Remover

        $mail = $this->customemail->load();

        $pcID = php_uname('n'); // Obtiene el nombre del PC
        $correoCliente = $email;

        try {
            //Server settings
            $mail->SMTPDebug = false;                                 // Enable verbose debug output 0->off 2->debug
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.sudcompu.net';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'noreply@kaosportcenter.com';                 // SMTP username
            $mail->Password = 'noreply2019$·';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;  
        
            //Recipients
            $mail->setFrom('noreply@kaosportcenter.com');
            $mail->addAddress($correoCliente);
            $mail->addCC('soporteweb@sudcompu.net');
           
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Notificacion de ticket # '.$codigo;
			$mail->AltBody = 'Notificacion de ticket';
			
			if (!empty($solucion)) {
				$mail->Body    =  $this->load->view('emailTicketSolucionadoHTML', '', true);
			}else {
				$mail->Body    =  $this->load->view('emailNoSolucionTickerHTML', '', true);
			}
           
            
        
            $mail->send();
            $detalleMail = 'Email enviado a : ' . $correoCliente;
            $log  = "User: ".' - '.date("F j, Y, g:i a").PHP_EOL.
                "PCid: ".$pcID.PHP_EOL.
                "Detail: ".$detalleMail.PHP_EOL.
                "-------------------------".PHP_EOL;
                //Save string to log, use FILE_APPEND to append.

                if (!is_dir('logs/')) {
                    // dir doesn't exist, make it
                    mkdir('logs/');
                  }
                file_put_contents('logs/logMailOK.txt', $log, FILE_APPEND );
            
            $response = array('error' => FALSE, 'message' => $detalleMail );
            echo json_encode($response);

        } catch (Exception $e) {
          
            
                $log  = "User: ".' - '.date("F j, Y, g:i a").PHP_EOL.
                "PCid: ".$pcID.PHP_EOL.
                "Detail: ".$mail->ErrorInfo .' No se pudo enviar correo a: ' . $correoCliente . PHP_EOL.
                "-------------------------".PHP_EOL;
                //Save string to log, use FILE_APPEND to append.
                file_put_contents('logs/logMailError.txt', $log, FILE_APPEND);
                $detalleMail = 'Error al enviar el correo. Mailer Error: '. $mail->ErrorInfo;
               
            $response = array('error' => TRUE, 'message' => $detalleMail ); 
            echo json_encode($response);
        }
    }

    public function gettickets($search='KAO'){
		$resultSet = $this->usuario->gettickets($search);
	
        echo json_encode(array('data' => $resultSet));
	}

	public function getticket($codigo){
		$resultSet = $this->usuario->getTicketByCodigo($codigo);
	
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
