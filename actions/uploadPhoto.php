<?php
include "../classes/user.php";
session_start();

$user_id = $_SESSION['user_id'];
$image_name = $_FILES['photo']['name'];
// $image_name = "apricot.jpeg";
$tmp_name = $_FILES['photo']['tmp_name'];
// $tmp_name = "C:\xampp\tmp\php16F7.tmp";

$user = new User;
$user->uploadPhoto($user_id, $image_name, $tmp_name);

// $_FILES is a 2-dimensional array. The first array is the name of the element. The second element is the property of the file.
// [name] -> name of the filee
// [tmp_name] ->  path of the file inside the temporary storage in your computer (Example: /tmp/php/php6hst32)
// [size] -> size of the file in bytes
// [error] -> the error code of the file (0 if no error)
