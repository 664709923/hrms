<?php
class Status_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_status($id = NULL)
    {
        if($id != NULL)
        {
            $this->db->where('id', $id);
        }

        $query = $this->db->get('status');
        return $query->result_array();
    }

}
?>