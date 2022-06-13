<?php

class User{
    //db stuff
    private $conn;
    private $tableProd = 'product';
    private $tablePurchaseLog = 'log_purchase';
    private $tableCart = 'cart';
    private $tableUser = 'user'; 
    private $tableLibrary = 'user_library';

    //user properties
    public $User_id;
    public $cart;
    public $purchaseLog;
    public $gameLib;

    //constructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    //get user's cart
    public function get_cart(){
        //create query
        $query = 'SELECT * 
            FROM '.$this->tableCart.'
            WHERE User_id = :user_id';
        
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //binding param
        $stmt->bindParam(':user_id', $this->User_id);

        //execute query
        $stmt->execute();

        $this->cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get user's purchase log
    public function get_purchaseLog(){
        //create query
        $query = 'SELECT * 
        FROM '.$this->tablePurchaseLog.'
        WHERE User_id = :user_id';
    
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //binding param
        $stmt->bindParam(':user_id', $this->User_id);

        //execute query
        $stmt->execute();

        $this->purchaseLog = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        
        //execute the query
        if ($stmt->execute()) return true;

        //print error if sth goes wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    //get user's cart
    public function get_gameLib(){
        //create query
        $query = 'SELECT * 
            FROM '.$this->tableLibrary.'
            WHERE User_id = :user_id';
        
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //binding param
        $stmt->bindParam(':user_id', $this->User_id);

        //execute query
        $stmt->execute();

        $this->gameLib = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //execute the query
        if ($stmt->execute()) return true;

        //print error if sth goes wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    //add an product to cart
    public function addToCart($Product_Id){
        //create query
        $query = 'INSERT INTO ' . $this->tableCart . 
                    ' SET User_id = :user_id, Product_id = :prod_id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //binding of param
        $stmt->bindParam(':user_id', $this->User_id);
        $stmt->bindParam(':prod_id', $Product_id);
        
        //execute the query
        if ($stmt->execute()) return true;

        //print error if sth goes wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    //save log when purchasing event happend
    public function savePurchaseLog(){
        if ($this->get_cart() && count($this->cart)){
            foreach($this->cart as $item){
                //create query
                $query = 'INSERT INTO ' . $this->tableLibrary . 
                ' SET User_id = :user_id, Product_id = :prod_id';

                //prepare statement
                $stmt = $this->conn->prepare($query);

                //binding of param
                $stmt->bindParam(':user_id', $this->User_id);
                $stmt->bindParam(':prod_id', $item['Product_id']);
            }

            $currDate = date("Y-m-d H:i:s");
            $query = 'INSERT INTO ' . $this->tablePurchaseLog . 
                ' SET User_id = :user_id, Time = :purchaseTime';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //binding of param
            $stmt->bindParam(':user_id', $this->User_id);
            $stmt->bindParam(':purchaseTime', $currDate);

            //execute the query
            if ($stmt->execute()) return true;

            //print error if sth goes wrong
            printf("Error %s. \n", $stmt->error);
            return false;
        }
        else{
            printf("Not found any products to purchase");
            return false;
        }
    }
}

?>