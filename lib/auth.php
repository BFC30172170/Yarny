<?php

include_once 'account.php';

    class Auth{
        public $message;
        public $valid = true;

        function userLogin(PDO $con, Credential $cred){
            if(!isset($cred->username))
            {
                $this->valid = false;
                $this->message = 'Username not supplied';
            }
            if(!isset($cred->password))
            {
                $this->valid = false;
                $this->message = 'Password not supplied';
            }

            $sql = 'SELECT * FROM Account a WHERE ACCOUNT_NAME = :un';
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':un',$cred->username,PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0){
                $this->message = 'Username incorrect';
                return [];
            }else{
                $results = $stmt->fetchAll();
                $result = $results[0];
                $account= new Account($con, $result);
            }
            if(password_verify($cred->password,$account->hashedpass)){
                $_SESSION['username']=$account->username;
                $_SESSION['role']=$account->role;
                $_SESSION['id']=$account->id;
                $this->message = 'Login Success';
            }else{
                $this->message = 'Password incorrect';
            };
            return($this);
        }

        function userLogout(){
            $_SESSION = array();
            if (isset($_COOKIE[session_name()])) {
                unset($_COOKIE[session_name()]); 
                setcookie(session_name(), null, -1, '/');}
            session_destroy();
        }
    }
    

    class Credential{
        function __construct($array){
            $this->username = $array['username'];
            $this->password = $array['password'];
        }
        public $username;
        public $password;
    };

    