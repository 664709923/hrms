<?php
class Reimburse_type_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_reimburse_type($id = NULL)
    {
        if($id != NULL)
        {
            $this->db->where('id', $id);
        }

        $query = $this->db->get('reimburse_type');
        return $query->result_array();
    }

}
?>