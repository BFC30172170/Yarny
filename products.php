<?php
include 'inc_head.php';
?>


<h1 class="text-3xl"><?= isset($_GET['category']) ? $_GET['category'] : 'Products' ?></h1>
<ul class="flex gap-4">
    <li class="text-blue-500"><a href='./products.php'>All Products</a></li>
    <li class="text-blue-500"><a href='./products.php?category=soup'>soup</a></li>
    <li class="text-blue-500"><a href='./products.php?category=food'>food</a></li>
    <li class="text-blue-500"><a href='./products.php?category=biscuit'>biscuits</a></li>
</ul>

<?php
$qry = "SELECT * FROM product";

if(isset($_GET['category'])){
    $category = $_GET['category'];
    $qry = $qry." WHERE product_main_category = :category OR product_sub_category = :category";
}

$qry = $qry.";";
$stmt = $con->prepare($qry);
if(isset($category)){$stmt->bindValue(':category',$category,PDO::PARAM_STR);};
$stmt->execute();
$result = $stmt->fetchAll();

if ($stmt->rowCount() == 0){
    echo "No results.";
}else{
    echo $stmt->rowCount()." results.";
}
?>
<ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">


<?php
foreach ($result as $row){
?>
    <li class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
    <nav class="p-2" aria-label="Breadcrumb">
    <ol role="list" class="flex items-start space-x-1">
        <li class="text-sm font-medium text-gray-500 hover:text-gray-700">
        <div>
            <a href="./products.php" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                Products
            </a>
        </div>
        </li>

        <li>
        <div class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            >
            <a href="./products.php?category=<?= $row['product_main_category']?>" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700"><?= $row['product_main_category']?></a>
        </div>
        </li>

        <li>
        <div class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            >
            <a href="./products.php?category=<?= $row['product_sub_category']?>" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page"><?= $row['product_sub_category']?></a>
        </div>
        </li>
    </ol>
    </nav>
    <div class="w-full flex items-center justify-between p-6 space-x-6 text-sm font-medium text-gray-500 hover:text-gray-700">
        
      <div class="flex-1 truncate">
        <div class="flex items-center space-x-3">
          <h3 class="text-gray-900 text-sm font-medium truncate"><?= $row['product_name']?></h3>
        </div>
        <p class="mt-1 text-gray-500 text-sm truncate"><?= $row['product_description']?></p>
      </div>
      
    </div>
    <div>
      <div class="-mt-px flex divide-x divide-gray-200">
        <div class="w-0 flex-1 flex">
          <a href="" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
            <span class="ml-3">Buy</span>
          </a>
        </div>
      </div>
    </div>
  </li>


<?php
}

include 'inc_foot.php'
?>