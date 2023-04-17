<?php
include_once base_path('inc/inc_dbconnect.php');
?>

<?php
// Get all the account's addresses
$id = $_SESSION['id'];
$addresses = Address::getAccountAddresses($con, $id);
?>

<!-- Use all these addresses to populate a picker to choose the basket address -->
<select name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
    <?php foreach ($addresses as $add) { ?>
        <option value="<?= $add->id ?>"><?= $add->postcode ?> - <?= $add->line1 ?></option>
    <?php } ?>
</select>

<!-- Form for new address -->
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

<!-- Continue to next step -->
<a href="/basket/billing"><button class="border p-2">Checkout</button></a>

<script>
    // Get form & Picker.
    const form = document.querySelector('#address-form');
    form.addEventListener("submit", handleSubmission, false);

    const picker = document.querySelector('#address');
    picker.addEventListener("change", handleAddress, false);


    // Handle submission for new address
    async function handleSubmission(e) {
        e.preventDefault();

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

        const res = await postAddress(body);
        window.location.href = "/basket/delivery"
        Alpine.store('main').addMessage(res.status, res.message);
    }

    // Handle change of picker to set basket address.
    async function handleAddress(e) {
        e.preventDefault();
        console.log(e.target.value);
        const id = e.target.value;

        const res = await changeAddress(id);
        Alpine.store('main').addMessage(res.status, res.message);
    }

    // api call to create address
    async function postAddress(form) {
        const res = await fetch('http://localhost/api/addresses', {
            method: "POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }

    // api call to set basket address
    async function changeAddress(id) {
        const res = await fetch('http://localhost/api/basket/address', {
            method: "POST",
            body: JSON.stringify({ id })
        });
        const json = await res.json();
        Alpine.store('main').addMessage(json.status, json.message);
    }
</script>