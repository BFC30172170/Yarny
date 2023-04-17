<?php
if (!isset($_SESSION['username'])) {
  header('Location:/account/login.php');
}
?>

<script>
  const logout = async () => {
    const res = await fetch('/api/auth/logout', { method: 'POST' })
    window.location.replace("/");
  }
</script>

<!-- Render links to all account pages and logout button -->
<button onclick="logout()" class="p-2 border-2 shadow-md rounded-lg hover:shadow-lg hover:font-bold">LOGOUT</button>
<h1 class="text-3xl font-bold capitalize"> Your Account</h1>
<div class="flex gap-4">
  <div class="bg-teal-500 p-10">
    <a href="/account/profile">Your Profile</a>
  </div>
  <div class="bg-amber-500 p-10">
    <a href="/account/orders">Your Orders</a>
  </div>
  <div class="bg-cyan-500 p-10">
    <a href="/account/reviews">Your Reviews</a>
  </div>
  <div class="bg-cyan-500 p-10">
    <a href="/account/addresses">Your Addresses</a>
  </div>
</div>