<?php
include base_path('inc/inc_admin.php');
?>

<script>
  const logout = async () => {
    const res = await fetch('/api/auth/logout', { method: 'POST' })
    window.location.replace("/");
  }
</script>

<!-- Render links to all account pages and logout button -->

<div class="flex items-center">
<h1> Admin Centre</h1>
<button onclick="logout()" class="p-2 border-2 shadow-md rounded-lg hover:shadow-lg hover:font-bold ml-auto">LOGOUT</button>
</div>

<a href="/admin" class="text-xl text-cyan-600 ml-auto">GO TO PERSONAL ACCOUNT</a>

<div class="flex flex-col gap-4 p-4">
    <a href="/admin/categories" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://images.unsplash.com/photo-1544396821-4dd40b938ad3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1746&q=80')]">Categories & Tags</a>
    <a href="/admin/products" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://plus.unsplash.com/premium_photo-1675799745773-d00668d9790d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=930&q=80')]">Products</a>
    <a href="/admin/reviews" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://images.unsplash.com/photo-1633613286991-611fe299c4be?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80')]">All Reviews</a>
    <a href="/admin/accounts" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://images.unsplash.com/photo-1454923634634-bd1614719a7b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80')]">All Accounts</a>
</div>