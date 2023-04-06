<?php

if(isset($_FILES['image']))
{

	$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

	$new_name = $_FILES['image']['name'];

	move_uploaded_file($_FILES['image']['tmp_name'], base_path('public/images/' . $new_name));

	$data = array(
		'image_source'		=>	'images/' . $new_name
	);

	echo json_encode($data);

}