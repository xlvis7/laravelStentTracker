<?php

function change_password($user_id, $password)
{
	$user_id = (int)($user_id);
	$password = md5($password);
	
$myQuery = "UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id";

	mysql_query($myQuery);

	echo "<br/>" . $myQuery;
}

function register_user($register_data) 
{
	array_walk($register_data, 'array_sanitize'); //array_walk: walk thru every element of teh array and apply smtg to it n return the data
	$register_data['password'] = md5($register_data['password']);


	$fields = '`' . implode('`, `', array_keys($register_data)) . '`'; // output all thekeys of the array we pass theru in ex: username.passsword''
	$data = '\'' . implode('\', \'', $register_data) . '\'';

	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)"); //this produce the exatc string t insert into database
}

function user_count()
{
	return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), 0);
}

function user_data($user_id)
{
	$data = array();
	$user_id = (int)$user_id;

	$func_num_args = func_num_args();
	$func_get_args = func_get_args();

	if($func_num_args > 1)
	{
		unset($func_get_args[0]); //remove session user id to create the field set
		$fields = '`' . implode('`, `', $func_get_args) . '`';
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id")); //returns a row from a recordset as an associative array
		
		//echo ("    fields = $fields");
		//echo ("    data = $data");
		
		return $data;
	}
}


function logged_in()
{
	return (isset($_SESSION['user_id'])) ? true : false;
}

function user_exists($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
	return (mysql_result($query, 0) == 1) ? true : false;
}


function email_exists($email)
{
	$email = sanitize($email); // sanitize to prevent sql injection 
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
	return (mysql_result($query, 0) == 1) ? true : false;
}

function user_active($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `active` = 1");
	return (mysql_result($query, 0) == 1) ? true : false;
}

function user_id_from_username($username)
{
	$username = sanitize($username);
	return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"), 0, 'user_id');
}

function login($username, $password)
{
	$user_id = user_id_from_username($username);
	$username = sanitize($username);
	$password = md5($password);
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'"), 0) == 1) ? $user_id : false;
}
?>