<?php include_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'config.php') ?>
<?php

use \BITM\SEIP12\Slider;
use \BITM\SEIP12\Utility\Utility;
use \BITM\SEIP12\Config;

$filename = $_FILES['picture']['name']; // if you want to keep the name as is
$filename = uniqid() . "_" . $_FILES['picture']['name']; // if you want to keep the name as is
$target = $_FILES['picture']['tmp_name'];
$destination = $uploads . $filename;

$src = null;
if (upload($target, $destination)) {
    $src = $filename;
}


$slider = new Slider();

$slider->alt = Utility::sanitize($_POST['alt']);
$slider->title = Utility::sanitize($_POST['title']);
$slider->caption = Utility::sanitize($_POST['caption']);
$slider->src = $src;

$slider->created_by = "created-sdf";
$slider->updated_by = "created-sdf";
$slider->uuid = Utility::uuid();

if(Config::$driver == 'mysql'){
    $result = $slider->store($slider);
}elseif(Config::$driver == 'json'){
    $result = $slider->store($slider);
}
if ($result) {
    $message = "Data is Created Successfully";
    set_session('message',$message);
    redirect("slider_index.php");
} else {
    echo "Data is not stored";
}

