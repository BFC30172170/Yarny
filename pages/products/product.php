<?php
include '../../inc/inc_head.php';
include '../../lib/products.php';
?>

<?php
if ($_GET['id']) {
  $product = getProduct($con, $_GET['id']);
} else {
  header("Location: http://localhost/fullstacksitetemplate/pages/products");
  die();
};
?>

<script>
  const deleteProduct = (id) => {
    fetch('http://localhost/fullstacksitetemplate/api/products.php?id='+id, {method:'DELETE'});
  }

  const addToBasket = (id) => {
    fetch('http://localhost/fullstacksitetemplate/api/basket.php?productId='+id , {method:'POST'}).then(response => response.json());
  }
</script>


<div class="bg-white">
  <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
    <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
      <!-- Image gallery -->
      <div class="flex flex-col-reverse">

        <div class="w-full aspect-w-1 aspect-h-1">
            <img src="<?= $product->image ?>" alt="Angled front view with bag zipped and handles upright." class="w-full h-full object-center object-cover sm:rounded-lg">
        </div>
      </div>

      <!-- Product info -->
      <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
        <div class="flex gap-2">
        <?php
        foreach ($product->categories as $category) {
        ?>
          <a href="/fullstacksitetemplate/products.php?category=<?= $category->id ?>"><?= $category->name ?></a> >
        <?php
        }
        ?>
                <a href="#"><?= $product->slug ?></a>
        </div>
                <div class="flex">
        <?php
        foreach ($product->tags as $tag) {
        ?>
          <p class="bg-emerald-300 rounded-lg p-1 text-white"><?=$tag->name?></p>
        <?php
        }
        ?>
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900"><?= $product->name ?></h1>
        <button onclick="deleteProduct(<?=$product->id?>)">DELETE</button> 
        <a href="./update.php?id=<?=$product->id?>">EDIT</a>

        <div class="mt-3">
          <h2 class="sr-only">Product information</h2>
          <p class="text-3xl text-gray-900">£<?= $product->price ?></p>
        </div>

        <div class="mt-6">
          <h3 class="sr-only">Description</h3>

          <div class="text-base text-gray-700 space-y-6">
            <p><?= $product->description ?></p>
          </div>
        </div>

          <div class="mt-10 flex sm:flex-col1 gap-4">
            <button type="submit" class="max-w-xs flex-1 bg-teal-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-teal-500 sm:w-full">Checkout Now</button>
            <button onclick="addToBasket(<?=$product->id?>)" type="submit" class="max-w-xs flex-1 border border-teal-600 border-4 rounded-md py-3 px-8 flex items-center justify-center text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-teal-500 sm:w-full">Add to bag</button>

          </div>
      </div>
    </div>
  </div>
</div>


<?php
include '../../inc/inc_foot.php'
?>