<?php

class Basket{
    function __construct($obj){
        if(isset($obj['basket'])){
            $this->productIds = $obj['basket'];
        }else{
            $this->productIds = array();
        }
        if(isset($obj['address'])){
            $this->addressId = $obj['address'];
        }
    }

    function addToBasket($id){
        array_push($this->productIds,$id);
    }

    function addAddress($id){
        $this->addressId = $id;
    }

    function getBasketProducts (PDO $con){
        $this->products = array();
        foreach ($this->productIds as $id ) {
            $product = Product::getProduct($con, $id);
            array_push($this->products,$product);
        }
        return $this->products;
    }

    function getBasketSummary (){
        $amount = 0;
        foreach ($this->products as $product) {
            $amount = $amount + $product->price;
        }
        return $amount;
    }

    function getBasketPackaging (){
        $amount = 0;
        foreach ($this->products as $product) {
            $amount = $amount + 1.70;
        }
        return $amount;
    }
    public $productIds;
    public $products;
    public $addressId;
    }
    