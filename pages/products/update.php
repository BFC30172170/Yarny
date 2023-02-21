<?php
include '../../inc/inc_head.php';
include '../../lib/products.php';

if(isset($_POST['submit'])){
    $product = new ProductDTO($_POST);
    updateProduct($con, $product);
}
?>

<?php
if(isset($_GET['id'])){
    $product = getProduct($con, $_GET['id']);
}

?>

<form action="" method="POST" class="flex flex-col">
    <label for="name">Name</label>
    <input type="text" name="name" value="<?=$product->name?>"/>

    <label for="id">id</label>
    <input type="text" name="id" value="<?=$product->id?>"/>

    <label for="slug">Slug</label>
    <input type="text" name="slug" value="<?=$product->slug?>"/>

    <label for="description">Description</label>
    <input type="text" name="description" value="<?=$product->description?>"/>

    <label for="price">Price</label>
    <input type="text" name="price" value="<?=$product->price?>"/>

    <label for="image">Image</label>
    <input type="text" name="image" value="<?=$product->image?>"/>

    <label for="category">Category</label>
    <input type="text" name="category" value="<?=$product->category?>"/>

    <label for="active">Active</label>
    <input type="text" name="active" value="<?=$product->active?>"/>

    <button name="submit">Submit</button>
</form>