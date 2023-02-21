<?php
include 'inc_head.php';
include 'lib/products.php';

if(isset($_POST['submit'])){
    $product = new ProductDTO($_POST);
    createProduct($con, $product);
}
?>

<form action="" method="POST" class="flex flex-col">
    <label for="name">Name</label>
    <input type="text" name="name" value="name field"/>

    <label for="slug">Slug</label>
    <input type="text" name="slug" value="slug field"/>

    <label for="description">Description</label>
    <input type="text" name="description" value="desc field"/>

    <label for="price">Price</label>
    <input type="text" name="price" value="0.99"/>

    <label for="image">Image</label>
    <input type="text" name="image" value="https://plus.unsplash.com/premium_photo-1670839413394-f89f6c971bab?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80"/>

    <label for="category">Category</label>
    <input type="text" name="category" value="1"/>

    <label for="active">Active</label>
    <input type="text" name="active" value="1"/>

    <button name="submit">Submit</button>
</form>