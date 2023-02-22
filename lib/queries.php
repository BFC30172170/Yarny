<?php
include_once('tags.php');
include_once('categories.php');

class Query{
    function __construct($queryString){
        $queries= array();
        parse_str($queryString, $queries);
        $this->category = array_key_exists('category',$queries) ? $queries['category']: null;
        $this->tags = array_key_exists('tag',$queries) ? explode(',',$queries['tag']) : null;
        $this->sort = array_key_exists('sort',$queries) ? $queries['sort'] : 'PRODUCT_ID';
        $this->order = array_key_exists('order',$queries) ? $queries['order'] : 'ASC';
        $this->search = array_key_exists('search',$queries) ? '%'.$queries['search'].'%' : null;
    }
    public $category;
    public $tags;
    public $sort;
    public $order;
    public $search;

    function constructQuery($con){
        $str = 'SELECT DISTINCT p.* FROM Product p';
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
        if(isset($this->category)){
            $str = $str.' INNER JOIN Category c ON p.CATEGORY_ID = :category';
        };

        if(isset($this->search)){
            $str = $str.' WHERE p.PRODUCT_NAME LIKE :search';
        };

        if(isset($this->order)){
            if($this->order == 'asc'){
                $str = $str.' ORDER BY p.PRODUCT_ID ASC';
            }else{
                $str = $str.' ORDER BY p.PRODUCT_ID DESC';
            }
        };

        $str = $str.';';
        $stmt = $con->prepare($str);
        if(isset($this->tags)){
            foreach ($this->tags as $key => $tag){
                $tagInstance = ':tag'.$tag;
                $stmt->bindValue($tagInstance,$tag,PDO::PARAM_INT);
            }

        };

        var_dump($stmt);

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