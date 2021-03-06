<?php

class Authentication{
    //db stuff
    private $conn;
    private $table = 'user';

    //properties for authentication
    public $User_id;
    public $User_name;
    public $User_password;
    public $is_Admin;

    //constructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    //read record - getting cars from db
    public function read_all(){
        //create query
        $query = 'SELECT * 
            FROM '.$this->table;
        
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //read single record
    public function getByUser_name($User_name){
        //create query
        $query = 'SELECT * FROM '.$this->table.'
                    WHERE User_name = ?';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(1, $User_name);
        //execute the query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) return false;

        $this->User_id = $row['User_id'];
        $this->User_name =  $row['User_name'];
        $this->User_password = $row['User_password'];
        $this->is_Admin = $row['is_Admin'];
        return true;

    }

    //create a new record
    public function create(){
        //create query
        $query = 'INSERT INTO ' . $this->table . 
                    ' SET User_name = :name, User_password = :pass, is_Admin = :is_Admin';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->User_name = htmlspecialchars(strip_tags($this->User_name));
        $this->User_password = htmlspecialchars(strip_tags($this->User_password));
        $this->is_Admin  = 0;

        //binding of param
        $stmt->bindParam(':name', $this->User_name);
        $stmt->bindParam(':pass', $this->User_password);
        $stmt->bindParam(':is_Admin', $this->is_Admin);
        
        //execute the query
        if ($stmt->execute()) return true;

        //print error if sth goes wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    //update password
    public function updatePass($newPassword){
        //create query
        $query = 'UPDATE ' . $this->table . 
                    '  SET User_password = :pass
                      WHERE User_name = :name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->User_name = htmlspecialchars(strip_tags($this->User_name));
        $this->User_password = $newPassword;

        //binding of param
        $stmt->bindParam(':pass', $this->User_password);
        $stmt->bindParam(':name', $this->User_name);
        
        //execute the query
        if ($stmt->execute()) return true;

        //print error if sth goes wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    //delete a record by id
    public function delete(){
        //create query
        $query = 'DELETE 
                      FROM ' . $this->table . 
                    ' WHERE User_name = :name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->User_name = htmlspecialchars(strip_tags($this->User_name));
       
        //binding of param
        $stmt->bindParam(':name', $this->User_name);
        
        //execute the query
        if($stmt->execute()){
            $lastId = $this->lastUser();
            $query = 'UPDATE ' . $this->table . ' SET User_id=:id WHERE User_id=:lastId';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':lastId', $lastId);
            if($stmt->execute()) return true;
            return false;
        }
        return false;
    }

    public function deleteUser($id){
        $query = 'DELETE FROM ' . $this->table . ' WHERE User_id=:id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
            $lastId = $this->lastUser();
            $query = 'UPDATE ' . $this->table . ' SET User_id=:id WHERE User_id=:lastId';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':lastId', $lastId);
            if($stmt->execute()) return true;
            return false;
        }
        return false;
    }
}

?>