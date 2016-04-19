<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{

	public function __construct()
    {
        parent::__construct();
        //before use session, we need load library('session') first
        $this->load->library('session');

        //we may use user_model and vocation_model in the following functions
        $this->load->model('user_model');
        
		$this->load->model('vocation_model');
        $this->load->model('vocation_type_model');

        $this->load->model('reimburse_model');
        $this->load->model('reimburse_type_model');

        $this->load->model('status_model');


        //help to generate the url
        $this->load->helper('url_helper');

        $this->load->helper('file');
        $this->load->helper('form');

        //validate the form
        $this->load->library('form_validation');
    }

    // public function login()
    // {
    // 	$data['title'] = 'login';
    // 	$this->load->view('templates/header', $data);
    // 	$this->load->view('user/login');
    // 	$this->load->view('templates/footer');
    // }

  //   public function test($username=NULL, $passwd=NULL)
  //   {
  //   	$user = $this->user_model->get_user($username, $passwd);
  //   	$data['user'] = $user;
  //   	$data['title'] = 'login';
		// $data['error'] = '';

  //   	$this->load->view('templates/header',$data);
  //       $this->load->view('user/success',$data);
  //       $this->load->view('templates/footer');
  //   }

    //set vocation_type and status information into session
    private function setSession()
    {
        $types = $this->vocation_type_model->get_vocation_type();
        $this->session->set_userdata('vocation_types', $types);

        $types = $this->reimburse_type_model->get_reimburse_type();
        $this->session->set_userdata('reimburse_types', $types);

        $status = $this->status_model->get_status();
        $this->session->set_userdata('status', $status);
    }

    
	public function login($username=NULL, $passwd=NULL)
	{
		$data['title'] = 'login';
		$data['error'] = '';

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('passwd', 'Password', 'required');

        if($this->form_validation->run() === FALSE)
        {
        	$this->load->view('templates/header',$data);
            $this->load->view('user/login',$data);
            $this->load->view('templates/footer');
            return;
        }

        $username = $this->input->post('username');
        $passwd = $this->input->post('passwd');

        $user = $this->user_model->get_user($username, $passwd);
        if($user == NULL)
        {
        	$data['error'] = '用户名或密码错误';
        	$this->load->view('templates/header',$data);
            $this->load->view('user/login',$data);
            $this->load->view('templates/footer');
            return;
        }
        
        $this->session->set_userdata('login_user', $user);
        
        $this->setSession();

        redirect('user/main');
        /*//set vocation_type and status information into session
        $this->setSession();

        $data['title'] = 'Welcome';
        

        if($user['role'] == 1)
        {
        	$data['vocations'] = $this->vocation_model->get_vocation();
        	$this->load->view('templates/header',$data);
        	$this->load->view('user/admin', $data);
        	$this->load->view('templates/footer');
        }else
        {
			$data['vocations'] = $this->vocation_model->get_vocation($user['username']);
        	$this->load->view('templates/header',$data);
        	$this->load->view('user/main', $data);
        	$this->load->view('templates/footer');
        }*/
	}

	public function logout()
	{
		$this->session->unset_userdata('login_user');
        $this->session->unset_userdata('types');
        $this->session->unset_userdata('status');
        
		$data['title'] = 'login';
		$data['error'] = '';

        $this->load->view('templates/header',$data);
        $this->load->view('user/login',$data);
        $this->load->view('templates/footer');
	}

	public function register()
	{
		$data['title'] = '创建新用户';

        $this->form_validation->set_rules('name', '姓名', 'required');
		$this->form_validation->set_rules('username', '用户名', 'required|is_unique[user.username]');
		$this->form_validation->set_rules('passwd', '密码', 'required');
		$this->form_validation->set_rules('passwd2', '确认密码', 'required|matches[passwd]');
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');

		if ($this->form_validation->run() === FALSE)
		{
		    $this->load->view('templates/header',$data);
		    $this->load->view('user/register');
		    $this->load->view('templates/footer');
		}
		else
		{
			$user = array(
                'name' => $this->input->post('name'),
				'username' => $this->input->post('username'),
            	'passwd' => sha1($this->input->post('passwd')),
            	'email' => $this->input->post('email')
        	);

            //add user
		    $this->user_model->add_user($user);

            //get user
            $user = $this->user_model->get_user($user['username']);
                        
            //generate the worknumber whit auto_incremented id
            $user['worknumber'] = date('y') * 10000 + $user['id'] - 1;

            //update user
            $this->user_model->update_user($user);
			
            //set current user into session
            $this->session->set_userdata('login_user', $user);
            $this->setSession();

            redirect('user/main');
            /*//set vocation_type and status information into session
            $this->setSession();

            //get vocations info which will be shown in the next page
			$data['vocations'] = $this->vocation_model->get_vocation($user['username']);
        	
		    $this->load->view('templates/header',$data);
        	$this->load->view('user/main', $data);
        	$this->load->view('templates/footer');*/
		}
	}

    public function edit()
    {
        $data['title'] = '修改个人信息';

        $this->form_validation->set_rules('name', '姓名', 'required');
        $this->form_validation->set_rules('username', '用户名', 'required');
        $this->form_validation->set_rules('passwd', '密码', 'required');
        $this->form_validation->set_rules('passwd2', '确认密码', 'required|matches[passwd]');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header',$data);
            $this->load->view('user/edit');
            $this->load->view('templates/footer');
        }
        else
        {
            $user = $this->session->login_user;
            $user['name'] = $this->input->post('name');
            $user['username'] = $this->input->post('username');
            $user['passwd'] = sha1($this->input->post('passwd'));
            $user['email'] = $this->input->post('email');

            //update user
            $this->user_model->update_user($user);
            
            //set current user into session
            $this->session->set_userdata('login_user', $user);
            $this->setSession();

            redirect('user/main');
            /*//set vocation_type and status information into session
            $this->setSession();

            //get vocations info which will be shown in the next page
            $data['vocations'] = $this->vocation_model->get_vocation($user['username']);
            
            $this->load->view('templates/header',$data);
            $this->load->view('user/main', $data);
            $this->load->view('templates/footer');*/
        }
    }

    public function main()
    {
        $user = $this->session->login_user;
        if($user == NULL)
        {
            redirect('user/login');
        }

        $data['title'] = 'Welcome';
        
        if($user['role'] == 1)
        {
            $data['vocations'] = $this->vocation_model->get_vocation();
            $this->load->view('templates/header',$data);
            $this->load->view('user/admin', $data);
            $this->load->view('templates/footer');
        }else
        {
            $data['vocations'] = $this->vocation_model->get_vocation($user['username']);
            $this->load->view('templates/header',$data);
            $this->load->view('user/main', $data);
            $this->load->view('templates/footer');
        }
    }

    public function reimburse_main()
    {
        $user = $this->session->login_user;
        if($user == NULL)
        {
            redirect('user/login');
        }

        $year = $this->input->post('year');
        $type = $this->input->post('type');
        $status = $this->input->post('status');


        if($user['role'] == 1)
        {
            $username = $this->input->post('user');
            $data['reimburses'] = $this->reimburse_model->get_reimburse($username, $year, $type, $status, TRUE);
            $this->load->view('templates/header',$data);
            $this->load->view('reimburse/admin', $data);
            $this->load->view('templates/footer');
        }else
        {
            $data['reimburses'] = $this->reimburse_model->get_reimburse($user['username'], $year, $type, $status);
            $this->load->view('templates/header',$data);
            $this->load->view('reimburse/main', $data);
            $this->load->view('templates/footer');
        }
    }

	public function vocation_main()
	{
		$data['title'] = '';
		$user = $this->session->login_user;
		if($user == NULL)
		{
			redirect('user/login');
		}

		$year = $this->input->post('year');
        $type = $this->input->post('type');
        $status = $this->input->post('status');
        
        //$data['types'] = $this->vocation_type_model->get_vocation_type();
        //$data['status'] = $this->status_model->get_status();

		if($user['role'] == 1)
		{
			$username = $this->input->post('user');
			$data['vocations'] = $this->vocation_model->get_vocation($username, $year, $type, $status, TRUE);
			
			$this->load->view('templates/header',$data);
        	$this->load->view('vocation/admin', $data);
        	$this->load->view('templates/footer');

		}else
		{
			$data['vocations'] = $this->vocation_model->get_vocation($user['username'], $year, $type, $status);

			$this->load->view('templates/header',$data);
        	$this->load->view('vocation/main', $data);
        	$this->load->view('templates/footer');
		}
	}

}



?>