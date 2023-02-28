<!DOCTYPE html>

<?php
    include 'inc_dbconnect.php'
?>

<html>
<head>
    <title>Simple Website Template</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <header>
        <nav>
            <ul class="flex w-full bg-slate-800 text-white gap-4 p-8 text-xl font-black uppercase">
                <li><a href="/fullstacksitetemplate/pages">Home</a></li>
                <li><a href="/fullstacksitetemplate/pages#about">About</a></li>
                <li><a href="/fullstacksitetemplate/pages/products">Products</a></li>
            </ul>
        </nav>
    </header>
    <main class="p-8">