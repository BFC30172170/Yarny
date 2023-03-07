<?php


class Review {
        function __construct(PDO $con, $obj){
            if (isset($obj['REVIEW_ID'])){
            $this->id = $obj['REVIEW_ID'];
            $this->name = $obj['REVIEW_NAME'];
            $this->description = $obj['REVIEW_DESCRIPTION'];
            $this->score = $obj['REVIEW_SCORE'];
            $this->created = $obj['REVIEW_CREATED'];
            $this->active = $obj['REVIEW_ACTIVE'];
            $this->product = $obj['PRODUCT_ID'];
            $this->account = $obj['ACCOUNT_ID'];
            }
        }
        public $id;
        public $name;
        public $description;
        public $score;
        public $created;
        public $active;
        public $product;
        public $account;
    }

    function getAccountReviews(PDO $con, $accountId){
        $sql = "SELECT * FROM review WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$accountId,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $reviews = array();
           foreach ($results as $result) {
            $review = new Review($con, $result);
            array_push($reviews,$review);
           }
           return $reviews;
        };
    };
