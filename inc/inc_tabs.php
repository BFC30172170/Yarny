<!-- UI Component to display navigation options with images as tabs -->

<!-- Define Categories -->
<?php
$categories = [
    [
        'image' => 'https://images.unsplash.com/photo-1550376026-7375b92bb318?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=708&q=80',
        'title' => 'Yarn',
        'subtitle' => 'To make creations'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1572187092690-63fffd19feb2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'title' => 'Patterns',
        'subtitle' => 'Guides on how to make things'
    ],
    [
        'image' => 'https://plus.unsplash.com/premium_photo-1671460923085-f7ec58f56b28?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'title' => 'End Products',
        'subtitle' => 'handmade products'
    ]
];
?>

<!-- Render Categories -->
<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
    <!-- For each Category, render an image box, and populate data with specified text, image & links-->
    <?php
    foreach ($categories as $key => $category) {
        ?>
        <div class="group relative">
            <div class="h-60 aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 ">
                <img src="<?= $category['image'] ?>" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
            </div>
            <div>
                <h4 class="text-sm text-gray-700 mt-4">
                    <a href="#">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                        <?= $category['title'] ?>
                    </a>
                </h4>
                <p class="mt-1 text-sm text-gray-500">
                    <?= $category['subtitle'] ?>
                </p>
            </div>
        </div>
        <?php
    }
    ?>

</div>