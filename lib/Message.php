<?php
//A Sale is the system's representation of a customer's communication to the owner
class Message
{
    // Construct a message with reference to the ecommerce database, and columns returned
    function __construct(PDO $con, $obj)
    {
        if (isset($obj['MESSAGE_ID'])) {
            $this->id = $obj['MESSAGE_ID'];
            $this->name = $obj['MESSAGE_NAME'];
            $this->description = $obj['MESSAGE_DESCRIPTION'];
            $this->created = $obj['MESSAGE_CREATED'];
            $this->account = $obj['ACCOUNT_ID'];
        }
    }
    public $id;
    public $name;
    public $created;
    public $description;
    public $account;

    function sendMessage($con)
    {
        $account = Account::getAccount($con,$this->account);
        $to_email = "$account->email";
        $subject = "YARNY - message #$this->id recieved";
        $body = "Hi $account->username, Thanks for sending us a message, we'll be in touch within 5 business days";
        $headers = "From: YARNY@testemail.com";
        set_error_handler(function() { /* ignore errors */ });
        if (mail($to_email, $subject, $body, $headers)) {
            echo "Email successfully sent to $to_email.";
        }
        else{
           throw new Exception('error');
        }
        restore_error_handler();
    }

    // Pass in DB reference and account id to return all messages for a specific accounts
    static function getAccountMessages(PDO $con, $accountId)
    {
        $sql = "SELECT * FROM message WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $accountId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        }
        else {
            $results = $stmt->fetchAll();
            $messages = array();
            foreach ($results as $result) {
                $message = new Message($con, $result);
                array_push($messages, $message);
            }
            return $messages;
        }
        ;
    }

    // Pass in DB reference and id to return single message
    static function getMessage(PDO $con, $id)
    {
        $sql = "SELECT * FROM message WHERE MESSAGE_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        }
        else {
            $results = $stmt->fetchAll();
            $result = $results[0];
            $message = new Message($con, $result);
            return $message;
        }
        ;
    }

    // Pass in DB reference and Basket to create and return a single sale and all respective sale rows.
    static function createMessage(PDO $con, MessageDTO $message)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO message (MESSAGE_NAME,MESSAGE_DESCRIPTION,MESSAGE_CREATED,ACCOUNT_ID) VALUES (:name,:desc,:date,:account);";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->bindValue(':account', $message->accountId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $message->name, PDO::PARAM_STR);
        $stmt->bindValue(':desc', $message->description, PDO::PARAM_STR);
        $stmt->execute();
        $messageId = $con->lastInsertId();

        $messageResponse = Message::getMessage($con, $messageId);

        return $messageResponse;
    }

}

// Data Transfer Obect class to act as interface for user generated content to populate message entity in the system
class messageDTO
{
    function __construct($obj)
    {
        $this->name = $obj['name'];
        $this->description = $obj['description'];
        $this->accountId = $obj['accountId'];
    }
    public $name;
    public $description;
    public $accountId;
}