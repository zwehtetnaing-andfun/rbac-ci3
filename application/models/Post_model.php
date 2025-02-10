<?php

class Post_model extends CI_Model
{
	public $title;
	public $content;
	public $created_by;

	public function __construct() {
        $this->load->database();
    }

	public function get_all_posts() {
        $query = $this->db->get('posts');
        return $query->result_array();  // Return as an array
    }

	public function get_post_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('posts');
        return $query->row_array();  // Return single row as array
    }

	public function insert_post($data) {
        $this->title = $data['title'];
        $this->content = $data['content'];
		$this->created_by = $data['user_id'];
        $this->db->insert('posts', $this);  
    }

    public function update_post($data) {
        $this->title = $data['title'];
        $this->content = $data['content'];
		$this->created_by = $data['user_id'];
        $this->db->update('posts', $this, array('id' => $data['id']));  
    }

   
    public function delete_post($id) {
        $this->db->delete('posts', array('id' => $id));  
    }



}


// CREATE TABLE IF NOT EXISTS posts(
// 	id INT AUTO_INCREMENT PRIMARY KEY,
//     title VARCHAR(100) NOT NULL,
//     content VARCHAR(255) NOT NUll,
//     created_by INT NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
// );
