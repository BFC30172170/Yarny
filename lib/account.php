<?php

class Account{
        function __construct(PDO $con, $obj){
            if (isset($obj['ACCOUNT_ID'])){
            $this->id = $obj['ACCOUNT_ID'];
            $this->username = $obj['ACCOUNT_NAME'];
            $this->hashedpass = $obj['ACCOUNT_HASHEDPASS'];
            $this->role = $obj['ACCOUNT_ROLE'];
            $this->email = $obj['ACCOUNT_EMAIL'];
            $this->telephone = $obj['ACCOUNT_TELEPHONE'];
            $this->mobile = $obj['ACCOUNT_MOBILE'];
            $this->created = $obj['ACCOUNT_CREATED'];
            }
        }
        public $id;
        public $username;
        public $hashedpass;
        public $role;
        public $email;
        public $telephone;
        public $mobile;
        public $created;
    }

    function getAccount(PDO $con, $id){
        $sql = "SELECT * FROM account WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $result = $results[0];
           $account = new Account($con, $result);
           return $account;
        };
    };