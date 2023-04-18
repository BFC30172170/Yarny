<?php
if (!isset($_SESSION['username'])) {
  header('Location:/account/login');
}
?>

<script>
  const logout = async () => {
    const res = await fetch('/api/auth/logout', { method: 'POST' })
    window.location.replace("/");
  }
</script>

<!-- Render links to all account pages and logout button -->

<div class="flex items-center">
<h1> Your Account </h1> 
<button onclick="logout()" class="p-2 border-2 shadow-md rounded-lg hover:shadow-lg hover:font-bold ml-auto">LOGOUT</button>
</div>

<?php if($_SESSION['role'] == 'admin') { 
 echo' <a href="/admin" class="text-xl text-cyan-600 ml-auto">GO TO ADMIN CENTER</a> ';
}?>

<div class="flex flex-col gap-4 p-4">
    <a href="/account/profile" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://images.unsplash.com/photo-1506869640319-fe1a24fd76dc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80')]">Your Profile</a>
    <a href="/account/orders" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://images.unsplash.com/photo-1513672494107-cd9d848a383e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80')]">Your Orders</a>
    <a href="/account/reviews" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://images.unsplash.com/photo-1633613286991-611fe299c4be?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80')]">Your Reviews</a>
    <a href="/account/addresses" class="font-black p-10 rounded-lg bg-center bg-cover bg-[url('https://images.unsplash.com/photo-1464082354059-27db6ce50048?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80')]">Your Addresses</a>
</div>