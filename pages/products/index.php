<?php
include base_path('inc/inc_dbconnect.php');
// include_once base_path('/lib/products.php');
// include_once base_path('/lib/queries.php');
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

$tags = Tag::getTags($con);
$cats = Category::getCategories($con);

function renderCategories($cats){
    foreach($cats as $cat){
        renderCategory($cat);
    }
} 

function renderCategory(Category $cat){
    echo '<div class="pl-2 text-sm">';
    echo "<button class='flex py-1' :class=\"category == $cat->id ? 'font-black text-teal-500' : ''\"";
    echo "@click=\"if(category == $cat->id){category= '';} else {category = $cat->id}; getProducts();\">";
    echo "<div class='rounded-lg w-4 h-4 mr-2' :class=\"category == $cat->id ? 'bg-teal-500' : 'border-2 b-teal-500'\"></div>$cat->name";
    echo "</button>";
    foreach ($cat->children as $key => $cat) {
        renderCategory($cat);
    }
    echo '</div>';
}
?>

<div x-data="{
    products: null,
    category: '',
    tags: [],
    search: '',
    loading: false,
    list: false,

    getProducts() {
      this.loading = true;
      setTimeout(()=> {
        fetch(`http://localhost/api/products?category=${this.category}&tag=${this.tags}&search=${this.search}`)
            .then((response) => response.json())
            .then((json) => this.products = json);
      setTimeout(()=> {
      setTagColours();
      this.loading = false;
      },500)
      }, 500);
    }
}" x-init="getProducts()" class="">
    <header class="flex flex-col md:flex-row space-between w-full border-b-2 mb-4 pb-2">
        <h2 class="text-3xl"><?= isset($_GET['category']) ? $cat->name : 'Products' ?></h2>
        <div class="md:ml-auto flex gap-4 tex-xl">
            <div>
            <i class="fa-solid fa-grip fa-2xl transition duration-300" :class=" !list ? 'text-cyan-500' : ''" @click="list=false"></i> 
            <i class="fa-solid fa-bars fa-xl transition duration-300" :class=" list ? 'text-cyan-500' : ''" @click="list=true"></i>
</div>
            <div class="flex">
                <label for="search" class="text-xl mr-4">Search</label>
                <input type="text" class="w-32 border b-2 rounded-lg pl-2" name="search"
                    @input.debounce.500ms="search = $el.value; getProducts();"></input>
            </div>
        </div>
    </header>
    <div class="grid grid-cols-12">
        <div class="hidden md:flex flex-col col-span-3 align-start p-4">

            <h3 class="text-xl border-b-2 lowercase tracking-wide">Categories</h3>
            <?php
            renderCategories($cats);
            ?>
            <h3 class="text-xl border-b-2 lowercase tracking-wide">Tags</h3>
            <?php
            foreach($tags as $tag){
            ?>
            <button class="flex items-center text-sm py-1" :class="tags.includes(<?=$tag->id?>) ? 'font-black text-teal-500' : ''"
                @click="if(tags.includes(<?=$tag->id?>)){const arr = tags;const index = arr.indexOf(<?=$tag->id?>);arr.splice(index, 1);tags = arr} else {tags.push(<?=$tag->id?>)}; getProducts();">
                <div class="self-center rounded-lg w-4 h-4 mr-2 "
                    :class="tags.includes(<?=$tag->id?>) ? 'bg-teal-500' : 'border-2 b-teal-500'"></div><?= $tag->name?>
            </button>
            <?php
            }
            ?>
        </div>


        <div x-show="products.length > 0 && !list"
            class="col-span-12 md:col-span-9 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 xl:gap-x-8 h-content">
            <template x-for="product, index in products" class="hidden">
                <a :href="'/products/'+product.id" :style="`transition-delay: ${index * 30}ms !important;`" class="group shadow-md border-2 rounded-lg hover:shadow-lg transition duration-300 h-56" :class="loading ? 'opacity-0 translate-y-16' : 'opacity-100'">
                    <div
                        class="relative aspect-w-1 aspect-h-1 w-full h-36 overflow-hidden rounded-t-lg bg-gray-200 bg-slate-100">
                        <img :src="product.image" :alt="product.name"
                            class="w-full h-full object-cover object-center group-hover:opacity-75">
                        <div class="flex absolute bottom-2 left-2 gap-1">
                            <template x-for="tag in product.tags" class="hidden">
                                <p x-text="tag.name" class="tag rounded-lg p-1" x-style="`background-color: '${stringToColour('jdsjad')}'`"></p>
                            </template>
                        </div>
                    </div>
                    <div class="flex flex-col space-between p-2 h-20">
                        <h4 class="text-sm text-gray-700" x-text="product.name"></h4>
                        <div class="mt-auto flex space-between items-center">
                          <p class="text-lg font-medium text-gray-900" x-text="'£' + product.price"></p> 
                          <i class="fa-solid fa-basket-shopping ml-auto rounded-lg transition duration-300 group-hover:scale-110 group-hover:shadow-md" style="color: #14b8a6;"></i>
                        </div>
                    </div>
                </a>
            </template>
        </div>

        <div x-show="products.length > 0 && list"
            class="col-span-12 md:col-span-9 grid grid-cols-1 gap-y-4 gap-x-6 xl:gap-x-8 h-content">
            <template x-for="product, index in products" class="hidden">
                <a :href="'/products/'+product.id" :style="`transition-delay: ${index * 30}ms !important;`" class="group flex shadow-md border-2 rounded-lg hover:shadow-lg transition duration-300 h-28" :class="loading ? 'opacity-0 translate-y-16' : 'opacity-100'">
                    <div
                        class="relative aspect-w-1 aspect-h-1 w-28 h-28 overflow-hidden rounded-l-lg bg-gray-200 bg-slate-100">
                        <img :src="product.image" :alt="product.name"
                            class="w-full h-full object-cover object-center group-hover:opacity-75">
                        <div class="flex absolute bottom-2 left-2 gap-1">
                            <template x-for="tag in product.tags" class="hidden">
                                <p x-text="tag.name" class="tag rounded-lg p-1" x-style="`background-color: '${stringToColour('jdsjad')}'`"></p>
                            </template>
                        </div>
                    </div>
                    <div class="flex flex-col space-between p-2 w-full">
                        <h4 class="text-sm text-gray-700" x-text="product.name"></h4>
                        <p class="text-sm text-gray-700" x-text="product.description"></hp>
                        <div class="mt-auto flex space-between items-center">
                          <p class="text-lg font-medium text-gray-900" x-text="'£' + product.price"></p> 
                          <i class="fa-solid fa-basket-shopping ml-auto rounded-lg transition duration-300 group-hover:scale-110 group-hover:shadow-md" style="color: #14b8a6;"></i>
                        </div>
                    </div>
                </a>
            </template>
        </div>

        <div x-show="products.length == 0" class="col-span-12 md:col-span-9 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 xl:gap-x-8 h-content">
            No Products available
        </div>
    </div>
</div>

<script>

function stringToColour(string){
    console.log(string)
    let result = 0;
    for (let i = 0; i<string.length; i++){
        result = result + string.charCodeAt(i);
    }
    result = result * 12;
    result = result + 'a';
    let hue = result.slice(1,4);
    return hue;
}

function setTagColours(){
    const tags = document.querySelectorAll('.tag');
    tags.forEach(tag => {
        const hue = stringToColour(tag.innerHTML);
        tag.style.backgroundColor = 'hsl('+hue+',71%,86%)';
        console.log(tag);
    });

}

</script>