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


<h1 class="text-3xl font-bold capitalize"> <?=$_SESSION['username']?></h1>
<p>Role: <?=$_SESSION['role']?></p>
<p>Id: <?=$_SESSION['id']?></p>
<button onclick="logout()" class="p-2 border-2 shadow-md rounded-lg hover:shadow-lg hover:font-bold">LOGOUT</button>

<?php
include_once '../../inc/inc_foot.php';
?>