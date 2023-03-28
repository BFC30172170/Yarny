<?php
if(isset($_SESSION['username'])){
    header('Location: /fullstacksitetemplate/pages/account');
}
// $password = password_hash('password',PASSWORD_DEFAULT);
// var_dump($password);
?>

<div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="w-full max-w-md space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Register an Account</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <a href="./login.php" class="font-medium text-teal-600 hover:text-teal-500">Login</a>
      </p>
    </div>
    <form id="register-form"class="mt-8 space-y-6" action="http://localhost/fullstacksitetemplate/api/auth/register.php" method="POST">
      <div class="-space-y-px rounded-md shadow-sm">
        <div>
          <label for="username" class="sr-only">Username</label>
          <input id="username" name="username" type="text" autocomplete="username" required class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm" placeholder="Username">
        </div>
        <div>
          <label for="email" class="sr-only">Email</label>
          <input id="email" name="email" type="email" autocomplete="current-password" required class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm" placeholder="Email Address">
        </div>
      </div>

      <div class="-space-y-px rounded-md shadow-sm">
        <div>
          <label for="password" class="sr-only">Password</label>
          <input id="password" name="password" type="password" autocomplete="current-password" required class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm" placeholder="Password">
        </div>
        <div>
          <label for="passwordConfirm" class="sr-only">Password</label>
          <input id="passwordConfirm" name="passwordConfirm" type="password" autocomplete="current-password" required class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm" placeholder="Confirm Password">
        </div>
      </div>

      <div>
        <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-teal-500 group-hover:text-teal-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
            </svg>
          </span>
          Sign Up
        </button>
      </div>
    </form>
  </div>
</div>

<script>
    const form = document.querySelector('#register-form');
    form.addEventListener("submit", handleSubmission, false);

    async function handleSubmission(e){
        e.preventDefault();

        const username = e.target.username.value;
        const email = e.target.email.value;
        const password = e.target.password.value;
        const passwordConfirm = e.target.passwordConfirm.value;

        const body = {username, email, password, passwordConfirm};

        const res = await postAccount(body);
        Alpine.store('main').addMessage(res.status,res.message);
        window.location.href = "http://localhost/fullstacksitetemplate/pages/account"
    }

    async function postAccount(form){
        const res = await fetch('http://localhost/fullstacksitetemplate/api/auth/register.php/',{
            method:"POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }

</script>





