<?php

class User extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model','User');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('form_validation');
	}

	public function register()
	{
		$this->load->view('layouts/header');
		$this->load->view('auth/register');
		$this->load->view('layouts/footer');
	}

	public function store()
	{

		$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|min_length[3]|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

		if ($this->form_validation->run() == FALSE)
        {
            $this->register();
        } else {

			$data['username'] = $this->input->post('username');
			$data['email'] = $this->input->post('email');
			$data['password'] = $this->input->post('password');

			if($this->User->create_user($data))
			{
				redirect('/user/login');
			}

			redirect('/user/register');
		}

		
	}

	public function login()
	{
		$this->load->view('layouts/header');
		$this->load->view('auth/login');
		$this->load->view('layouts/footer');
	}

	public function authenticate()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|min_length[3]|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

		if ($this->form_validation->run() == FALSE)
        {
            $this->login();
        } else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$user = $this->User->get_user_by_email($email);

			if($user && password_verify($password,$user['password']))
			{
				$this->session->set_userdata([
					'user_id' => $user['id'],
					'user_name' => $user['username'],
					'user_email' => $user['email'],
					'logging_in' => true
				]);

				redirect('/post/index');
			}

			$this->session->set_flashdata('error',"The provided credintials does not correct! ");
			redirect('/user/login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata(['user_id','user_name','user_email']);
		$this->session->set_userdata([
			'logging_in' => false
		]);

		redirect('/user/login');
	}
}
