<?php

function logged_in_redirect()
{  // login...cant access register..this is the purpose of this function
	if(logged_in() === true)
	{
	header('Location: index.php');
	exit();
	}
}

function protect_page()
{
	if(logged_in() === false)
	{
		header('Location: protected.php');
		exit();
	}
}

function array_sanitize(&$item)
{
	$item = mysql_real_escape_string($item);
}

function sanitize($data)
{
	return mysql_real_escape_string($data);
}

function output_errors($errors)
{
/* $output = array();
foreach($errors as $error){
// echo $error, ', '; or the way below ** 1st method only this line
$output[] = '<li>' . $error . '</li>';
}
return '<ul>' . implode('', $output) . '</ul>'; the 2nd method */
return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
}

?>