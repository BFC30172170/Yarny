<?php
include base_path('/inc/inc_dbconnect.php');
?>

<?php
if ($_GET['id']) {
    $product = Product::getProduct($con, $_GET['id']);
    if ($product == []) {
        header("Location: /404");
    }
    if ($product->active == false && $_SESSION['role'] != 'admin'){
        header("Location: /401");
    }
} else {
    header("Location: http://localhost/products");
    die();
};


$reviews = Review::getProductReviews($con, $product->id);
?>

<script>
    const deleteProduct = async (id) => {
        const res = await fetch('http://localhost/api/products', {
            method: 'DELETE',
            body: JSON.stringify({
                'productId': id
            })
        });
        const json = await res.json();
        Alpine.store('main').addMessage(json.status, json.message)
        //window.location.href = "http://localhost/products";
    }

    const addToBasket = async (id) => {
        const res = await fetch('http://localhost/api/basket', {
            method: 'POST',
            body: JSON.stringify({
                'productId': id
            })
        });
        const json = await res.json();
        Alpine.store('main').addMessage(json.status, json.message)
    }

    
    const checkoutNow = async (id) => {
        const res = await fetch('http://localhost/api/basket', {
            method: 'POST',
            body: JSON.stringify({
                'productId': id
            })
        });
        const json = await res.json();
        Alpine.store('main').addMessage(json.status, json.message)
        window.location.href = "http://localhost/basket"
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
                        <a href="/products"><?= $category->name ?></a> >
                    <?php
                    }
                    ?>
                    <a href="#"><?= $product->slug ?></a>
                </div>
                <div class="flex">
                    <?php
                    foreach ($product->tags as $tag) {
                    ?>
                        <p class="bg-emerald-300 rounded-lg p-1 text-white"><?= $tag->name ?></p>
                    <?php
                    }
                    ?>
                </div>
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900"><?= $product->name ?>
                    <?= $product->active ? '' : '(inactive)' ?></h2>
                    <?php if ($_SESSION['role'] == 'admin') {?>
                <button onclick="deleteProduct(<?= $product->id ?>)">DELETE</button>
                <a href="/products/<?= $product->id ?>/update">EDIT</a>
                <?php } ?>

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
                    <button  onclick="checkoutNow(<?= $product->id ?>)" type="submit" class="max-w-xs flex-1 bg-teal-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-teal-500 sm:w-full">Checkout
                        Now</button>
                    <button onclick="addToBasket(<?= $product->id ?>)" type="submit" class="max-w-xs flex-1 border border-teal-600 border-4 rounded-md py-3 px-8 flex items-center justify-center text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-teal-500 sm:w-full">Add
                        to bag</button>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="flex flex-col lg:flex-row w-full gap-8">
    <?php if (count($reviews) > 0){?>
<div class="w-full">
    <?php
    foreach ($reviews as $review) {
    ?>
    <div class="flex flex-col w-full">
        <div class="flex w-full items-center">
            <h3><?= $review->name ?></h3>        
            <p class="ml-auto"><span class="font-bold"><?= $review->score ?></span>/10</p>
        </div>
        <p><?= $review->description ?></p>
    </div>
    <?php
    }
    ?>
</div>
<?php
    }
    ?>

<form class="flex flex-col p-6 border rounded-lg shadow-lg"  id="review-form">

    <h2 class="text-2xl font-black">Add new Review</h2>

    <label for="name">Name</label>
    <input type="text" name="name" placeholder="Review Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="description">Description</label>
    <textarea type="text" rows="4" name="description" placeholder="Review Description..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>

    <label for="score">Score</label>
    <input type="number" min="0" max="10" step="1" name="score" placeholder="from 1 to 10..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <div class="px-4 py-2">
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" value="" class="sr-only peer" name="active">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
            </div>
            <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
        </label>
    </div>

    <button name="submit">Submit</button>
</form>

</div>
<script>
    const form = document.querySelector('#review-form');
    form.addEventListener("submit", handleSubmission, false);

    async function handleSubmission(e) {
        e.preventDefault();

        const name = e.target.name.value;
        const description = e.target.description.value;
        const score = e.target.score.value;
        const active = e.target.active.checked;
        const product = <?= $product->id ?>;
        const account = <?= $_SESSION['id'] ?>


        const body = {
            name,
            description,
            score,
            active,
            product,
            account
        };

        const res = await postReview(body);
        Alpine.store('main').addMessage(res.status, res.message);
    }

    async function postReview(form) {
        const res = await fetch('http://localhost/api/review', {
            method: "POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }
</script>