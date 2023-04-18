<?php
include base_path('inc/inc_dbconnect.php');
include base_path('inc/inc_admin.php');
$tags = Tag::getTags($con);
$cats = Category::getCategoryList($con);
?>

<?php
function renderCategories($cats)
{
    foreach ($cats as $cat) {
        renderCategory($cat);
    }
}

function renderCategory(Category $cat)
{
    echo '<div class="pl-4 py-1">' . $cat->name . ' - ' . $cat->description;
    if (count($cat->children) == 0)
        echo ' ---  <button onclick="deleteCategory(' . $cat->id . ')">DELETE</button>';
    foreach ($cat->children as $key => $cat) {
        renderCategory($cat);
    }
    echo '</div>';
}
?>

<!-- Display current Categories -->
<h2 class="text-xl border-b-2 lowercase tracking-wide mb-2">Categories</h2>
<div class="flex">
    <div class="flex flex-col">

        <?php
        $catsList = Category::getCategories($con);
        renderCategories($catsList);
        ?>
    </div>

    <!-- Category form -->
    <form class="flex flex-col w-64 p-6 border rounded-lg shadow-lg ml-auto" id="cat-form">

        <h2>Add new Category</h1>

        <label for="name">Name</label>
        <input type="text" name="name" value="New Category Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

        <label for="description">Description</label>
        <textarea name="description" value="desc field" rows=10 class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>


        <label for="parent">Parent</label>

        <select name="parent" id="parent" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value=0>None</option>
            <?php foreach ($cats as $cat) { ?>
                <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
            <?php } ?>
        </select>


        <button name="submit">Submit</button>
    </form>

</div>
<!-- Display curent Tags -->
<h2 class="text-xl border-b-2 lowercase tracking-wide mb-2">Tags</h2>
<div class="flex">
    <div class="flex flex-col">
        <?php
        foreach ($tags as $tag) {
            ?>
            <button class="flex py-1 gap-4">
                <div>
                    <?= $tag->name ?> -
                    <?= $tag->description ?>
                </div>
                <button onclick="deleteTag(<?= $tag->id ?>)">DELETE</button>
            </button>
            <?php
        }
        ?>
    </div>
    <!-- Tag Form -->

    <form class="flex flex-col w-64 p-6 border rounded-lg shadow-lg ml-auto" id="tag-form">
        <h2 >Add new tag</h1>
        <label for="name">Name</label>
        <input type="text" name="name" value="New Tag Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

        <label for="description">Description</label>
        <textarea name="description" value="desc field" rows=10 class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>


        <button name="submit">Submit</button>
    </form>
</div>

<script>
    // Register handlers for forms
    const tagForm = document.querySelector('#tag-form');
    const catForm = document.querySelector('#cat-form');
    tagForm.addEventListener("submit", handleTagSubmission, false);
    catForm.addEventListener("submit", handleCatSubmission, false);
    const frame = document.querySelector('#image-preview')

    function previewImage() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }

    // Handle Tag form
    async function handleTagSubmission(e) {
        e.preventDefault();

        const name = e.target.name.value;
        const description = e.target.description.value;

        const body = {
            name,
            description,
        };

        const res = await postTag(body);
        window.location.href = "http://localhost/admin/categories";
        Alpine.store('main').addMessage(res.status, res.message);
    }

    // Handle Category form, if no parent given make it a root category with no partent
    async function handleCatSubmission(e) {
        e.preventDefault();

        const name = e.target.name.value;
        const description = e.target.description.value;
        const parent = e.target.parent.value === 0 ? null : e.target.parent.value

        const body = {
            name,
            description,
            parent
        };

        const res = await postCategory(body);
        window.location.href = "http://localhost/admin/categories";
        Alpine.store('main').addMessage(res.status, res.message);
    }

    // API ROUTES, supply form body to relative api route to post or delete category or tag
    async function postTag(form) {
        const res = await fetch('http://localhost/api/tags', {
            method: "POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }

    async function postCategory(form) {
        const res = await fetch('http://localhost/api/categories', {
            method: "POST",
            body: JSON.stringify(form)
        });
        const json = await res.json();
        return json;
    }

    const deleteCategory = async (id) => {
        console.log(id)
        const res = await fetch('http://localhost/api/categories', {
            method: 'DELETE',
            body: JSON.stringify({
                'categoryId': id
            })
        });
        const json = await res.json();
        window.location.href = "http://localhost/admin/categories";
        Alpine.store('main').addMessage(json.status, json.message)
    }

    const deleteTag = async (id) => {
        console.log(id)
        const res = await fetch('http://localhost/api/tags', {
            method: 'DELETE',
            body: JSON.stringify({
                'tagId': id
            })
        });
        const json = await res.json();
        window.location.href = "http://localhost/admin/categories";
        Alpine.store('main').addMessage(json.status, json.message)
    }


</script>