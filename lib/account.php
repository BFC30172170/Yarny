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

        static function getAccount(PDO $con, $id){
            $sql = "SELECT * FROM account WHERE ACCOUNT_ID = :id;";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0){
                return null;
            }else{
               $results = $stmt->fetchAll();
               $result = $results[0];
               $account = new Account($con, $result);
               return $account;
            };
        }
    
        static function createAccount(PDO $con, AccountDTO $account){
            $sql = "INSERT INTO account (ACCOUNT_NAME,ACCOUNT_HASHEDPASS,ACCOUNT_EMAIL, ACCOUNT_ROLE) VALUES (:name,:hashedpass,:email,'user');";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':name', $account->username, PDO::PARAM_STR);
            $stmt->bindValue(':hashedpass', $account->getHashedPassword(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $account->email, PDO::PARAM_STR);
            $stmt->execute();
    
            $last_id = $con->lastInsertId();
            $account = Account::getAccount($con,$last_id);
            return $account;
        }
    
        static function getAccountByName(PDO $con, $name){
            $sql = "SELECT * FROM account WHERE ACCOUNT_NAME = :name;";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':name',$name,PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 0){
                return null;
            }else{
               $results = $stmt->fetchAll();
               $result = $results[0];
               $account = new Account($con, $result);
               return $account;
            };
        }
    
        static function getAccountByEmail(PDO $con, $email){
            $sql = "SELECT * FROM account WHERE ACCOUNT_EMAIL = :email;";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':email',$email,PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 0){
                return null;
            }else{
               $results = $stmt->fetchAll();
               $result = $results[0];
               $account = new Account($con, $result);
               return $account;
            };
        }
    }

    class AccountDTO{
        function __construct($obj){
            $this->username = $obj['username'];
            $this->email = $obj['email'];
            $this->password = $obj['password'];
            $this->passwordConfirm = $obj['passwordConfirm'];
        }
        public $username;
        public $email;
        public $password;
        public $passwordConfirm;

        function getHashedPassword(){
            return password_hash($this->password, PASSWORD_DEFAULT);
        }

    }


