<?php
class Reimburse_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('file');
    }

    public function get_reimburse($username = NULL, $year = NULL, $type = NULL, $status = NULL, $like = FALSE)
    {
        if($username != NULL)
        {
            if($like)
            {
                $this->db->like('username', $username);
            }else
            {
                $this->db->where('username', $username);
            }
        }

        if($year != NULL)
        {
            $this->db->like('opTime', $year);
        }

        if($type != NULL)
        {
            $this->db->where('type', $type);
        }

        if($status != NULL)
        {
            $this->db->where('status', $status);
        }

        $this->db->order_by('id', 'DESC');

        $query = $this->db->get('reimburse');
        
        $reimburses = $query->result_array();


        foreach ($reimburses as &$reimburse) {
            $reimburse['type'] = $this->db->get_where('reimburse_type', array('id' => $reimburse['type']))->row_array();
            $reimburse['status'] = $this->db->get_where('status', array('id' => $reimburse['status']))->row_array();
        }

        return $reimburses;

    }

    public function set_reimburse($reimburse)
    {
        return $this->db->insert('reimburse', $reimburse);
    }

    public function delete_reimburse($id)
    {
        return $this->db->query("delete from reimburse where id = $id");
    }

    public function update_reimburse($id, $status)
    {
        return $this->db->query("update reimburse set status=$status where id = $id");
    }
}
?>