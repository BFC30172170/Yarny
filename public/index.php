<?php

const BASE_PATH = __DIR__ .'/../';
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

function base_path($path){
    return BASE_PATH . $path;
}

function page($path){
    return base_path('pages/' . $path);
}

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require base_path("lib/{$class}.php");
});

// function error_found(){
//     header("Location:/500");
//   }
//   set_error_handler('error_found');

session_start();

$paths = [
    '/' => '/index.php',
    '/products' => '/products/index.php',
    '/contact' => '/contact.php',
    '/products/new' => '/products/new.php',
    "/products/[slug]" => '/products/product.php?id=[slug]',
    "/products/[slug]/update" => '/products/update.php?id=[slug]',
    '/basket' => '/basket/index.php',
    '/basket/delivery' => '/basket/delivery.php',
    '/basket/billing' => '/basket/billing.php',
    '/account' => '/account/index.php',
    '/account/addresses' => '/account/addresses.php',
    '/account/orders' => '/account/orders.php',
    '/account/profile' => '/account/profile.php',
    '/account/reviews' => '/account/reviews.php',
    '/account/login' => '/account/login.php',
    '/account/register' => '/account/register.php',
    '/admin' => '/admin/index.php',
    '/admin/categories' => '/admin/categories.php',
    '/admin/products' => '/admin/products.php',
    '/admin/reviews' => '/admin/reviews.php',
    '/admin/accounts' => '/admin/accounts.php',
    '/api/products' => '/api/products.php',
    '/api/auth/login' => '/api/auth/login.php',
    '/api/auth/logout' => '/api/auth/logout.php',
    '/api/auth/register' => '/api/auth/register.php',
    '/api/basket' => '/api/basket.php',
    '/api/basket/address' => '/api/basketAddress.php',
    '/api/addresses' => '/api/addresses.php',
    '/api/categories' => '/api/categories.php',
    '/api/images' => '/api/images.php',
    '/api/tags' => '/api/tags.php',
    '/api/sale' => '/api/sale.php',
    '/api/review' => '/api/review.php',
    '/api/message' => '/api/message.php',
    '/404' => '/404.php',
    '/500' => '/500.php',
    '/401' => '/401.php',
];

$dynamicPaths = [
    '^\/products\/([0-9]{1,})$^' => 'products/product.php',
    '^\/products\/([0-9]{1,})\/update$^' => 'products/update.php'
];

$router = new Router();

foreach ($paths as $key=>$value) {
    $router->add($key,$value);
}

foreach ($dynamicPaths as $key=>$value) {
    $router->addDynamic($key,$value);
}


if(!str_contains($uri,'api')){
    include_once base_path('inc/inc_head.php');
}
$router->route($uri);

if(!str_contains($uri,'api')){
    include_once base_path('inc/inc_foot.php');
}

?>
