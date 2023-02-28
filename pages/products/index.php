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

<script>
  const fetchProducts = async ()=> {
    let products = [];
    const res = await fetch('http://localhost/fullstacksitetemplate/api/products.php/');
    const json = await res.json();
    console.log(json)
    return json;
  }

  const debounce = (func, timeout = 500) => {
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(()=> {
        func.apply(this,args);

      }, timeout);
    };
  }
</script>

<div x-data="{
    products: null,
    category: '',
    tags: [],
    search: '',

    getProducts() {
        fetch(`http://localhost/fullstacksitetemplate/api/products.php/?category=${this.category}&tag=${this.tags}&search=${this.search}`)
            .then((response) => response.json())
            .then((json) => this.products = json);
    }
}" x-init="getProducts()" class="">
<div class="flex flex-col w-1/2">
<h2 class="text-xl">Tags</h2>
<?php
foreach($tags as $tag){
?>
  <button :class="tags.includes(<?=$tag->id?>) ? 'text-emerald-500' : ''" @click="if(tags.includes(<?=$tag->id?>)){tags = []} else {tags.push(<?=$tag->id?>)}; getProducts();"><?= $tag->name?></button>
<?php
}
?>

<h2 class="text-xl">Categories</h2>
<?php
foreach($cats as $cat){
?>
  <button :class="category == <?=$cat->id?> ? 'text-emerald-500' : ''" @click="if(category == <?=$cat->id?>){category= ''; $el.InnerHTML = 'Hello'} else {category = <?=$cat->id?>}; getProducts();"><?= $cat->name?></button>
<?php
}
?>
<label for="search">Search</label>
<input type="text" name="search" @input.debounce.500ms="search = $el.value; getProducts();"></input>
</div>


<div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
<template x-for="product in products" class="hidden">
<a :href="'./product.php?id='+product.id" class="group">
        <div @click="console.log(product.tags[0])" class="relative aspect-w-1 aspect-h-1 h-3/4 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8 bg-slate-500">
          <img :src="product.image" :alt="product.name" class="h-full w-full object-cover object-center group-hover:opacity-75">
          <div class="flex absolute bottom-2 left-2">
          <template x-for="tag in product.tags" class="hidden">
            <p x-text="tag.name" class="bg-emerald-300 rounded-lg p-1 text-white"></p>
          </template>
          </div>
        </div>
        <h3 class="mt-4 text-sm text-gray-700" x-text="product.name"></h3>
        <p class="mt-1 text-lg font-medium text-gray-900" x-text="'£' + product.price"></p>
      </a>
</template>
</div>

</div>
</div>
<?php
include '../../inc/inc_foot.php';
?>
