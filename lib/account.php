<?php
//An Account is the system's representation of a user/customer
class Account
{
    // Construct an account with reference to the ecommerce database, and columns returned
    function __construct(PDO $con, $obj)
    {
        if (isset($obj['ACCOUNT_ID'])) {
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

    // Get all accounts
    static function getAccounts(PDO $con)
    {
        $sql = "SELECT * FROM account;";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return null;
        } else {
            $results = $stmt->fetchAll();
            $accounts = array();
            foreach ($results as $result) {
                $account = new Account($con, $result);
                array_push($accounts, $account);
            }
            return $accounts;
        }
        ;
    }

    // Pass in DB reference and id to return single account
    static function getAccount(PDO $con, $id)
    {
        $sql = "SELECT * FROM account WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return null;
        } else {
            $results = $stmt->fetchAll();
            $result = $results[0];
            $account = new Account($con, $result);
            return $account;
        }
        ;
    }

    // Pass in DB reference and DTO to create and return single account
    static function createAccount(PDO $con, AccountDTO $account)
    {
        $sql = "INSERT INTO account (ACCOUNT_NAME,ACCOUNT_HASHEDPASS,ACCOUNT_EMAIL, ACCOUNT_ROLE) VALUES (:name,:hashedpass,:email,'user');";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':name', $account->username, PDO::PARAM_STR);
        $stmt->bindValue(':hashedpass', $account->getHashedPassword(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $account->email, PDO::PARAM_STR);
        $stmt->execute();

        $last_id = $con->lastInsertId();
        $account = Account::getAccount($con, $last_id);
        return $account;
    }

    // Pass in DB reference and name to search for Account by name. If multiple name return nothing
    static function getAccountByName(PDO $con, $name)
    {
        $sql = "SELECT * FROM account WHERE ACCOUNT_NAME = :name;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            return null;
        } else {
            $results = $stmt->fetchAll();
            $result = $results[0];
            $account = new Account($con, $result);
            return $account;
        }
        ;
    }

    // Pass in DB reference and email to search for Account by email. if multiple email return nothing
    static function getAccountByEmail(PDO $con, $email)
    {
        $sql = "SELECT * FROM account WHERE ACCOUNT_EMAIL = :email;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $result = $results[0];
            $account = new Account($con, $result);
            return $account;
        }
        ;
    }
}

// Data Transfer Obect class to act as interface for user generated content to populate account entity in the system
class AccountDTO
{
    function __construct($obj)
    {
        $this->username = $obj['username'];
        $this->email = $obj['email'];
        $this->password = $obj['password'];
        $this->passwordConfirm = $obj['passwordConfirm'];
    }
    public $username;
    public $email;
    public $password;
    public $passwordConfirm;

    function getHashedPassword()
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

}