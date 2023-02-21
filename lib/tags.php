<?php
    class Tag {
        function __construct(PDO $con, $obj){
            if (isset($obj['TAG_ID'])){
            $this->id = $obj['TAG_ID'];
            $this->name = $obj['TAG_NAME'];
            $this->description = $obj['TAG_DESCRIPTION'];
        };
    }
        public $id;
        public $name;
        public $description;
    }

 function getProductTags(PDO $con, $id){
    $sql = 'SELECT * FROM Product_tag pt INNER JOIN Tag t on pt.TAG_ID = t.TAG_ID WHERE pt.PRODUCT_ID = :id';
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() == 0){
        return [];
    }else{
       $results = $stmt->fetchAll();
           $tags = array();
           foreach ($results as $result) {
            $tag= new Tag($con, $result);
            array_push($tags,$tag);
           }
           return $tags;
    };
 }
?>