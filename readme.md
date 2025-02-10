
# RBAC (Role-Based Access Control) in Codeigniter 3

_RBAC is a method for managing access to resources based on user roles. Each user is assigned a role (like Admin, Editor, Viewer), and each role has permissions that define what actions can be performed on different resources._

### Database Structure:

****Users Table:**** Stores user details.


```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```


****Roles Table:**** Stores roles (e.g., Admin, Editor).

```sql
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);
```

****Permissions Table:**** Stores permissions (e.g., edit_post, view_post).

```sql
CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);
```

****User Roles Table:**** Links users to roles.

```sql
CREATE TABLE IF NOT EXISTS user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(role_id) REFERENCES roles(id)
);
```

****Role Permissions Table:**** Links roles to permissions.
```sql
CREATE TABLE IF NOT EXISTS role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    FOREIGN KEY(role_id) REFERENCES roles(id),
    FOREIGN KEY(permission_id) REFERENCES permissions(id)
);
```

****Posts Table:**** Stores posts, linked to users.

```sql
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(created_by) REFERENCES users(id)
);
```


##### Models
****User Model (User_model.php):****  Handles user-related functions, like fetching users by email and creating users.

```php
public function create_user($data) {
    $this->username = $data['username'];
    $this->email = $data['email'];
    $this->password = password_hash($data['password'], PASSWORD_BCRYPT);
    return $this->db->insert('users', $this);
}

public function get_user_by_email($email) {
    $this->db->where('email', $email);
    return $this->db->get('users')->row_array();
}
```

****Role Model (Role_model.php):**** Handles roles and permissions.

```php
public function get_role_permissions($role_id) {
    $this->db->select('permissions.name');
    $this->db->from('role_permissions');
    $this->db->join('permissions', 'role_permissions.permission_id = permissions.id');
    $this->db->where('role_permissions.role_id', $role_id);
    return $this->db->get()->result_array(); 
}

public function get_user_role($user_id) {
    $this->db->select('role_id');
    $this->db->from('user_roles');
    $this->db->where('user_roles.user_id', $user_id);
    return $this->db->get()->row()->role_id; 
}
```

****Post Model (Post_model.php):**** Handles post-related operations (create, update, delete, and fetch).

```php
public function insert_post($data) {
    $this->title = $data['title'];
    $this->content = $data['content'];
    $this->created_by = $data['user_id'];
    $this->db->insert('posts', $this);  
}

public function get_all_posts() {
    return $this->db->get('posts')->result_array(); 
}

public function delete_post($id) {
    return $this->db->delete('posts', array('id' => $id)); 
}
```

# Check Permissions in Controller Methods
_Before allowing users to perform specific actions, the controller checks if the user has the required permission by comparing it against their assigned permissions._

Example:

```php
public function __construct(){
    $this->user_id = $this->session->userdata('user_id');
        $this->role_id = $this->role_model->get_user_role($this->user_id);
        $this->permissions = $this->role_model->get_role_permissions($this->role_id);
}

public function create() {

    // Check if user has permission to create a post
    if (!in_array('create_post', array_column($this->permissions, 'name'))) {
        $this->session->set_flashdata('message', "You don't have access to create post");
        redirect('/post');
    }

    $this->load->view('layouts/header');
    $this->load->view('posts/create');        
    $this->load->view('layouts/footer');
}

public function edit($id) {
    // Check if user has permission to edit the post
    if (!in_array('edit_post', array_column($this->permissions, 'name'))) {
        $this->session->set_flashdata('message', "You don't have access to edit post");
        redirect('/post');
    }

    $data['post'] = $this->Post->get_post_by_id($id);  
    $this->load->view('layouts/header');  
    $this->load->view('posts/edit', $data);  
    $this->load->view('layouts/footer');
}

public function delete($id) {
    // Check if user has permission to delete the post
    if (!in_array('delete_post', array_column($this->permissions, 'name'))) {
        $this->session->set_flashdata('message', "You don't have access to delete post");
        redirect('/post');
    }

    $this->Post->delete_post($id);  
    redirect('/post');
}
```
