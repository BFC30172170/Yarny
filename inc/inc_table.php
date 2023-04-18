<?php

function renderTable($con,$array){
    $result = '';
    $result .=  "<div class='flex flex-col w-full'>";
    foreach ($array as $key => $row) {
        $row = getDisplayValues($con,$row);
        if (isset($row->link)){
            $result .= "<a href='$row->link'>";
        }
        $result .= "<div class='flex flex-col w-full mt-2' id='$row->title'>";
        $result .= "<div class='flex w-full space-around mb-2 border-b-4'>";
        $result .= "<div class='flex space-between w-full items-center'><h3 class='flex'>$row->title</h3> <h4 class='flex ml-auto text-lg'>$row->subtitle</h4></div>";
        $result .= "</div>";
        if (isset($row->link)){
            $result .= "</a>";
        }
        foreach ($row->values as $col => $val) {
            $result .= "<div class='flex space-between";
            $result .= "<p class='block'>$col</p>";
            $result .= "<p class='block font-bold ml-auto'>$val</p>";
            $result .= "</div>";
        }
        $result .= "</div>";
    }
    $result .= '</div>';
    echo $result;

}


function getDisplayValues($con,$row){
    $class = get_class($row);
    $title = '';
    $subtitle = '';
    $link = null;
    $values = [];
    switch ($class) {
        case 'Address':
            $title = $row->postcode;
            $subtitle = $row->line1;
            $values = [
                "Forename" => $row->forename,
                "Surname" => $row->surname,
                "Address Line 1" => $row->line1,
                "Address Line 2" => $row->line2,
                "Address Line 3" => $row->line3,
                "Town / City" => $row->town,
                "Postcode" => $row->postcode,
                "Country" => $row->country,
            ];
            break;

        case 'Sale':
            $title = "Order #$row->id";
            $subtitle = $row->created;
            $values = [
                "Ordered on" => $row->created,
                "Processed on" => $row->processed,
                "Dispatched on" => $row->dispatched,
                "Estimated arrival" => $row->estimatedArrival,
                "Status" => $row->status,
                "Address" => $row->address->postcode . ', ' . $row->address->line1,
            ];
            foreach ($row->saleRows as $key => $saleRow) {
                $product = Product::getProduct($con,$saleRow->product);
                $values["$saleRow->quantity * $product->name"] = $saleRow->quantity * $saleRow->finalPrice;
            };
            break;

        case 'Review':
            $product = Product::getProduct($con,$row->product);
            $title = "$product->name";
            $subtitle = "$row->score/10";
            $values = [
                "Review Title" => $row->name,
                "Review Description" => $row->description,
                "Active? " => $row->active == 1 ? 'Active' : 'Inactive'
            ];
            break;

        case 'Account':
            $title = $row->username;
            $subtitle = $row->email;
            $values =[
                "Username" => $row->username,
                "User ID" => $row->id,
                "Email" => $row->email,
                "Telephone" => $row->telephone,
                "Mobile" => $row->mobile,
                "Role" => $row->role,
                "created" => $row->created,
            ];
            break;
        case 'Product':
            $title = $row->name;
            $subtitle = $row->price;
            $link = "/products/$row->id";
            $values =[
                "Slug" => $row->slug,
                "Description" => $row->description,
                "Active" => $row->active == 1 ? 'Active' : 'Inactive',
            ];
            break;

        case 'Message':
            $account = Account::getAccount($con,$row->account);
            $title = $row->name;
            $subtitle = $row->created;
            $values = [
                "Title" => $row->name,
                "Description" => $row->description,
                "Created On" => $row->created,
                "Created By" => $account->username,
            ];
            if ($_SESSION['role'] !='admin'){
                $values = [];
            }
            break;

        default:
            echo 'not here';
            break;
    }
    $tr = new TableRow($title,$subtitle,$values,$link);
    return $tr;
}


class TableRow
{
    function __construct($title,$subtitle,$values,$link = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->link = $link;
        $this->values = $values;

    }
    public $title;
    public $subtitle;
    public $link;
    public $values;


}
