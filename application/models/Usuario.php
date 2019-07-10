<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {
    private $sbio_db;
    private $wssp_db;
    private $empresa_db;

    public function __construct(){
        parent::__construct();
        $this->codeDB = $this->session->userdata('codedatabase');
        $this->sbio_db = $this->load->database('sbio', TRUE);
        $this->wssp_db = $this->load->database('wssp', TRUE);

        if ($this->codeDB) { 
            $this->empresa_db = $this->load->database($this->codeDB, TRUE);
        }else {
            $this->empresa_db = $this->load->database('default', TRUE);
        }
        
    }

    public function addticket($data) {
       
        $this->wssp_db->insert('tickets_serviciocliente', $data);
        return $this->wssp_db->insert_id();
    }

    public function updateTicket($data, $codigo) {
        $this->wssp_db->where('codigo', $codigo);
        $this->wssp_db->update('tickets_serviciocliente', $data);
        return $this->wssp_db->affected_rows();
    }

    public function checklogin($usuario, $password) {
        
        $this->sbio_db->select('Codigo, Nombre, Apellido, Cedula, CodDpto, Clave');
        $this->sbio_db->where('Cedula', $usuario);
        $this->sbio_db->where('Clave', $password);
		$query =  $this->sbio_db->get('Empleados');
		$resultSet = $query->row();
		return $resultSet;
    }

    public function getAllDataBaseList() {
        $this->sbio_db->where_in('Codigo', array('001','002','006','008'));
		$query = $this->sbio_db->get('Empresas_WF');
		$resultSet = $query->result();
		return $resultSet;
    }

    public function getBodegasByEmpresa() {
		$query = $this->empresa_db->get('INV_BODEGAS');
		$resultSet = $query->result_array();
		return $resultSet;
    }

    public function gettickets($search='KAO') {
        $codeempresa = $this->session->userdata('codedatabase');
		$query = $this->empresa_db->query("
			SELECT TOP 100
				VEN_CAB.ID,
				bodega.NOMBRE as nombreBodega,
				cliente.CODIGO as codCliente,
				cliente.RUC as ruc,
				cliente.NOMBRE as nombreCliente,
				ticket.*
			FROM 
				dbo.VEN_CAB
				INNER JOIN dbo.COB_CLIENTES as cliente on cliente.CODIGO = VEN_CAB.CLIENTE
				INNER JOIN dbo.INV_BODEGAS as bodega on bodega.CODIGO = VEN_CAB.BODEGA
				INNER JOIN KAO_wssp.dbo.tickets_serviciocliente as ticket on ticket.facturaID collate Modern_Spanish_CI_AS = VEN_CAB.ID
			WHERE ticket.empresa ='$codeempresa' AND (cliente.NOMBRE LIKE '$search%' or ticket.codigo LIKE '$search%')
            ORDER BY ticket.codigo DESC
            ");
		return $query->result_array();
	
       
    }
    
    public function getfacturaByID($ID, $db_code='008') {
        $this->empresa_db = $this->load->database($db_code, TRUE);
		$query = $this->empresa_db->query("
        SELECT TOP 1
            VEN_CAB.ID,
            VEN_CAB.NUMERO,
            VEN_CAB.FECHA,
            VEN_CAB.CODVEN as codVendedor,
            vendedor.NOMBRE as nombreVendedor,
            VEN_CAB.CLIENTE as codCliente,
            cliente.RUC as RUCCliente,
            cliente.NOMBRE as nombreCliente,
            VEN_CAB.BODEGA as codBodega,
            bodega.NOMBRE as nombreBodega,
            VEN_CAB.TOTAL as totalFactura,
            ticket.codigo as ticket
                        
        FROM 
            dbo.VEN_CAB 
            INNER JOIN dbo.COB_CLIENTES as cliente on cliente.CODIGO = VEN_CAB.CLIENTE
            INNER JOIN dbo.INV_BODEGAS as bodega on bodega.CODIGO = VEN_CAB.BODEGA
            INNER JOIN dbo.COB_VENDEDORES as vendedor on vendedor.CODIGO = VEN_CAB.CODVEN
            LEFT JOIN KAO_wssp.dbo.tickets_serviciocliente as ticket on ticket.facturaID collate Modern_Spanish_CI_AS = VEN_CAB.ID
                        
        WHERE
            VEN_CAB.ID = '$ID'
            ");
		return $query->row();
	
       
    }
    
    public function getTicketByCodigo($codigo) {
        $codeempresa = $this->session->userdata('codedatabase'); //'008'; //
        $this->empresa_db = $this->load->database($codeempresa, TRUE);
        $query = $this->empresa_db->query("
            SELECT TOP 1
                VEN_CAB.ID,
                VEN_CAB.NUMERO,
                VEN_CAB.FECHA,
                VEN_CAB.CODVEN as codVendedor,
                vendedor.NOMBRE as nombreVendedor,
                VEN_CAB.CLIENTE as codCliente,
                cliente.RUC as RUCCliente,
                cliente.NOMBRE as nombreCliente,
                cliente.EMAIL as emailCliente,
                VEN_CAB.BODEGA as codBodega,
                bodega.NOMBRE as nombreBodega,
                VEN_CAB.TOTAL as totalFactura,
                ticket.codigo as ticket,
                ticket.*
                                    
            FROM 
                dbo.VEN_CAB 
                INNER JOIN dbo.COB_CLIENTES as cliente on cliente.CODIGO = VEN_CAB.CLIENTE
                INNER JOIN dbo.INV_BODEGAS as bodega on bodega.CODIGO = VEN_CAB.BODEGA
                INNER JOIN dbo.COB_VENDEDORES as vendedor on vendedor.CODIGO = VEN_CAB.CODVEN
                INNER JOIN KAO_wssp.dbo.tickets_serviciocliente as ticket on ticket.facturaID collate Modern_Spanish_CI_AS = VEN_CAB.ID
                                    
            WHERE
                ticket.codigo = '$codigo'
            ");
    
		return $query->row();
	}

    public function getfacturaMOVByID($ID='', $db_code='008') {
        $this->empresa_db = $this->load->database($db_code, TRUE);
		$query = $this->empresa_db->query("
        SELECT
            producto.Nombre,
            VEN_MOV.*

        FROM 
            dbo.VEN_MOV
            INNER JOIN dbo.INV_ARTICULOS as producto on producto.Codigo = VEN_MOV.CODIGO
        WHERE 
            ID='$ID'
            ");
		return $query->result();
	
       
	}

    public function getfacturas($search='', $db_code='008') {
        $this->empresa_db = $this->load->database($db_code, TRUE);
		$query = $this->empresa_db->query("
        SELECT TOP 100
            VEN_CAB.ID as idFactura,
            VEN_CAB.FECHA as fechaVenta,
            cliente.CODIGO as codCliente,
            cliente.RUC as rucCliente,
            cliente.NOMBRE as nombreCliente,
            articulo.Codigo as codProducto,
            articulo.Nombre as nombreProducto,
            bodega.NOMBRE as nombreBodega
        FROM VEN_MOV
        INNER JOIN dbo.VEN_CAB on VEN_CAB.ID = VEN_MOV.ID
        INNER JOIN dbo.COB_CLIENTES as cliente on cliente.CODIGO = VEN_MOV.CLIENTE
        INNER JOIN dbo.INV_ARTICULOS as articulo on articulo.Codigo = VEN_MOV.CODIGO
        INNER JOIN dbo.INV_BODEGAS as bodega on bodega.CODIGO = VEN_CAB.BODEGA
        
        WHERE cliente.NOMBRE LIKE '$search%' or cliente.RUC = '$search'
        ORDER BY VEN_CAB.FECHA DESC
            ");
		return $query->result_array();
	
       
	}

    public function generaticket() {
        $query = $this->wssp_db->query("SELECT 'KAO'+RIGHT('000000'+ISNULL(CONVERT (Varchar , (SELECT COUNT(*)+1 FROM dbo.tickets_serviciocliente)),''),6) as ticket");
        $resultset = $query->row();
        return $resultset->ticket;
    }

    public function chengeStatusTicket($status=0){

		if ($this->session->userdata('user_role')=='SVC' || $this->session->userdata('user_role')=='ADM') { 
			$id = $this->input->get('id');
			$this->wssp_db->where('codigo', $id);
			$this->wssp_db->update('tickets_serviciocliente', array('estado'=> $status));
			
			$affected_rows = $this->wssp_db->affected_rows();
		   
            return $response = array('error'=> FALSE,
							'message'=> 'Se ha actualizado '.$affected_rows. ' registro(s) correctamente', 
							'affected_rows' => $affected_rows);	
		}else{
            return $response = array('error'=> TRUE,
							'message'=> 'No posee suficientes permisos para realizar esta accion', 
                            'affected_rows' => 0,
                            'role' => $this->session->userdata('user_role')
                        );	
        }
		
	}

}