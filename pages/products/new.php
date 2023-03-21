<?php
include '../../inc/inc_head.php';
include '../../lib/products.php';
?>

<?php
$tags = getTags($con);
$cats = getCategories($con);
?>

<form class="flex flex-col" id="product-form">
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
    <label class="relative inline-flex items-center cursor-pointer">
  <input type="checkbox" value="" class="sr-only peer" name="active">
  <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
  <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
</label>

    <button name="submit">Submit</button>
</form>


<script>
    const form = document.querySelector('#product-form');
    form.addEventListener("submit", handleSubmission, false);

    async function handleSubmission(e){
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

        const body = {name, slug, description, price, image, category, tags, active};

        const res = await postProduct(body);
        window.location.href = "http://localhost/fullstacksitetemplate/pages/products/product.php?id=" + res.product.id;
        Alpine.store('main').addMessage(res.status,res.message);
    }

    async function postProduct(form){
        const res = await fetch('http://localhost/fullstacksitetemplate/api/products.php/',{
            method:"POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }

</script>

<?php
include '../../inc/inc_foot.php';
?>
