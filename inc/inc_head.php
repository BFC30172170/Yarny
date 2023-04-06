<!DOCTYPE html>
<html>
<head>
    <title>Simple Website Template</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<?php
var_dump($_SESSION);
?>

<body class="" x-data>
    <header>
        <nav class="flex space-between bg-teal-400 text-white">
            <ul class="flex gap-4 p-8 text-xl font-black uppercase">
                <li><a href="/">Home</a></li>
                <li><a href="/#about">About</a></li>
                <li><a href="/products">Products</a></li>
            </ul>
            <ul class="flex gap-4 p-8 text-xl font-black uppercase ml-auto">
                <li><a href="/account/login">
                <?php if (isset($_SESSION['username'])){ ?> 
                Hi, <?=$_SESSION['username']?> 
                <?php }else{ ?> 
                    Account</a> 
                <?php } ?></li>
                <li><a href="/basket">
                BASKET 
                <?php if(isset($_SESSION['basket'])){ ?> 
                <?=count($_SESSION['basket'])?> 
                <?php }else{ ?> 
                    0
                <?php } ?></a> </li>
            </ul>

        </nav>
    </header>

    <main class="p-8 min-h-screen">