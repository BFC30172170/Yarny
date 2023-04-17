<?php
include base_path('inc/inc_dbconnect.php');

// Query Products with specific tag
$query = new Query('tag=1,2,3,4,5,6,7');
$products = Product::getProducts($con, $query);
$last = array_key_last($products);
?>

<!-- For each Product, Render the product item with their key designating position in carousel -->
<!-- Currently, the render is limited to three items due to hardcoded css implementation -->
<div class="carousel relative shadow-2xl bg-white rounded-lg">
	<div class="carousel-inner relative overflow-hidden w-full rounded-lg h-60">
    <?php foreach ($products as $key => $product) {
        $current = $key+1;
        $prev = $current-1;
        $next = $current+1;

        if ($key == $last){
            $next = 1; 
        }

        if ($key == 0){
            $prev = $last;
        }
        ?>
        <input class="carousel-open" type="radio" id="carousel-<?=$current?>" name="carousel" aria-hidden="true" hidden="" checked="checked">
		<div class="carousel-item absolute opacity-0 group-hover:opacity-75" style="height:50vh; ">
			<a href="/products/<?=$product->id?>" class="flex flex-col h-full w-full bg-teal-500 text-gray-600 text-start pl-24 pt-24 bg-left bg-cover bg-[url('<?=$product->image?>')]"><p class=" text-3xl"><?=$product->name?></p><p class="text-md">£<?=$product->price?></p></a>
		</div>
		<label for="carousel-<?=$prev?>" class="prev control-<?=$current?> w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-teal-500 leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
		<label for="carousel-<?=$next?>" class="next control-<?=$current?> w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-teal-500 leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>
        <?php
    }
    ?>
	<!-- Render additional indicator nubs -->
		<ol class="carousel-indicators">
			<li class="inline-block mr-3">
				<label for="carousel-1" class="carousel-bullet cursor-pointer block text-4xl text-white hover:text-teal-400">•</label>
			</li>
			<li class="inline-block mr-3">
				<label for="carousel-2" class="carousel-bullet cursor-pointer block text-4xl text-white hover:text-teal-400">•</label>
			</li>
			<li class="inline-block mr-3">
				<label for="carousel-3" class="carousel-bullet cursor-pointer block text-4xl text-white hover:text-teal-400">•</label>
			</li>
		</ol>
		
	</div>
</div>