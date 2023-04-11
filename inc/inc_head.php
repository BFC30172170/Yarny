<!DOCTYPE html>
<html>

<head>
    <title>Simple Website Template</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;300;400;500;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b978ae68bf.js" crossorigin="anonymous" rel="preload"></script>
    <?php
    // var_dump($_SESSION);
    ?>

<body class="border-solid  border-t-4 border-teal-500 b-2" x-data>
    <header>
        <nav class="flex space-between text-gray-600  max-w-screen-xl mx-auto">
            <ul class="flex gap-4 p-8 text-xl font-black uppercase">
                <li class="text-teal-500"><a href="/"><i class="fa-solid fa-house"></i> YARNY</a></li>
                <li><a href="/#about">About</a></li>
                <li><a href="/products">Products</a></li>
            </ul>
            <ul class="flex gap-4 p-8 text-xl font-black uppercase ml-auto">
                <li><a href="/account/login">
                        <?php if (isset($_SESSION['username'])) { ?>
                            Hi, <?= $_SESSION['username'] ?>
                        <?php } else { ?>
                            Account</a>
                <?php } ?></li>
                <li><a href="/basket">
                    <i class="fa-solid fa-basket-shopping" style="color: #14b8a6;"></i>
                        <?php if (isset($_SESSION['basket'])) { ?>
                            <?= count($_SESSION['basket']) > 0 ? count($_SESSION['basket']) : ''?>
                        <?php } else { ?>
                            
                        <?php } ?></a> </li>
            </ul>

        </nav>
    </header>

    <main class="p-8 min-h-screen max-w-screen-xl mx-auto">