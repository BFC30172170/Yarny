<?php
include base_path('inc/inc_dbconnect.php');
?>

<?php
$tags = Tag::getTags($con);
$cats = Category::getCategories($con);
?>

<form class="flex flex-col" id="product-form">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image gallery -->
            <div class="flex flex-col-reverse">
                <div class="w-full aspect-w-1 aspect-h-1">
                    <img src="/placeholder.png" alt="Angled front view with bag zipped and handles upright."
                        class="w-full h-full object-center object-cover sm:rounded-lg">
                    <label for="image">Upload Image</label>
                    <input type="file"  name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"/>
                        
                </div>
            </div>

            <div class="flex flex-col">
            <div class="flex items-center">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name
            <input type="text" name="name" value="name field" class="block w-full text-xl p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
            </label>

            <div class="ml-auto">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" name="active">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
            </label>
            </div>
            </div>

            <label for="slug">Slug</label>
            <input type="text" name="slug" value="slug field" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>

            <label for="price">Price</label>
            <input type="text" name="price" value="0.99" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>

            <label for="description">Description</label>
            <textarea name="description" value="desc field" rows=10 class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>


            <label for="category">Category</label>

            <select name="category" id="category">
                <?php foreach($cats as $cat){ ?>
                <option value="<?=$cat->id?>"><?=$cat->name?></option>
                <?php } ?>
            </select>

            <fieldset id="tags-selection">
                <legend>Tags</legend>

                <?php foreach($tags as $tag){ ?>
                <input type="checkbox" id="<?=$tag->id?>" name="<?=$tag->id?>">
                <label for="<?=$tag->id?>"><?=$tag->name?></label>
                <?php } ?>

            </fieldset>



            <!-- Rounded switch -->


            <button name="submit">Submit</button>
                </div>
</form>


<script>
const form = document.querySelector('#product-form');
form.addEventListener("submit", handleSubmission, false);

async function handleSubmission(e) {
    e.preventDefault();

    const tags = [];
    const tagsSelection = document.querySelector('#tags-selection')
    const checked = tagsSelection.querySelectorAll('input[type="checkbox"]:checked')
    checked.forEach(tag => {
        tags.push(tag.id)
    });

    const name = e.target.name.value;
    const slug = e.target.slug.value;
    const description = e.target.description.value;
    const price = e.target.price.value;
    const image = e.target.image.value;
    const category = e.target.category.value;
    const active = e.target.active.checked;

    const body = {
        name,
        slug,
        description,
        price,
        image,
        category,
        tags,
        active
    };

    const res = await postProduct(body);
    window.location.href = "http://localhost/fullstacksitetemplate/pages/products/product.php?id=" + res.product.id;
    Alpine.store('main').addMessage(res.status, res.message);
}

async function postProduct(form) {
    const res = await fetch('http://localhost/fullstacksitetemplate/api/products.php/', {
        method: "POST",
        body: JSON.stringify(form)
    });
    const json = await res.json();
    return json;
}
</script>