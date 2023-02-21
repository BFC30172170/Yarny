<?php
include '../../inc/inc_head.php';
include '../../lib/products.php';
include_once '../../lib/queries.php';
?>


<?php

$query = new Query($_SERVER['QUERY_STRING']);

if(isset($_GET['category'])){
  $cat = getCategory($con,$_GET['category']);
  $cat->id = $_GET['category'];
}else{
  $cat = null;
};
?>

<h1 class="text-3xl"><?= isset($_GET['category']) ? $cat->name : 'Products' ?></h1>


<?php

$products = getProducts($con,$query);
$tags = getTags($con);
$cats = getCategories($con);
?>
<div class="flex">
<div class="flex flex-col w-1/2">
<h2 class="text-xl">Tags</h2>
<?php
foreach($tags as $tag){
?>
<a href="./?tag=<?=$tag->id?>"><?= $tag->name?></a>
<?php
}
?>

<h2 class="text-xl">Categories</h2>
<?php
foreach($cats as $cat){
?>
<a href='./?category=<?=$cat->id?>'><?= $cat->name?></a>
<?php
}
?>
</div>


<div class="grid grid-cols-3 gap-4 w-1/2">
<?php
foreach ($products as $product){
?>

    <a class="flex flex-1 flex-col border border-2 rounded-xl hover:shadow-md transition duration-300" href="./product.php?id=<?=$product->id?>">
    <div class="h-24 w-full relative">
      <img src="<?= $product->image?>" class="h-full w-full object-cover object-center rounded-t-xl">
      <div class="flex absolute bottom-2 left-2">
        <?php
        foreach ($product->tags as $tag) {
        ?>
          <p class="bg-emerald-300 rounded-lg p-1 text-white"><?=$tag->name?></p>
        <?php
        }
        ?>
        </div>

    </div>

        <div class="flex flex-col p-2">
          <h3 class="text-gray-900 text-sm font-medium truncate"><?= $product->name?></h3>
          <p class="mt-1 text-gray-500 text-sm truncate">£<?= $product->price?> <?= $product->description?></p>
        </div>

      </li>
      </a>


<?php
}
?>
</div>
</div>
<?php
include '../../inc/inc_foot.php';
?>
