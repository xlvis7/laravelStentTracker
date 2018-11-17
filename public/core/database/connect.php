<?php
$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';

mysql_connect ('127.0.0.1','root','mysql') or die($connect_error);
mysql_select_db('seru_students')or die($connect_error);
?>