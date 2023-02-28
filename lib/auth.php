<?php
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
            echo $stmt->rowCount();
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
            return($this->message);
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
    