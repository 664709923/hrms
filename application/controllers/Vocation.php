<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vocation extends CI_Controller{

	public function __construct()
    {
        parent::__construct();
        //before use session, we need load library('session') first
        $this->load->library('session');

        //we may use vocation_model in the following functions
        $this->load->model('vocation_model');
        $this->load->model('vocation_type_model');

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
    		$this->vocation_model->delete_vocation($id);
    	}

    	$username = $user['username'];
		$year = $_REQUEST['year'];
        $type = $_REQUEST['type'];
		$status = $_REQUEST['status'];

		$data['vocations'] = $this->vocation_model->get_vocation($username, $year, $type, $status);
		
		$this->load->view('templates/header',$data);
        $this->load->view('vocation/main', $data);
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
            $this->vocation_model->update_vocation($id);
        }

        $username = $this->input->post('username');
        $year = $this->input->post('year');
        $type = $this->input->post('type');
        $status = $this->input->post('status');

        $data['vocations'] = $this->vocation_model->get_vocation($username, $year, $type, $status);
        
        $this->load->view('templates/header',$data);
        $this->load->view('vocation/admin', $data);
        $this->load->view('templates/footer');
    }

    public function apply()
    {
    	$user = $this->session->login_user;
		if($user == NULL)
		{
			redirect('user/login');
		}

		$data['title'] = 'Apply Vocation';
		$data['error'] = '';

        //calculate the rest days 
        $used_days = $this->vocation_model->get_used_by_type($user['username']);
        $total_days = $this->session->vocation_types;
        $days = array();
        foreach ($total_days as $total) {
            $id = $total['id'];
            $days[$id] = $total['days'];
        }

        foreach ($used_days as $used) {
            $id = $used['type'];
            $day = $used['duration'];
            $days[$id] -= $day;
        }
        $data['rest'] = $days;

        $username = $this->session->login_user['username'];
        $startTime = $this->input->post('startTime');
        //$endTime = $this->input->post('endTime');
        //$duration = ceil((strtotime($this->input->post('endTime')) - strtotime($this->input->post('startTime')))/86400) + 1;
        $duration = $this->input->post('duration');
        $desp = $this->input->post('desp');
        $opTime = date("Y-m-d H:i:s");
        $type = $this->input->post('type');

        $status = 1; //默认为：已提交

        $flag = FALSE;
        if($type == NULL){
            $flag = TRUE;
        }elseif($startTime == NULL)
        {
            $data['error'] = '开始时间不能为空!';
            $flag = TRUE;
        }elseif ($duration == NULL)
        {
            $data['error'] = '请假时间不能为空!';
            $flag = TRUE;
        }elseif ($duration > $days[$type])
        {
            $data['error'] = '假期剩余天数不足，请重试!';
            $flag = TRUE;
        }

		if ($flag)
		{
		    $this->load->view('templates/header',$data);
		    $this->load->view('vocation/apply',$data);
		    $this->load->view('templates/footer');
		}
		else
		{
			$vocation = array(
				'username' => $username,
            	'startTime' => $startTime,
                'duration' => $duration,
            	'desp' => $desp,
            	'opTime' => $opTime,
                'type' => $type,
                'status' => $status
        	);

		    $this->vocation_model->set_vocation($vocation);
		    
        	$data['vocations'] = $this->vocation_model->get_vocation($user['username']);
        	
        	$this->load->view('templates/header',$data);
        	$this->load->view('vocation/main', $data);
        	$this->load->view('templates/footer');

		}

    }

}

?>