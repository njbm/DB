<?php include_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'config.php') ?>
<?php

use \BITM\SEIP12\Slider;
use \BITM\SEIP12\Utility\Validator;
use \BITM\SEIP12\Utility\Utility;

$id = Utility::sanitize($_POST['id']);

if (!Validator::empty($id)) {
    $slider = new Slider();
    $result = $slider->delete($id);
} else { // REfactor using Session based message
    dd("Id cannot be null or empty");
}

if ($result) { // edge case is not handled. if it writes nothing. length = 0
    
    $message = "Data is Deleted Successfully";
    set_session('message',$message);
    redirect('slider_index.php');
}

?>
