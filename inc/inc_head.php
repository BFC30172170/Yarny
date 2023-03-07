<!DOCTYPE html>

<?php
    include_once 'inc_dbconnect.php';
    include_once 'inc_session.php';
?>

<html>
<head>
    <title>Simple Website Template</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="">
    <header>
        <nav class="flex space-between bg-teal-400 text-white">
            <ul class="flex gap-4 p-8 text-xl font-black uppercase">
                <li><a href="/fullstacksitetemplate/pages">Home</a></li>
                <li><a href="/fullstacksitetemplate/pages#about">About</a></li>
                <li><a href="/fullstacksitetemplate/pages/products">Products</a></li>
            </ul>
            <ul class="flex gap-4 p-8 text-xl font-black uppercase ml-auto">
                <li><a href="/fullstacksitetemplate/pages/account/login.php">
                <?php if (isset($_SESSION['username'])){ ?> 
                Hi, <?=$_SESSION['username']?> 
                <?php }else{ ?> 
                    Account</a> 
                <?php } ?></li>
                <li><a href="/fullstacksitetemplate/pages/basket">
                BASKET 
                <?php if(isset($_SESSION['basket'])){ ?> 
                <?=count($_SESSION['basket'])?> 
                <?php }else{ ?> 
                    0
                <?php } ?></a> </li>
            </ul>

        </nav>
    </header>
    <main class="p-8 h-screen">