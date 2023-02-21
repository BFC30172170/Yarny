<?php
 function getCategories(PDO $con){
    $sql = 'with recursive cte (CATEGORY_ID, CATEGORY_NAME, PARENT_ID) as (SELECT CATEGORY_ID, CATEGORY_NAME, PARENT_ID FROM category WHERE PARENT_ID IS NULL UNION ALL SELECT p.CATEGORY_ID, p.CATEGORY_NAME, p.PARENT_ID FROM category p INNER JOIN cte on p.PARENT_ID = cte.CATEGORY_ID) SELECT * FROM cte;';
    $stmt = $con->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() == 0){
        return [];
    }else{
       $results = $stmt->fetchAll();
       return $results;
    };
 }

 function getParentCategories(PDO $con,$id){
    $sql = 'with recursive cte (CATEGORY_ID, CATEGORY_NAME, PARENT_ID) as (SELECT CATEGORY_ID, CATEGORY_NAME, PARENT_ID FROM category WHERE CATEGORY_ID=:id UNION ALL SELECT p.CATEGORY_ID,p.CATEGORY_NAME,p.PARENT_ID FROM category p INNER JOIN cte on p.CATEGORY_ID = cte.PARENT_ID) SELECT * FROM cte ORDER BY CATEGORY_ID ASC;';
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() == 0){
        return [];
    }else{
       $results = $stmt->fetchAll();
       return $results;
    };
 }

?>