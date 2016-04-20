<?php
class Vocation_type_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_vocation_type($id = NULL)
    {
        if($id != NULL)
        {
            $this->db->where('id', $id);
        }

        $query = $this->db->get('vocation_type');
        return $query->result_array();
    }

}
?>