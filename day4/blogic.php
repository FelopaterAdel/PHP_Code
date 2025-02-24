<?php
include_once('datebase.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



class UserService extends Database {

    
    public function insertUser($name, $email, $password, $ext, $room_no, $image) {
        try {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $res = $this->insert(
                'user',
                ["name", "email", "password", "ext", "room_no", "image_path"],
                [$name, $email, $hashed_password, $ext, $room_no, $image]
            );

            return $res > 0 ? '<div><h1>User added</h1></div>' : '<div><h1>Error adding user</h1></div>';
        } catch (Exception $e) {
            error_log("Error inserting user: " . $e->getMessage());
            return '<div><h1>An error occurred. Please try again later.</h1></div>';
        }
    }

    public function getAllUser() {
        return $this->select('user');
    }

    public function getUserById($id) {
        $condition =['id'=>$id];
        return $this->select('user',$condition);
    }
    public function getAllRoom() {
        return $this->select('room');
    }

    public function updateUser($id, $columns, $values) {
        $condition = "id = $id";
        $res = $this->UPDATE('user', $columns, $values, $condition);
        return $res > 0 ? '<div><h1>User updated</h1></div>' : '<div><h1>Error updating user</h1></div>';
    }

    public function deleteUser($id) {
        $condition = "id = :id";
        $params = ['id' => $id];

        $res = $this->delete('user', $condition, $params);
        return $res > 0 ? '<div><h1>User deleted</h1></div>' : '<div><h1>Error deleting user</h1></div>';
    }
}

?>