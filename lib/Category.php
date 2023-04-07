<?php

class Category {
   function __construct(PDO $con, $obj){
       if (isset($obj['CATEGORY_ID'])){
       $this->id = $obj['CATEGORY_ID'];
       $this->name = $obj['CATEGORY_NAME'];
       $this->description = $obj['CATEGORY_DESCRIPTION'];
       $this->parent = $obj['PARENT_ID'];
       $this->children = Category::getChildCategories($con, $this->id);
   };
}
   public $id;
   public $name;
   public $description;
   public $parent;
   public $children;

   static function getCategory(PDO $con, $id){
      $sql = "SELECT * FROM Category WHERE CATEGORY_ID = :id;";
      $stmt = $con->prepare($sql);
      $stmt->bindValue(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
      if ($stmt->rowCount() == 0){
          return [];
      }else{
         $results = $stmt->fetchAll();
         $result = $results[0];
         $product = new Category($con, $result);
         return $product;
      };
   }

   static function getCategoryList(PDO $con){
      $sql = 'SELECT * FROM Category;';
      $stmt = $con->prepare($sql);
      $stmt->execute();
      if ($stmt->rowCount() == 0){
          return [];
      }else{
         $results = $stmt->fetchAll();
         $cats = array();
         foreach ($results as $result) {
          $cat= new Category($con, $result);
          array_push($cats,$cat);
         }
         return $cats;
      };
   }
   
    static function getCategories(PDO $con){
       $sql = 'SELECT * FROM Category WHERE PARENT_ID IS NULL;';
       $stmt = $con->prepare($sql);
       $stmt->execute();
       if ($stmt->rowCount() == 0){
           return [];
       }else{
          $results = $stmt->fetchAll();
          $cats = array();
          foreach ($results as $result) {
           $cat= new Category($con, $result);
           array_push($cats,$cat);
          }
          return $cats;
       };
    }
   
    static function getParentCategories(PDO $con,$id){
       $sql = 'with recursive cte (CATEGORY_ID, CATEGORY_NAME, CATEGORY_DESCRIPTION, PARENT_ID) as (SELECT CATEGORY_ID, CATEGORY_NAME, CATEGORY_DESCRIPTION, PARENT_ID FROM category WHERE CATEGORY_ID=:id UNION ALL SELECT p.CATEGORY_ID,p.CATEGORY_NAME,p.CATEGORY_DESCRIPTION,p.PARENT_ID FROM category p INNER JOIN cte on p.CATEGORY_ID = cte.PARENT_ID) SELECT * FROM cte ORDER BY CATEGORY_ID ASC;';
       $stmt = $con->prepare($sql);
       $stmt->bindValue(':id',$id,PDO::PARAM_INT);
       $stmt->execute();
       if ($stmt->rowCount() == 0){
           return [];
       }else{
          $results = $stmt->fetchAll();
          $cats = array();
          foreach ($results as $result) {
           $cat= new Category($con, $result);
           array_push($cats,$cat);
          }
          return $cats;
       };
    }

    static function getChildCategories(PDO $con,$id){
      $sql = 'SELECT * FROM Category WHERE PARENT_ID = :id;';
      $stmt = $con->prepare($sql);
      $stmt->bindValue(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
      if ($stmt->rowCount() == 0){
          return [];
      }else{
         $results = $stmt->fetchAll();
         $cats = array();
         foreach ($results as $result) {
          $cat= new Category($con, $result);
          array_push($cats,$cat);
         }
         return $cats;
      };
   }

    static function createCategory(PDO $con, CategoryDTO $cat)
    {
        try {
            $sql = "INSERT INTO category (CATEGORY_NAME,CATEGORY_DESCRIPTION,PARENT_ID) VALUES (:name,:description,:parent);";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':name', $cat->name, PDO::PARAM_STR);
            $stmt->bindValue(':description', $cat->description, PDO::PARAM_STR);
            if ($cat->parent == 0){
               $stmt->bindValue(':parent',null, PDO::PARAM_NULL);
            }else{
            $stmt->bindValue(':parent', $cat->parent, PDO::PARAM_INT);
            }
            $stmt->execute();

            $last_id = $con->lastInsertId();

            $tag = Category::getCategory($con, $last_id);

            return $tag;
        } catch (\Exception | PDOException $th) {
            echo 'hello';
            var_dump($th);
            return $th;
        }
    }

    static function deleteCategory(PDO $con, $id)
{
    $sql = "UPDATE product SET CATEGORY_ID = NULL WHERE CATEGORY_ID = :id;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "DELETE FROM category WHERE CATEGORY_ID = :id;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return 'deleted';
}
}

class CategoryDTO
{
    function __construct($obj)
    {
        $this->name = $obj['name'];
        $this->description = $obj['description'];
        $this->parent = $obj['parent'];

    }
    public $name;
    public $description;
    public $parent;
}
