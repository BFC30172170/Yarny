<?php
include_once base_path('inc/inc_dbconnect.php');

$id = $_SESSION['id'];
?>

<!-- Render form -->
<form class="flex flex-col w-full p-6 border rounded-lg shadow-lg ml-auto" id="contact-form">

    <h2 class="">Send us a message</h2>

    <label for="name">Name</label>
    <input type="text" name="name" placeholder="Message title..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="description">Description</label>
    <textarea type="text" rows="10" name="description" placeholder="Message description..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>

    <button class="border-2 p-4 my-2 rounded-lg hover:font-bold" name="submit">Submit</button>
</form>
</div>

<!-- Form logic -->
<script>
    const form = document.querySelector('#contact-form');
    form.addEventListener("submit", handleSubmission, false);

    async function handleSubmission(e) {
        e.preventDefault();
        // bring in values
        const name = e.target.name.value;
        const description = e.target.description.value;
        const accountId = <?= $id ?>;

        const body = {
            name,
            description,
            accountId
        };

        // post and reload with message
        const res = await postAddress(body);
        window.location.href = "/account/profile"
        Alpine.store('main').addMessage(res.status, res.message);
    }

    async function postAddress(form) {
        const res = await fetch('http://localhost/api/message', {
            method: "POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }
</script>