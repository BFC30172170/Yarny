<?php
include_once 'categories.php';
include_once 'tags.php';
include_once 'queries.php';

    class Product {
        function __construct(PDO $con, $obj){
            if (isset($obj['PRODUCT_ID'])){
            $this->id = $obj['PRODUCT_ID'];
            $this->name = $obj['PRODUCT_NAME'];
            $this->slug = $obj['PRODUCT_SLUG'];
            $this->description = $obj['PRODUCT_DESCRIPTION'];
            $this->price = $obj['PRODUCT_PRICE'];
            $this->image = $obj['PRODUCT_IMG_PATH'];
            $this->category = $obj['CATEGORY_ID'];
            $this->categories = getParentCategories($con, $obj['CATEGORY_ID']);
            $this->tags = getProductTags($con, $obj['PRODUCT_ID']);
            $this->active = $obj['PRODUCT_ACTIVE'] === 1 ? true : false;
            }
        }
        public $id;
        public $name;
        public $slug;
        public $description;
        public $price;
        public $image;
        public $category;
        public $categories;
        public $active;
    }

    class ProductDTO {
        function __construct($obj){
            $this->id = $obj['id'];
            $this->name = $obj['name'];
            $this->slug = $obj['slug'];
            $this->description = $obj['description'];
            $this->price = $obj['price'];
            $this->image = $obj['image'];
            $this->category = $obj['category'];
            $this->active = $obj['active'];
        }
        public $id;
        public $name;
        public $slug;
        public $description;
        public $price;
        public $image;
        public $category;
        public $active;
    }

    function getProducts(PDO $con, Query $qry){
        $stmt = $qry->constructQuery($con);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $products = array();
           foreach ($results as $result) {
            $product = new Product($con, $result);
            array_push($products,$product);
           }
           return $products;
        };
    };


    function getProduct(PDO $con, $id){
        $sql = "SELECT * FROM product WHERE PRODUCT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            return [];
        }else{
           $results = $stmt->fetchAll();
           $result = $results[0];
           $product = new Product($con, $result);
           return $product;
        };
    };

    function createProduct(PDO $con, ProductDTO $product){
        $sql = "INSERT INTO product (PRODUCT_NAME,PRODUCT_SLUG,PRODUCT_DESCRIPTION,PRODUCT_PRICE,PRODUCT_IMG_PATH,CATEGORY_ID,PRODUCT_ACTIVE) VALUES (:name,:slug,:description,:price,:image,:category,:active);";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':name',$product->name,PDO::PARAM_STR);
        $stmt->bindValue(':slug',$product->slug,PDO::PARAM_STR);
        $stmt->bindValue(':description',$product->description,PDO::PARAM_STR);
        $stmt->bindValue(':price',$product->price,PDO::PARAM_STR);
        $stmt->bindValue(':image',$product->image,PDO::PARAM_STR);
        $stmt->bindValue(':category',$product->category,PDO::PARAM_INT);
        $stmt->bindValue(':active',$product->active,PDO::PARAM_BOOL);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    };

    function updateProduct(PDO $con, ProductDTO $product){
        var_dump($product);
        $sql = "UPDATE product SET PRODUCT_NAME = :name, PRODUCT_SLUG = :slug, PRODUCT_DESCRIPTION = :description ,PRODUCT_PRICE = :price ,PRODUCT_IMG_PATH = :image, CATEGORY_ID = :category, PRODUCT_ACTIVE = :active WHERE PRODUCT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$product->id,PDO::PARAM_INT);
        $stmt->bindValue(':name',$product->name,PDO::PARAM_STR);
        $stmt->bindValue(':slug',$product->slug,PDO::PARAM_STR);
        $stmt->bindValue(':description',$product->description,PDO::PARAM_STR);
        $stmt->bindValue(':price',$product->price,PDO::PARAM_STR);
        $stmt->bindValue(':image',$product->image,PDO::PARAM_STR);
        $stmt->bindValue(':category',$product->category,PDO::PARAM_INT);
        $stmt->bindValue(':active',$product->active,PDO::PARAM_BOOL);
        $stmt->execute();
        $result = $stmt->fetchAll();
    }

    function deleteProduct(PDO $con, $id){
        $sql = "DELETE FROM product WHERE PRODUCT_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    };
?>