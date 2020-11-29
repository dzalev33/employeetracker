<?php

class Request {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getRequestById($id){
        $this->db->query('SELECT * FROM request WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $row;
    }

    public function getRequests()
    {
        $this->db->query('SELECT * ,
                                    request.id as requestId,
                                    users.id as userId,
                                    request.created_at as requestCreated,
                                    users.created_at as userCreated
                                FROM request
                                INNER JOIN users
                                ON request.user_id = users.id
                                ORDER BY request.created_at ASC
                                ');

        $results = $this->db->resultSet();
        return $results;
    }

    public function addEmployeeRequest($data){
        $this->db->query('INSERT INTO request (user_id, request_from, request_to, status) 
                                    VALUES (:user_id, :request_from, :request_to, :status)');

        //bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':request_from', $data['request_from']);
        $this->db->bind(':request_to', $data['request_to']);
        $this->db->bind(':status', $data['status']);

        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function approveRequestById($id){
        $this->db->query('UPDATE request SET status = "Approved" WHERE id = :id ');

        //bind values
        $this->db->bind(':id', $id);

        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function cancelRequestById($id){
        $this->db->query('UPDATE request SET status = "Canceled" WHERE id = :id ');

        //bind values
        $this->db->bind(':id', $id);

        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function rejectRequestById($id){
        $this->db->query('UPDATE request SET status = "Rejected" WHERE id = :id ');
        //bind values
        $this->db->bind(':id', $id);

        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deleteRequest($id){
        $this->db->query('DELETE FROM request WHERE id = :id ');
        //bind values
        $this->db->bind(':id', $id);

        if ($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}