<?php
require_once "database.php";

class User extends Database {

    public function createUser($first_name, $last_name, $username, $password){
        $sql = "INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`) 
                    VALUES ('$first_name', '$last_name', '$username', '$password')";

        if($this->conn->query($sql)){
            header("location: ../views");   // go to index.php of views folder
            exit;                           // same as die()
        } else {
            die("Error creating user: " . $this->conn->error);
        }
    }

    public function login($username, $password){
        $sql = "SELECT id, username, `password` FROM users WHERE username = '$username'";

        $result = $this->conn->query($sql);
        if($result->num_rows == 1){ // Check if the username is existing
            $user_details = $result->fetch_assoc();
            // $user_details contains the username and password of $username
            if(password_verify($password, $user_details['password'])){
                // Create session variables
                session_start();

                $_SESSION['user_id'] = $user_details['id'];
                $_SESSION['username'] = $user_details['username'];

                header("location: ../views/dashboard.php");
                exit;
            } else {
                die("Password is incorrect.");
            }
        } else {
            die("Username not found.");
        }
    }

    public function getUsers(){
        $sql = "SELECT id, first_name, last_name, username FROM users";
        // SELECT <column_names> FROM <table_name>
        // If you're using SELECT, always get the RESULT

        if($result = $this->conn->query($sql)){
            return $result;
            // expecting 1 or more rows
        } else {
            die("Error retrieving users: " . $this->conn->error);
        }
    }

    public function getUser($user_id){
        $sql = "SELECT id, first_name, last_name, username FROM users WHERE id = $user_id";

        if($result = $this->conn->query($sql)){
            return $result->fetch_assoc();
            // expecting 1 row only
            // return an associative array
        } else {
            die("Error retrieving user: " . $this->conn->error);
        }
    }

    public function updateUser($user_id, $first_name, $last_name, $username){
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $user_id";

        if($this->conn->query($sql)){
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die("Error updating user: " . $this->conn->error);
        }
    }

    public function deleteUser($user_id){
        $sql = "DELETE FROM users WHERE id = $user_id";

        if($this->conn->query($sql)){
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die("Error deleting user: " . $this->conn->error);
        }
    }

    public function uploadPhoto($user_id, $image_name, $tmp_name){
        $sql = "UPDATE users SET photo = '$image_name' WHERE id = $user_id";

        if($this->conn->query($sql)){
            $destination = "../img/" . basename($image_name);
            // basename("C:\xampp\tmp\apricot.jpeg")
            // apricot.jpeg
            if(move_uploaded_file($tmp_name, $destination)){
                header("location: ../views/profile.php");
                exit;
            } else {
                die("Error moving the photo.");
            }
        } else {
            die("Error uploading photo: " . $this->conn->error);
        }
    }

    public function getUserPhoto($user_id){
        $sql = "SELECT photo FROM users WHERE id = $user_id";

        if($result = $this->conn->query($sql)){
            return $result->fetch_assoc();
        } else {
            die("Error retrieving photo: " . $this->conn->error);
        }
    }
}