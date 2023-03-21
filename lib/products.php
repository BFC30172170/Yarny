<?php
include_once 'categories.php';
include_once 'tags.php';
include_once 'queries.php';

// Product data to be retrieved and manipulated from the database
class Product
{
    function __construct(PDO $con, $obj)
    {
        if (isset($obj['PRODUCT_ID'])) {
            $this->id = $obj['PRODUCT_ID'];
            $this->name = $obj['PRODUCT_NAME'];
            $this->slug = $obj['PRODUCT_SLUG'];
            $this->description = $obj['PRODUCT_DESCRIPTION'];
            $this->price = $obj['PRODUCT_PRICE'];
            $this->image = $obj['PRODUCT_IMG_PATH'];
            $this->category = $obj['CATEGORY_ID'];
            $this->categories = getParentCategories($con, $obj['CATEGORY_ID']);
            $this->tags = getProductTags($con, $obj['PRODUCT_ID']);
            $this->active = $obj['PRODUCT_ACTIVE'] == 1 ? true : false;
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
    public $tags;
    public $active;
}

// DTO to be used for inputting product data
class ProductDTO
{
    function __construct($obj)
    {
        if (isset($obj['id'])) {
            $this->id = $obj['id'];
        }
        $this->name = $obj['name'];
        $this->slug = $obj['slug'];
        $this->description = $obj['description'];
        $this->price = $obj['price'];
        $this->image = $obj['image'];
        $this->category = $obj['category'];
        $this->tags = $obj['tags'];
        $this->active = $obj['active'];
    }
    public $id;
    public $name;
    public $slug;
    public $description;
    public $price;
    public $image;
    public $category;
    public $tags;
    public $active;
}

// Get all Products from a query
function getProducts(PDO $con, Query $qry)
{
    $stmt = $qry->constructQuery($con);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        return [];
    }
    else {
        $results = $stmt->fetchAll();
        $products = array();
        foreach ($results as $result) {
            $product = new Product($con, $result);
            array_push($products, $product);
        }
        return $products;
    }
    ;
}
;

// Get a single product by ID
function getProduct(PDO $con, $id)
{
    $sql = "SELECT * FROM product WHERE PRODUCT_ID = :id;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        return [];
    }
    else {
        $results = $stmt->fetchAll();
        $result = $results[0];
        $product = new Product($con, $result);
        if ($product->active == true) {
            return $product;
        }
        else {
            return $product;
        }
    }
    ;
}
;

// Create a product with form data
function createProduct(PDO $con, ProductDTO $product)
{
    try {
        $sql = "INSERT INTO product (PRODUCT_NAME,PRODUCT_SLUG,PRODUCT_DESCRIPTION,PRODUCT_PRICE,PRODUCT_IMG_PATH,CATEGORY_ID,PRODUCT_ACTIVE) VALUES (:name,:slug,:description,:price,:image,:category,:active);";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':name', $product->name, PDO::PARAM_STR);
        $stmt->bindValue(':slug', $product->slug, PDO::PARAM_STR);
        $stmt->bindValue(':description', $product->description, PDO::PARAM_STR);
        $stmt->bindValue(':price', $product->price, PDO::PARAM_STR);
        $stmt->bindValue(':image', $product->image, PDO::PARAM_STR);
        $stmt->bindValue(':category', $product->category, PDO::PARAM_INT);
        $stmt->bindValue(':active', $product->active, PDO::PARAM_BOOL);
        $stmt->execute();

        $last_id = $con->lastInsertId();

        foreach ($product->tags as $tag) {
            $sql = "INSERT INTO product_tag (PRODUCT_ID,TAG_ID) VALUES (:product,:tag)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':product', $last_id, PDO::PARAM_INT);
            $stmt->bindValue(':tag', $tag, PDO::PARAM_INT);
            $stmt->execute();
        }

        $product = getProduct($con, $last_id);

        return $product;
    }
    catch (\Exception|PDOException $th) {
        echo 'hello';
        return $th;
    }
}
;

// Update an Existing Product with form data
function updateProduct(PDO $con, ProductDTO $product)
{
    $sql = "UPDATE product SET PRODUCT_NAME = :name, PRODUCT_SLUG = :slug, PRODUCT_DESCRIPTION = :description ,PRODUCT_PRICE = :price ,PRODUCT_IMG_PATH = :image, CATEGORY_ID = :category, PRODUCT_ACTIVE = :active WHERE PRODUCT_ID = :id;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id', $product->id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $product->name, PDO::PARAM_STR);
    $stmt->bindValue(':slug', $product->slug, PDO::PARAM_STR);
    $stmt->bindValue(':description', $product->description, PDO::PARAM_STR);
    $stmt->bindValue(':price', $product->price, PDO::PARAM_STR);
    $stmt->bindValue(':image', $product->image, PDO::PARAM_STR);
    $stmt->bindValue(':category', $product->category, PDO::PARAM_INT);
    $stmt->bindValue(':active', $product->active, PDO::PARAM_BOOL);
    $stmt->execute();
    
    $sql = "DELETE FROM product_tag WHERE PRODUCT_ID = :product;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':product', $product->id, PDO::PARAM_INT);
    $stmt->execute();

    foreach ($product->tags as $tag) {
        $sql = "INSERT INTO product_tag (PRODUCT_ID,TAG_ID) VALUES (:product,:tag)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':product', $product->id, PDO::PARAM_INT);
        $stmt->bindValue(':tag', $tag, PDO::PARAM_INT);
        $stmt->execute();
    }

    $product = getProduct($con, $product->id);

    return $product;
}

// Set a Product to Deactivate
function deleteProduct(PDO $con, $id)
{
    $sql = "UPDATE product SET PRODUCT_ACTIVE = 0 WHERE PRODUCT_ID = :id;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
;
?>