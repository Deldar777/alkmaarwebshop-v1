<?php

class page{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    // Register a new complaint
    public function registerRequest($data){
        $this->db->query("INSERT INTO requests (fullname, email, phone_number, message, handled ) VALUES (:fullname, :email, :phone_number, :message, :handled)");

        //Bind values param with the variables
        $this->db->bind(':fullname',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':phone_number',$data['phoneNumber']);
        $this->db->bind(':message',$data['message']);
        $this->db->bind(':handled', false);
        
        // Execute function
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    //get alle user's requests
    public function getRequests(){
        $this->db->query("SELECT * FROM requests");
        $result = $this->db->resultSet();

        return $result;
    }

    //update the status of the requests by id
    public function updateStatus($id){
        $this->db->query("UPDATE requests SET handled = :handled WHERE request_id = :id");

        $this->db->bind(':handled',true);
        $this->db->bind(':id',$id);

        $this->db->execute();
    }
}