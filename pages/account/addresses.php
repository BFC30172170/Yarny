<?php
include_once base_path('inc/inc_dbconnect.php');
?>

<!-- Get all the accounts addresss -->
<?php
$id = $_SESSION['id'];
$addresses = Address::getAccountAddresses($con, $id);
?>

<!-- Render each address -->
<?php
foreach ($addresses as $address) 
{
?>
    <div>
        <h1 class="text-xl font-black uppercase"><?= $address->postcode ?></h1>
        <p>Name: <?= $address->forename ?>     <?= $address->surname ?></p>
        <p><?= $address->line1 ?></p>
        <p><?= $address->line2 ?></p>
        <p><?= $address->line3 ?></p>
        <p><?= $address->town ?></p>
        <p><?= $address->postcode ?></p>
        <p><?= $address->country ?></p>
        <p><?= $address->account ?></p>
    </div>

<?php
}
?>

<!-- Render form -->
<form class="flex flex-col w-72 p-6 border rounded-lg shadow-lg ml-auto" id="address-form">

    <h1 class="text-2xl font-black">Add new Address</h1>

    <label for="forename">Forename</label>
    <input type="text" name="forename" value="Forename" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="surname">Surname</label>
    <input type="text" name="surname" value="Surname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="line1">Address Line 1</label>
    <input type="text" name="line1" value="line 1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="line2">Address Line 2</label>
    <input type="text" name="line2" value="line 2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="line3">Address Line 3</label>
    <input type="text" name="line3" value="line 3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="town">Town</label>
    <input type="text" name="town" value="town" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="postcode">Postcode</label>
    <input type="text" name="postcode" value="Postcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <label for="country">Country</label>
    <input type="text" name="country" value="Country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

    <button name="submit">Submit</button>
</form>

<!-- Form logic -->
<script>
    const form = document.querySelector('#address-form');
    form.addEventListener("submit", handleSubmission, false);

    async function handleSubmission(e) {
        e.preventDefault();
        // bring in values
        const forename = e.target.forename.value;
        const surname = e.target.surname.value;
        const line1 = e.target.line1.value;
        const line2 = e.target.line2.value;
        const line3 = e.target.line3.value;
        const town = e.target.town.value;
        const postcode = e.target.postcode.value;
        const country = e.target.country.value;
        const account = <?= $id ?>;

        const body = {
            forename,
            surname,
            line1,
            line2,
            line3,
            town,
            postcode,
            country,
            account
        };

        // post and reload with message
        const res = await postAddress(body);
        window.location.href = "/account/addresses"
        Alpine.store('main').addMessage(res.status, res.message);
    }

    async function postAddress(form) {
        const res = await fetch('http://localhost/api/addresses', {
            method: "POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }
</script>