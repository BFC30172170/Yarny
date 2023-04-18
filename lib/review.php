<?php

// A Review is the opinion of a customer with regards to a product.
class Review
{
    // Construct a review with reference to the ecommerce database, and columns returned
    function __construct(PDO $con, $obj)
    {
        if (isset($obj['REVIEW_ID'])) {
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

    //Get All Reviews
    static function getReviews(PDO $con, $accountId)
    {
        $sql = "SELECT * FROM review";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $reviews = array();
            foreach ($results as $result) {
                $review = new Review($con, $result);
                array_push($reviews, $review);
            }
            return $reviews;
        }
        ;
    }

    // Get a single review by ID
    static function getReview(PDO $con, $id)
    {
        $sql = "SELECT * FROM review WHERE REVIEW_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $result = $results[0];
            $review = new Review($con, $result);
            if ($review->active == true) {
                return $review;
            } else {
                return $review;
            }
        }
        ;
    }

    // Pass in DB reference and account id to return all reviews for a specific accounts
    static function getAccountReviews(PDO $con, $accountId)
    {
        $sql = "SELECT * FROM review WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $accountId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $reviews = array();
            foreach ($results as $result) {
                $review = new Review($con, $result);
                array_push($reviews, $review);
            }
            return $reviews;
        }
        ;
    }

    // Pass in DB reference a product id to return all reviews for a specific accounts
    static function getProductReviews(PDO $con, $productId)
    {
        $sql = "SELECT * FROM review WHERE PRODUCT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $reviews = array();
            foreach ($results as $result) {
                $review = new Review($con, $result);
                array_push($reviews, $review);
            }
            return $reviews;
        }
        ;
    }

    // Pass in DB reference and a PDO and create and return the review
    static function createReview(PDO $con, ReviewDTO $review)
    {
        try {
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO review (REVIEW_NAME,REVIEW_DESCRIPTION,REVIEW_SCORE,REVIEW_CREATED,REVIEW_ACTIVE,PRODUCT_ID,ACCOUNT_ID) VALUES (:name,:description,:score,:created,:active,:product,:account);";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':name', $review->name, PDO::PARAM_STR);
            $stmt->bindValue(':description', $review->description, PDO::PARAM_STR);
            $stmt->bindValue(':score', $review->score, PDO::PARAM_INT);
            $stmt->bindValue(':created', $date, PDO::PARAM_STR);
            $stmt->bindValue(':active', $review->active, PDO::PARAM_BOOL);
            $stmt->bindValue(':product', $review->product, PDO::PARAM_INT);
            $stmt->bindValue(':account', $review->account, PDO::PARAM_INT);
            $stmt->execute();
            $last_id = $con->lastInsertId();

            $review = Review::getReview($con, $last_id);

            return $review;
        } catch (\Exception | PDOException $th) {
            echo 'hello';
            return $th;
        }
    }
}

// Data Transfer Obect class to act as interface for user generated content to populate review entity in the system
class ReviewDTO
{
    function __construct($obj)
    {
        $this->name = $obj['name'];
        $this->description = $obj['description'];
        $this->score = $obj['score'];
        $this->active = $obj['active'];
        $this->product = $obj['product'];
        $this->account = $obj['account'];
    }
    public $name;
    public $description;
    public $score;
    public $created;
    public $active;
    public $product;
    public $account;
}