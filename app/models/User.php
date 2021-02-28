<?php

class User {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    // update email
    public function updateEmail($data){
        $this->db->query("UPDATE users SET user_email = :email WHERE user_id = :id");

        //Bind values param with the email variable
        $this->db->bind(':email',$data['new_email']);
        $this->db->bind(':id',$data['id']);


        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // update password
    public function updatePassword($data){
        $this->db->query("UPDATE users SET user_pwd = :pwd WHERE user_id = :id");

        //Bind values param with the email variable
        $this->db->bind(':pwd',$data['new_password']);
        $this->db->bind(':id',$data['id']);


        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // Find user by id
    public function getUserById($id){
        $this->db->query("SELECT * FROM users WHERE user_id = :id");

        //Bind the email param with the email variable
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;       
    }

    public function deleteById($id){
        $this->db->query("DELETE FROM users WHERE user_id = :id ");

        //Bind values param with the email variable
        $this->db->bind(':id',$id);
        $this->db->execute();
    }

    public function login($username, $password){
        $this->db->query("SELECT * FROM users WHERE user_email = :username");

        //Bind the email param with the username variable
        $this->db->bind(':username',$username);
        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            $hashedPassword = $row->user_pwd;

        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
           }
        }
    }
        

    public function getUsers(){
        $this->db->query("SELECT * FROM users");
        $result = $this->db->resultSet();

        return $result;
    }

    // Find user by email
    public function findUserByEmail($email){
        $this->db->query("SELECT * FROM users WHERE user_email = :email");

        //Bind the email param with the email variable
        $this->db->bind(':email',$email);
        $this->db->execute();

        // Check if the email is already registered
        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        
    }

    

    // Register a new user
    public function registerUser($data){
        $this->db->query("INSERT INTO users (user_first, user_last, user_email, user_pwd, user_role ) VALUES (:firstname, :lastname, :email, :pwd, :userRole)");

        //Bind values param with the email variable
        $this->db->bind(':firstname',$data['firstname']);
        $this->db->bind(':lastname',$data['lastname']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':pwd',$data['password']);
        $this->db->bind(':userRole', 'user');
        
        // Execute function
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    
}