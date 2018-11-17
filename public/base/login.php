<?php
include 'core/init.php';
logged_in_redirect();
if(empty($_POST) === false){
$username = $_POST['username'];
$password = $_POST['password'];
if(empty($username) === true || empty($password) === true ){
$errors[] ='you need to enter a username and a password';
}
else if (user_exists($username) === false){
$errors[] ='this username and password isnt registered, have you registered?';
}
else if(user_active($username) === false){
$errors[] ='you have not activated your account yet';
}
else {
if(strlen($password) > 32){
$errors[] = 'the pasword is too long';
}
$login = login($username, $password);
if ($login === false){
$errors[] = 'That username/password combination is incorrect';
} else {
//set the user to session
$_SESSION['user_id'] = $login;
//redirect the user to home
header('Location: index.php');
exit();
}
}
}
else {
$errors[] = 'no data received';
}
include 'includes/overall/header.php';
// output_errors($errors); or below
// echo output_errors($errors); the 2nd method
if(empty($errors) === false){
?>
<h2> Login Failed: Please check your name and password...</h2>
<?php
echo output_errors($errors);
}
?>
 <IMG SRC="3.png" ALT="" WIDTH=300 HEIGHT=300 align="middle">
 
<?php
include 'includes/overall/footer.php';
?>