<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_user($username = NULL, $passwd = NULL)
    {
        if ($username == NULL)
        {
            $query = $this->db->get('user');
            return $query->result_array();
        }

        if ($passwd == NULL)
        {
            $query = $this->db->get_where('user', array('username' => $username, ));
        }
        else
        {
            $query = $this->db->get_where('user', array('username' => $username, 'passwd' => sha1($passwd)));
        }
        return $query->row_array();
    }

    public function add_user($user)
    {
        // $this->load->helper('url');

        // $data = array(
        //     'username' => $this->input->post('username'),
        //     'passwd' => sha1($this->input->post('passwd')),
        //     'email' => $this->input->post('email')
        // );

        return $this->db->insert('user', $user);
    }

    public function update_user($user)
    {
        $this->db->where('id', $user['id']);
        $this->db->update('user', $user);
    }
}
