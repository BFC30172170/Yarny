<?php

const BASE_PATH = __DIR__ .'/../';
var_dump(BASE_PATH);

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

function base_path($path){
    return BASE_PATH . $path;
}

function page($path){
    return base_path('pages/' . $path);
}

var_dump($uri);
if($uri == '/'){
    require BASE_PATH.'/pages/index.php';
}else if ($uri == '/products'){
    require page('products/index.php');
}else{
    var_dump(page('404.php'));
    require page('404.php');
}
?>
