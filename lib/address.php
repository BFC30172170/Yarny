<?php
// An Account is the system's representation of a customers delivery address.
class Address
{
    // Construct an address with reference to the ecommerce database, and columns returned
    function __construct(PDO $con, $obj)
    {
        if (isset($obj['ADDRESS_ID'])) {
            $this->id = $obj['ADDRESS_ID'];
            $this->forename = $obj['ADDRESS_FORENAME'];
            $this->surname = $obj['ADDRESS_SURNAME'];
            $this->line1 = $obj['ADDRESS_LINE_1'];
            $this->line2 = $obj['ADDRESS_LINE_2'];
            $this->line3 = $obj['ADDRESS_LINE_3'];
            $this->town = $obj['ADDRESS_TOWN'];
            $this->postcode = $obj['ADDRESS_POSTCODE'];
            $this->country = $obj['ADDRESS_COUNTRY'];
            $this->account = $obj['ACCOUNT_ID'];
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

    // Pass in DB reference and id to return single address
    static function getAddress(PDO $con, $id)
    {
        $sql = "SELECT * FROM address WHERE ADDRESS_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return null;
        } else {
            $results = $stmt->fetchAll();
            $result = $results[0];
            $address = new Address($con, $result);
            return $address;
        }
        ;
    }

    // Pass in DB reference and account id to return all addresses for a specific accounts
    static function getAccountAddresses(PDO $con, $accountId)
    {
        $sql = "SELECT * FROM address WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $accountId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $addresses = array();
            foreach ($results as $result) {
                $address = new Address($con, $result);
                array_push($addresses, $address);
            }
            return $addresses;
        }
        ;
    }

    // Pass in DB reference and DTO to create and return single address
    static function createAddress(PDO $con, AddressDTO $address)
    {
        try {
            $sql = "INSERT INTO address (ADDRESS_FORENAME,ADDRESS_SURNAME,ADDRESS_LINE_1,ADDRESS_LINE_2,ADDRESS_LINE_3,ADDRESS_TOWN,ADDRESS_POSTCODE,ADDRESS_COUNTRY,ACCOUNT_ID) VALUES (:forename,:surname,:line1,:line2,:line3,:town,:postcode,:country,:account);";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':forename', $address->forename, PDO::PARAM_STR);
            $stmt->bindValue(':surname', $address->surname, PDO::PARAM_STR);
            $stmt->bindValue(':line1', $address->line1, PDO::PARAM_STR);
            $stmt->bindValue(':line2', $address->line2, PDO::PARAM_STR);
            $stmt->bindValue(':line3', $address->line3, PDO::PARAM_STR);
            $stmt->bindValue(':town', $address->town, PDO::PARAM_STR);
            $stmt->bindValue(':postcode', $address->postcode, PDO::PARAM_STR);
            $stmt->bindValue(':country', $address->country, PDO::PARAM_STR);
            $stmt->bindValue(':account', $address->account, PDO::PARAM_STR);
            $stmt->execute();

            $last_id = $con->lastInsertId();

            $address = Address::getAddress($con, $last_id);

            return $address;
        } catch (\Exception | PDOException $th) {
            echo 'hello';
            return $th;
        }
    }


}


// Data Transfer Obect class to act as interface for user generated content to populate address entity in the system
class AddressDTO
{
    function __construct($obj)
    {
        if (isset($obj['id'])) {
            $this->id = $obj['id'];
        }
        $this->forename = $obj['forename'];
        $this->surname = $obj['surname'];
        $this->line1 = $obj['line1'];
        $this->line2 = $obj['line2'];
        $this->line3 = $obj['line3'];
        $this->town = $obj['town'];
        $this->postcode = $obj['postcode'];
        $this->country = $obj['country'];
        $this->account = $obj['account'];
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