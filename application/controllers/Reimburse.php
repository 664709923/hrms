<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reimburse extends CI_Controller{

	public function __construct()
    {
        parent::__construct();
        //before use session, we need load library('session') first
        $this->load->library('session');

        //we may use reimburse_model in the following functions
        $this->load->model('reimburse_model');
        $this->load->model('reimburse_type_model');

        //help to generate the url
        $this->load->helper('url_helper');

        //
        $this->load->helper('form');

        //validate the form
        $this->load->library('form_validation');
    }


    public function delete()
    {
        $user = $this->session->login_user;
        if($user == NULL)
        {
            redirect('user/login');
        }
        
        $id = $this->input->post('id');
    	if($id != NULL)
    	{
    		$this->reimburse_model->delete_reimburse($id);
    	}

    	$username = $user['username'];
		$year = $_REQUEST['year'];
        $type = $_REQUEST['type'];
		$status = $_REQUEST['status'];

		$data['reimburses'] = $this->reimburse_model->get_reimburse($username, $year, $type, $status);
		
		$this->load->view('templates/header',$data);
        $this->load->view('reimburse/main', $data);
        $this->load->view('templates/footer');
    }

    public function accept()
    {
        $user = $this->session->login_user;
        if($user == NULL)
        {
            redirect('user/login');
        }

        $id = $this->input->post('id');
        if($id != NULL)
        {
            $this->reimburse_model->update_reimburse($id, 2);
        }

        $username = $this->input->post('username');
        $year = $this->input->post('year');
        $type = $this->input->post('type');
        $status = $this->input->post('status');

        $data['reimburses'] = $this->reimburse_model->get_reimburse($username, $year, $type, $status);
        
        $this->load->view('templates/header',$data);
        $this->load->view('reimburse/admin', $data);
        $this->load->view('templates/footer');
    }

    public function apply()
    {
    	$user = $this->session->login_user;
		if($user == NULL)
		{
			redirect('user/login');
		}

		$data['title'] = 'Apply reimburse';
		$data['error'] = '';

        $worknumber = $this->session->login_user['worknumber'];
        $username = $this->session->login_user['username'];
	    $desp = $this->input->post('desp');
        $opTime = $this->input->post('opTime');
        $amount = $this->input->post('amount');
        $type = $this->input->post('type');

        $status = 1; //默认为：已提交

		$this->form_validation->set_rules('amount', '金额', 'required|integer');

		if ($this->form_validation->run() === FALSE)
		{
		    $this->load->view('templates/header',$data);
		    $this->load->view('reimburse/apply',$data);
		    $this->load->view('templates/footer');
		}
		else
		{
            if($opTime == NULL)
            {
                $opTime = date("Y-m-d");
            }
			$reimburse = array(
				'worknumber' => $worknumber,
            	'username' => $username,
		'desp' => $desp,
                'opTime' => $opTime,
                'amount' => $amount,
                'type' => $type,
                'status' => $status
        	);

		    $this->reimburse_model->set_reimburse($reimburse);
		    
        	$data['reimburses'] = $this->reimburse_model->get_reimburse($user['username']);
        	
        	$this->load->view('templates/header',$data);
        	$this->load->view('reimburse/main', $data);
        	$this->load->view('templates/footer');

		}

    }

}

?>
