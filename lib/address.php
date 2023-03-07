<?php

class Address {
        function __construct(PDO $con, $obj){
            if (isset($obj['ADDRESS_ID'])){
            $this->id = $obj['ADDRESS_ID'];
            $this->forename = $obj['ADDRESS_FORENAME'];
            $this->surname = $obj['ADDRESS_SURNAME'];
            $this->line1 = $obj['ADDRESS_LINE_1'];
            $this->line2 = $obj['ADDRESS_LINE_2'];
            $this->line3 = $obj['ADDRESS_LINE_3'];
            $this->town = $obj['ADDRESS_TOWN'];
            $this->postcode = $obj['ADDRESS_POSTCODE'];
            $this->country = $obj['ADDRESS_COUNTRY'];
            $this->account =  $obj['ACCOUNT_ID'];
            }
        }
        public $id;
        public $forename;
        public $surname;
        public $line1;
        public $line2;
        public $line3;
        public $town;
        public $postcode;
        public $country;
        public $account;
    }

    function getAddress(PDO $con, $id){
        $sql = "SELECT * FROM address WHERE ADDRESS_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $result = $results[0];
           $address = new Address($con, $result);
           return $address;
        };
    };

    function getAccountAddresses(PDO $con, $accountId){
        $sql = "SELECT * FROM address WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$accountId,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $addresses = array();
           foreach ($results as $result) {
            $address = new Address($con, $result);
            array_push($addresses,$address);
           }
           return $addresses;
        };
    };
