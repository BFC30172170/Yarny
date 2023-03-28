<?php

class Query{
    function __construct($queryString){
        $queries= array();
        parse_str($queryString, $queries);
        $this->category = array_key_exists('category',$queries) && !empty($queries['category']) ? $queries['category']: null;
        $this->tags = array_key_exists('tag',$queries) && !empty($queries['tag']) ? explode(',',$queries['tag']) : null;
        $this->sort = array_key_exists('sort',$queries) ? $queries['sort'] : 'PRODUCT_ID';
        $this->order = array_key_exists('order',$queries) ? $queries['order'] : 'ASC';
        $this->search = array_key_exists('search',$queries) && !empty($queries['search']) ? '%'.$queries['search'].'%' : null;
        $this->active = true;
    }
    public $category;
    public $tags;
    public $sort;
    public $order;
    public $search;

    function constructQuery($con){
        // Select Products
        $str = 'SELECT DISTINCT p.* FROM Product p';
        // If Tags are applied, inner join them
        if(isset($this->tags)){
            $str = $str.' INNER JOIN Product_tag pt ON p.PRODUCT_ID = pt.PRODUCT_ID AND pt.TAG_ID IN (';
            foreach ($this->tags as $key => $tag){
                $str = $str.':tag'.$tag;
                if($key !== array_key_last($this->tags)){
                    $str = $str.',';
                }

            }
            $str .= ')';
        };
        // If category is applied, inner join it
        if(isset($this->category)){
            $str = $str.' INNER JOIN Category c ON p.CATEGORY_ID = :category';
        };

        $str = $str.' WHERE 1=1';

        // If Search is applied, search on name and description
        if(isset($this->search)){
            $str = $str.' AND (p.PRODUCT_NAME LIKE :search OR p.PRODUCT_DESCRIPTION LIKE :search)';
        };

        if($this->active){
            $str = $str.' AND (p.PRODUCT_ACTIVE = 1)';
        }

        // Order desc or asc, ASC by default
        if(isset($this->order)){
            if($this->order == 'asc'){
                $str = $str.' ORDER BY p.PRODUCT_ID ASC';
            }else{
                $str = $str.' ORDER BY p.PRODUCT_ID DESC';
            }
        };

        // Bind values
        $str = $str.';';
        $stmt = $con->prepare($str);
        if(isset($this->tags)){
            foreach ($this->tags as $key => $tag){
                $tagInstance = ':tag'.$tag;
                $stmt->bindValue($tagInstance,$tag,PDO::PARAM_INT);
            }

        };

        if(isset($this->category)){
        $stmt->bindValue(':category',$this->category,PDO::PARAM_INT);
        }

        if(isset($this->search)){
            $stmt->bindValue(':search',$this->search,PDO::PARAM_STR);
            }
        return $stmt;
    }
}

?>