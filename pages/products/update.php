<?php
include base_path('/inc/inc_dbconnect.php');
include base_path('inc/inc_admin.php');

if (isset($_POST['submit'])) {
    $product = new ProductDTO($_POST);
    Product::updateProduct($con, $product);
}
?>

<?php
if (isset($_GET['id'])) {
    $product = Product::getProduct($con, $_GET['id']);
    $tags = Tag::getTags($con);
    $cats = Category::getCategoryList($con);
}
?>
<form class="flex flex-col" id="product-form">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image gallery -->
            <div class="flex flex-col-reverse">
                <div class="w-full aspect-w-1 aspect-h-1">
                    <img id="image-preview" src="<?= $product->image ?>" alt="Angled front view with bag zipped and handles upright." class="w-full h-full object-center object-cover sm:rounded-lg border border-gray-600 mb-6">
                    <label for="image">Upload Image</label>
                    <input type="file" name="image" id="image" onchange="previewImage()" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" />

                </div>
            </div>

            <div class="flex flex-col">
                <div class="flex items-center">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 w-full">Name
                        <input type="text" name="name" value="<?= $product->name ?>" class="block w-full text-xl p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500" />
                    </label>

                    <div class="px-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" name="active" <?php if ($product->active) {
                                                                                                    echo "checked";
                                                                                                } ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
                        </label>
                    </div>
                </div>

                <label for="slug">Slug</label>
                <input type="text" name="slug" value="<?= $product->slug ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

                <label for="price">Price</label>
                <input type="text" name="price" value="<?= $product->price ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

                <label for="description">Description</label>
                <textarea name="description" value="<?= $product->description ?>" rows=10 class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"><?= $product->description ?></textarea>


                <label for="category">Category</label>

                <select name="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <?php foreach ($cats as $cat) { ?>
                        <option value="<?= $cat->id ?>" <?php if ($cat->id == $product->category) {
                                                            echo "selected";
                                                        } ?>><?= $cat->name ?></option>
                    <?php } ?>
                </select>

                <fieldset id="tags-selection">
                    <legend>Tags</legend>

                    <?php foreach ($tags as $tag) { ?>
                        <input type="checkbox" id="<?= $tag->id ?>" name="<?= $tag->id ?>" <?php foreach ($product->tags as $productTag) {
                                                                                                if ($productTag->id == $tag->id) {
                                                                                                    echo "checked";
                                                                                                }
                                                                                            } ?>>
                        <label class="pr-2 pl-1" for="<?= $tag->id ?>"><?= $tag->name ?></label>
                    <?php } ?>

                </fieldset>


                <button name="submit">Submit</button>
            </div>
</form>

<script>
    const form = document.querySelector('#product-form');
    form.addEventListener("submit", handleSubmission, false);
    const frame = document.querySelector('#image-preview')

    function previewImage() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }

    async function handleSubmission(e) {
        e.preventDefault();
        let imagePath = '<?= $product->image ?>'
        if (e.target.image.files[0]) {
            const imageFile = e.target.image.files[0];
            const imageRes = await postImage(imageFile);
            imagePath = '/' + imageRes.image_source;
        }

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
        const image = imagePath;
        const category = e.target.category.value;
        const active = e.target.active.checked;
        const id = <?= $_GET['id'] ?>;

        const body = {
            id,
            name,
            slug,
            description,
            price,
            image,
            category,
            tags,
            active
        };

        const res = await putProduct(body);
        window.location.href = "http://localhost/products/" + res.product.id;
        Alpine.store('main').addMessage(res.status, res.message);

    }

    async function postImage(file) {
        const form_data = new FormData();

        form_data.append('image', file);

        const res = await fetch("http://localhost/api/images", {
            method: "POST",
            body: form_data
        })
        const json = await res.json();
        return json;
    }

    async function putProduct(form) {
        const res = await fetch('http://localhost/api/products', {
            method: "PUT",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }
</script>