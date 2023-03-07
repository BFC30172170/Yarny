<?php
include_once '../../inc/inc_head.php';

if (!isset($_SESSION['username'])){
    header('Location:http://localhost/fullstacksitetemplate/pages/account/login.php');
}
?>

<script>
  const logout = async () =>{
    const res = await fetch('http://localhost/fullstacksitetemplate/api/auth/logout.php', {method:'POST'})
    // const json = await res.json();
    // console.log(json);
    window.location.replace("http://localhost/fullstacksitetemplate/pages");
  }
</script>

<button onclick="logout()" class="p-2 border-2 shadow-md rounded-lg hover:shadow-lg hover:font-bold">LOGOUT</button>
<h1 class="text-3xl font-bold capitalize"> Your Account</h1>
<div class="flex gap-4">
<div class="bg-teal-500 p-10">
  <a href="./profile.php">Your Profile</a>
</div>
<div class="bg-amber-500 p-10">
  <a href="./orders.php">Your Orders</a>
</div>
<div class="bg-cyan-500 p-10">
  <a href="./reviews.php">Your Reviews</a>
</div>
<div class="bg-cyan-500 p-10">
  <a href="./addresses.php">Your Addresses</a>
</div>
</div>


<?php
include_once '../../inc/inc_foot.php';
?>