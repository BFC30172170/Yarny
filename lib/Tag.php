<?php
class Tag
{
    function __construct(PDO $con, $obj)
    {
        if (isset($obj['TAG_ID'])) {
            $this->id = $obj['TAG_ID'];
            $this->name = $obj['TAG_NAME'];
            $this->description = $obj['TAG_DESCRIPTION'];
        };
    }
    public $id;
    public $name;
    public $description;
    static function getTags(PDO $con)
    {
        $sql = 'SELECT * FROM Tag;';
        $stmt = $con->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $tags = array();
            foreach ($results as $result) {
                $tag = new Tag($con, $result);
                array_push($tags, $tag);
            }
            return $tags;
        };
    }

    // Get a single product by ID
static function getTag(PDO $con, $id)
{
    $sql = "SELECT * FROM tag WHERE TAG_ID = :id;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        return [];
    }
    else {
        $results = $stmt->fetchAll();
        $result = $results[0];
        $tag = new Tag($con, $result);
        if ($tag) {
            return $tag;
        }
        else {
            return null;
        }
    }
    ;
}


    static function getProductTags(PDO $con, $id)
    {
        $sql = 'SELECT * FROM Product_tag pt INNER JOIN Tag t on pt.TAG_ID = t.TAG_ID WHERE pt.PRODUCT_ID = :id';
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            return [];
        } else {
            $results = $stmt->fetchAll();
            $tags = array();
            foreach ($results as $result) {
                $tag = new Tag($con, $result);
                array_push($tags, $tag);
            }
            return $tags;
        };
    }

    // Create a tag with form data
    static function createTag(PDO $con, TagDTO $tag)
    {
        try {
            $sql = "INSERT INTO tag(TAG_NAME,TAG_DESCRIPTION) VALUES (:name,:description);";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':name', $tag->name, PDO::PARAM_STR);
            $stmt->bindValue(':description', $tag->description, PDO::PARAM_STR);
            $stmt->execute();

            $last_id = $con->lastInsertId();

            $tag = Tag::getTag($con, $last_id);

            return $tag;
        } catch (\Exception | PDOException $th) {
            echo 'hello';
            return $th;
        }
    }

    static function deleteTag(PDO $con, $id)
    {
        $sql = "DELETE FROM Product_tag WHERE TAG_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $sql = "DELETE FROM Tag WHERE TAG_ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        return 'deleted';
    }
}

class TagDTO
{
    function __construct($obj)
    {
        $this->name = $obj['name'];
        $this->description = $obj['description'];

    }
    public $name;
    public $description;
}


