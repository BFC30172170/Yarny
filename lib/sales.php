<?php

include_once 'account.php';
include_once 'address.php';

class Sale {
        function __construct(PDO $con, $obj){
            if (isset($obj['SALE_ID'])){
            $this->id = $obj['SALE_ID'];
            $this->created = $obj['SALE_CREATED'];
            $this->processed = $obj['SALE_PROCESSED'];
            $this->dispatched = $obj['SALE_DISPATCHED'];
            $this->estimatedArrival = $obj['SALE_ESTIMATED_ARRIVAL'];
            $this->status = $obj['SALE_STATUS'];
            $this->account = $obj['ACCOUNT_ID'];
            $this->address = getAddress($con,$obj['ADDRESS_ID']);
            $this->saleRows = getSaleSaleRows($con, $obj['SALE_ID']);
            }
        }
        public $id;
        public $created;
        public $processed;
        public $dispatched;
        public $estimatedArrival;
        public $status;
        public $account;
        public $address;
        public $saleRows;
    }

    class SaleRow {
        function __construct(PDO $con, $obj){
            if (isset($obj['SR_ID'])){
            $this->id = $obj['SR_ID'];
            $this->originalPrice = $obj['SR_ORIG_PRICE'];
            $this->finalPrice = $obj['SR_FINAL_PRICE'];
            $this->quantity = $obj['SR_QUANTITY'];
            $this->sale = $obj['SALE_ID'];
            $this->product = $obj['PRODUCT_ID'];
            }
        }
        public $id;
        public $originalPrice;
        public $finalPrice;
        public $quantity;
        public $sale;
        public $product;
    }

    function getAccountSales(PDO $con, $accountId){
        $sql = "SELECT * FROM sale WHERE ACCOUNT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$accountId,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $sales = array();
           foreach ($results as $result) {
            $sale = new Sale($con, $result);
            array_push($sales,$sale);
           }
           return $sales;
        };
    };

    function getSale(PDO $con, $id){
        $sql = "SELECT * FROM sale WHERE SALE_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $result = $results[0];
           $sale = new Sale($con, $result);
           return $sale;
        };
    };

    function getSaleSaleRows(PDO $con, $saleId){
        $sql = "SELECT * FROM Sale_row WHERE SALE_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$saleId,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $saleRows = array();
           foreach ($results as $result) {
            $saleRow = new SaleRow($con, $result);
            array_push($saleRows,$saleRow);
           }
           return $saleRows;
        };
    };
