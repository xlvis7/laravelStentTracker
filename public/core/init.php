<?php
session_start ();
error_reporting (0);
require 'database/connect.php';
require 'functions/general.php';
require 'functions/users.php';

if(logged_in() === true){
$session_user_id = $_SESSION['user_id']; // contain the user id
$user_data = user_data($session_user_id, 'user_id', 'username', 'password',  'first_name', 'last_name', 'email', 'active', 'role', 'Title', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');

if(user_active($user_data['username']) === false) {
session_destroy();
header('Location: index.php');
exit();
}

}
$errors = array();
?>