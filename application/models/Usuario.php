<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function addticket($data) {
        $wssp_db = $this->load->database('wssp', TRUE);
        // Inserting into your table
        $wssp_db->insert('tickets_serviciocliente', $data);
        // Return the id of inserted row
        return $idOfInsertedData = $wssp_db->insert_id();
    }


}