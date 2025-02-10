<?php

class Role_model extends CI_Model
{

	public $name;

	public function __construct() {
        $this->load->database();
    }

	public function get_role_permissions($role_id) {
        $this->db->select('permissions.name');
        $this->db->from('role_permissions');
        $this->db->join('permissions', 'role_permissions.permission_id = permissions.id');
        $this->db->where('role_permissions.role_id', $role_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_role($user_id) {
        $this->db->select('role_id');
        $this->db->from('user_roles');
        $this->db->where('user_roles.user_id', $user_id);
        $query = $this->db->get();
        return $query->row()->role_id;
    }
}
