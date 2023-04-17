<?php
// A Query is a representational object used to convert a url query string into a product query for the ecommerce database
class Query
{
    // Construct a query from a url query string
    function __construct($queryString)
    {
        $queries = array();
        parse_str($queryString, $queries);
        $this->category = array_key_exists('category', $queries) && !empty($queries['category']) ? $queries['category'] : null;
        $this->tags = array_key_exists('tag', $queries) && !empty($queries['tag']) ? explode(',', $queries['tag']) : null;
        $this->sort = array_key_exists('sort', $queries) ? $queries['sort'] : 'PRODUCT_ID';
        $this->order = array_key_exists('order', $queries) ? $queries['order'] : 'ASC';
        $this->search = array_key_exists('search', $queries) && !empty($queries['search']) ? '%' . $queries['search'] . '%' : null;
        $this->active = true;
    }
    public $category;
    public $tags;
    public $sort;
    public $order;
    public $search;
    public $active;

    // Construct a mySQL query from the Query's properties
    function constructQuery($con)
    {
        // Select Products
        $str = 'SELECT DISTINCT p.* FROM Product p';

        // If Tags are applied, inner join them
        if (isset($this->tags)) {
            $str = $str . ' INNER JOIN Product_tag pt ON p.PRODUCT_ID = pt.PRODUCT_ID AND pt.TAG_ID IN (';
            foreach ($this->tags as $key => $tag) {
                $str = $str . ':tag' . $tag;
                if ($key !== array_key_last($this->tags)) {
                    $str = $str . ',';
                }

            }
            $str .= ')';
        }
        ;

        // If category is applied, inner join it on children or grandchildren
        if (isset($this->category)) {
            $allCategoryIDs = array($this->category);
            $allCategories = Category::getChildCategories($con, $this->category);
            foreach ($allCategories as $key => $childCat) {
                array_push($allCategoryIDs, $childCat->id);
                foreach ($childCat->children as $key => $grandChildCat) {
                    array_push($allCategoryIDs, $grandChildCat->id);
                }
            }

            $str = $str . ' INNER JOIN Category c ON p.CATEGORY_ID IN(';
            foreach ($allCategoryIDs as $key => $cat) {
                $str = $str . ':cat' . $cat;
                if ($key !== array_key_last($allCategoryIDs)) {
                    $str = $str . ',';
                }

            }
            $str .= ')';
        }
        ;

        // Begin Where clause
        $str = $str . ' WHERE 1=1';

        // If Search is applied, search on name and description
        if (isset($this->search)) {
            $str = $str . ' AND (p.PRODUCT_NAME LIKE :search OR p.PRODUCT_DESCRIPTION LIKE :search)';
        }
        ;

        if ($this->active) {
            $str = $str . ' AND (p.PRODUCT_ACTIVE = 1)';
        }

        // Order desc or asc, ASC by default
        if (isset($this->order)) {
            if ($this->order == 'asc') {
                $str = $str . ' ORDER BY p.PRODUCT_ID ASC';
            } else {
                $str = $str . ' ORDER BY p.PRODUCT_ID DESC';
            }
        }
        ;

        // Finish Query and Bind values
        $str = $str . ';';
        $stmt = $con->prepare($str);
        if (isset($this->tags)) {
            foreach ($this->tags as $key => $tag) {
                $tagInstance = ':tag' . $tag;
                $stmt->bindValue($tagInstance, $tag, PDO::PARAM_INT);
            }

        }
        ;

        if (isset($this->category)) {
            foreach ($allCategoryIDs as $key => $cat) {
                $catInstance = ':cat' . $cat;
                $stmt->bindValue($catInstance, $cat, PDO::PARAM_INT);
            }
        }

        if (isset($this->search)) {
            $stmt->bindValue(':search', $this->search, PDO::PARAM_STR);
        }
        return $stmt;
    }
}

?>