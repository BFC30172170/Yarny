<?php

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
        $this->products = array();
        foreach ($this->productIds as $id ) {
            $product = Product::getProduct($con, $id);
            array_push($this->products,$product);
        }
        return $this->products;
    }
    public $productIds;
    public $products;
    }
    