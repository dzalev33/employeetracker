<?php

class Employee {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getEmployees(){
//        $this->db->query('SELECT * FROM users where user_type = 0');
        $this->db->query('SELECT * FROM users ');

        $results = $this->db->resultSet();

        return $results;
    }

    //find user by email
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        //check
        if ($this->db->rowCount() > 0){
            //there is an email found in database
            return true;
        }else{
            return false;
        }
    }

    public function addEmployee($data){
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        //bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function updateEmployee($data){
        $this->db->query('UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id ');
        //bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function getEmployeeById($id){
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $row;
    }

    public function deleteEmployee($id){
        $this->db->query('DELETE FROM users WHERE id = :id ');
        //bind values
        $this->db->bind(':id', $id);


        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

}