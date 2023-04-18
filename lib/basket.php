<?php
// A Basket is the system's representation of a sale in a preparotary state, waiting for purchase
class Basket
{
    // Constructed by supplying the systems session variable to populate.
    function __construct($obj)
    {
        if (isset($obj['basket'])) {
            $this->productIds = $obj['basket'];
        } else {
            $this->productIds = array();
        }
        if (isset($obj['address'])) {
            $this->addressId = $obj['address'];
        }
        if (isset($obj['id'])) {
            $this->accountId = $obj['id'];
        }
    }
    public $productIds;
    public $products;
    public $addressId;
    public $accountId;

    // Pass in the id of an object to add it to the basket
    function addToBasket($id)
    {
        array_push($this->productIds, $id);
    }
    function removeFromBasket($id)
    {
        foreach ($this->productIds as $key => $product) {
            if($id == $product){
                unset($this->productIds["$key"]);
            break;
            }
        }
    }

    // Pass in the id of an address to add it as the prospective delivery addresss
    function addAddress($id)
    {
        $this->addressId = $id;
    }

    // Pass in a DB reference and return the products of this basket
    function getBasketProducts(PDO $con)
    {
        $this->products = array();
        foreach ($this->productIds as $id) {
            $product = Product::getProduct($con, $id);
            array_push($this->products, $product);
        }
        return $this->products;
    }

    // Return the total price of objects in this basket
    function getBasketSummary()
    {
        $amount = 0;
        foreach ($this->products as $product) {
            $amount = $amount + $product->price;
        }
        return $amount;
    }

    // Return the total price of packaging and delivery of objects in this basket. set at 1.70 per item
    function getBasketPackaging()
    {
        $amount = 0;
        foreach ($this->products as $product) {
            $amount = $amount + 1.70;
        }
        return $amount;
    }
}