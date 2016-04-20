<?php
class Vocation_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('file');
    }

    public function get_vocation($username = NULL, $year = NULL, $type = NULL, $status = NULL, $like = FALSE)
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
            $this->db->like('startTime', $year);
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

        $query = $this->db->get('vocation');
        
        $vocations = $query->result_array();


        foreach ($vocations as &$vocation) {
            $vocation['type'] = $this->db->get_where('vocation_type', array('id' => $vocation['type']))->row_array();
            $vocation['status'] = $this->db->get_where('status', array('id' => $vocation['status']))->row_array();
        }

        return $vocations;

    }

    public function get_used_by_type($username)
    {   

        $this->db->group_by('type');
        $this->db->select('type');
        $this->db->select_sum('duration');
        $used_days = $this->db->get_where('vocation',array('username' => $username))->result_array();
        //$used_days = $this->db->query("select type,sum(duration) from vocation where username = '$username' group by type")->result_array;
        return $used_days;
    }

    public function set_vocation($vocation)
    {
        // $this->load->helper('url');

        // $data = array(
        //     'username' => $this->input->post('username'),
        //     'passwd' => sha1($this->input->post('passwd')),
        //     'email' => $this->input->post('email')
        // );

        return $this->db->insert('vocation', $vocation);
    }

    public function delete_vocation($id)
    {
        return $this->db->query("delete from vocation where id = $id");
    }

    public function update_vocation($id)
    {
        return $this->db->query("update vocation set status=2 where id = $id");
    }
}
?>