<?php

class User_model extends CI_Model{

	public $username;
	public $email;
	public $password;
	
	public function __construct() {
        $this->load->database();
    }

	public function get_user_by_email($email)
	{
		$this->db->where('email',$email);
		$query = $this->db->get('users');
		return $query->row_array();
	}

	public function create_user($data)
	{
		$this->username = $data['username'];
		$this->email = $data['email'];
		$this->password = password_hash($data['password'],PASSWORD_BCRYPT);

		if($this->db->insert('users',$this)){
			return true;
		};

		return false;
	}

	
	
}


// CREATE TABLE IF NOT EXISTS users(
// 	id INT AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(50) NOT NULL UNIQUE,
//     email VARCHAR(100) NOT NULL UNIQUE,
//     password VARCHAR(100) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// );
