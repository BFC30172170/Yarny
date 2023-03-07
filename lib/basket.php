<?php
include_once 'products.php';

class Basket{
    function __construct($obj){
        if(isset($obj['basket'])){
            $this->productIds = $obj['basket'];
        }else{
            $this->productIds = array();
        }
        $this->products = array();
    }

    function addToBasket($id){
        array_push($this->productIds,$id);
    }

    function getBasketProducts (PDO $con){
        foreach ($this->productIds as $id ) {
            $product = getProduct($con, $id);
            array_push($this->products,$product);
        }
        return $this->products;
    }
    public $productIds;
    public $products;
    }
    