<?php
include_once '../../inc/inc_head.php';
include_once '../../lib/products.php';
include_once '../../lib/queries.php';
?>

<script>
const fetchProducts = async () => {
    let products = [];
    const res = await fetch('http://localhost/fullstacksitetemplate/api/products.php/');
    const json = await res.json();
    console.log(json)
    return json;
}
</script>


<?php
$tags = getTags($con);
$cats = getCategories($con);
?>



<div x-data="{
    products: null,
    category: '',
    tags: [],
    search: '',
    loading: false,

    getProducts() {
      this.loading = true;
      setTimeout(()=> {
        fetch(`http://localhost/fullstacksitetemplate/api/products.php/?category=${this.category}&tag=${this.tags}&search=${this.search}`)
            .then((response) => response.json())
            .then((json) => this.products = json);
      setTimeout(()=> {
      this.loading = false;
      },450)
      }, 450);
    }
}" x-init="getProducts()" class="">
    <header class="flex flex-col md:flex-row space-between w-full border-b-2 mb-4 pb-2">
        <h1 class="text-3xl"><?= isset($_GET['category']) ? $cat->name : 'Products' ?></h1>
        <div class="md:ml-auto flex gap-4 tex-xl">
            <a href='#' class="text-xl">sort</a>
            <a href='#' class="text-xl">display</a>
            <div class="flex">
                <label for="search" class="text-xl mr-4">Search</label>
                <input type="text" class="w-32 border b-2 rounded-lg pl-2" name="search"
                    @input.debounce.500ms="search = $el.value; getProducts();"></input>
            </div>
        </div>
    </header>
    <div class="grid grid-cols-12">
        <div class="hidden md:flex flex-col col-span-3 align-start p-4">

            <h2 class="text-xl border-b-2 lowercase tracking-wide">Categories</h2>
            <?php
            foreach($cats as $cat){
            ?>
            <button class="flex py-1" :class="category == <?=$cat->id?> ? 'font-black text-teal-500' : ''"
                @click="if(category == <?=$cat->id?>){category= '';} else {category = <?=$cat->id?>}; getProducts();">
                <div class="rounded-lg w-6 h-6 mr-4"
                    :class="category == <?=$cat->id?> ? 'bg-teal-500' : 'border-2 b-teal-500'"></div><?= $cat->name?>
            </button>
            <?php
            }
            ?>
            <h2 class="text-xl border-b-2 lowercase tracking-wide">Tags</h2>
            <?php
            foreach($tags as $tag){
            ?>
            <button class="flex py-1" :class="tags.includes(<?=$tag->id?>) ? 'font-black text-teal-500' : ''"
                @click="if(tags.includes(<?=$tag->id?>)){const arr = tags;const index = arr.indexOf(<?=$tag->id?>);arr.splice(index, 1);tags = arr} else {tags.push(<?=$tag->id?>)}; getProducts();">
                <div class="rounded-lg w-6 h-6 mr-4"
                    :class="tags.includes(<?=$tag->id?>) ? 'bg-teal-500' : 'border-2 b-teal-500'"></div><?= $tag->name?>
            </button>
            <?php
            }
            ?>
        </div>


        <div
            class="col-span-12 md:col-span-9 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 xl:gap-x-8">
            <template x-for="product, index in products" class="hidden">
                <a :href="'./product.php?id='+product.id" :style="`transition-delay: ${index * 30}ms !important;`" class="group shadow-md border-2 rounded-lg hover:shadow-lg transition duration-300 h-full" :class="loading ? 'opacity-0 translate-y-16' : 'opacity-100'">
                    <div
                        class="relative aspect-w-1 aspect-h-1 w-full h-36 overflow-hidden rounded-t-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8 bg-slate-100">
                        <img :src="product.image" :alt="product.name"
                            class="h-full w-full object-cover object-center group-hover:opacity-75">
                        <div class="flex absolute bottom-2 left-2">
                            <template x-for="tag in product.tags" class="hidden">
                                <p x-text="tag.name" class="bg-emerald-300 rounded-lg p-1 text-white"></p>
                            </template>
                        </div>
                    </div>
                    <div class="flex flex-col space-between p-2">
                        <h3 class="text-sm text-gray-700" x-text="product.name"></h3>
                        <div class="mt-auto flex space-between items-center">
                          <p class="text-lg font-medium text-gray-900" x-text="'£' + product.price"></p> 
                          <div class="w-4 h-4 bg-teal-500 ml-auto rounded-lg transition duration-300 group-hover:scale-110 group-hover:bg-teal-400 group-hover:shadow-md"></div>
                        </div>
                    </div>
                </a>
            </template>
        </div>
    </div>
</div>


<?php
include '../../inc/inc_foot.php';
?>