<?php
include "../classes/user.php";

// Collect the data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Create an object
$user = new User;

// Call the method
$user->createUser($first_name, $last_name, $username, $password);

