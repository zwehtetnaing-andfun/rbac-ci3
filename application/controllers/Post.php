<?php

class Post extends CI_Controller{

	public $user_id;
	public $role_id;
	public $permissions;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('post_model', 'Post');  
		$this->load->model('role_model'); 
        $this->load->helper('url_helper');
        $this->load->helper('form'); 
		$this->load->library('session');
		$this->load->library('form_validation');

		$this->user_id = $this->session->userdata('user_id');
        $this->role_id = $this->role_model->get_user_role($this->user_id);
        $this->permissions = $this->role_model->get_role_permissions($this->role_id);

	}

	public function index()
	{
		$data['posts'] = $this->Post->get_all_posts();
		$data['username'] = $this->session->userdata('user_name');
		$this->load->view('layouts/header');
		$this->load->view('posts/index',$data);
		$this->load->view('layouts/footer');
	}

	public function create() {
		// Check if user has permission to create post
        if (!in_array('create_post', array_column($this->permissions, 'name'))) {
			$this->session->set_flashdata('message',"You don't have access to create post");
			redirect('/post');
		}

        $this->load->view('layouts/header');  
        $this->load->view('posts/create');        
        $this->load->view('layouts/footer'); 
    }

    public function store() {

		$this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('content', 'Content', 'required|min_length[3]');

		if ($this->form_validation->run() == FALSE)
        {
            $this->create();
	
        } else {

			$data['title'] = $this->input->post('title');  
			$data['content'] = $this->input->post('content'); 
			$data['user_id'] = $this->user_id;
			$this->Post->insert_post($data);  
			redirect('/post');  
		}

        
    }

    public function edit($id) {

		// Check if user has permission to edit post
		if (!in_array('edit_post', array_column($this->permissions, 'name'))) {
			$this->session->set_flashdata('message',"You don't have access to edit post");
			redirect('/post');
		}
        $data['post'] = $this->Post->get_post_by_id($id);  
        $this->load->view('layouts/header');  
        $this->load->view('posts/edit', $data);   
        $this->load->view('layouts/footer'); 
    }

    public function update($id) {


		$this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('content', 'Content', 'required|min_length[3]');

		if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
	
        } else {

			$data['id'] = $id;
			$data['title'] = $this->input->post('title');
			$data['content'] = $this->input->post('content');
			$data['user_id'] = $this->user_id;
			$this->Post->update_post($data);  
			redirect('/post');  
		}

        
    }

    public function delete($id) {

		// Check if user has permission to delete post
		if (!in_array('delete_post', array_column($this->permissions, 'name'))) {
			$this->session->set_flashdata('message',"You don't have access to delete post");
			redirect('/post');
		}
        $this->Post->delete_post($id);  
        redirect('/post'); 
    }

}
