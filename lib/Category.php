<?php

class Category {
   function __construct(PDO $con, $obj){
       if (isset($obj['CATEGORY_ID'])){
       $this->id = $obj['CATEGORY_ID'];
       $this->name = $obj['CATEGORY_NAME'];
       $this->description = $obj['CATEGORY_DESCRIPTION'];
       $this->parent = $obj['PARENT_ID'];
   };
}
   public $id;
   public $name;
   public $description;
   public $parent;

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
   
    static function getCategories(PDO $con){
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
}



?>