<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';?>
		<h1> Forum</h1>
		<p> well dont talk so muhc gv me sm idea to talk about</p>

		<table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFF99">

<form id="form1" name="form1" method="post" action="add_topic.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFF99">

<td colspan="3" bgcolor="#FFFF99"><strong>Create New Topic</strong> </td>

<tr>
<td width="14%"><strong>Topic</strong></td>
<td width="2%">:</td>
<td width="84%"><input name="topic" type="text" id="topic" size="50" /></td>
</tr>
<tr>
<td valign="top"><strong>Detail</strong></td>
<td valign="top">:</td>
<td><textarea name="detail" cols="50" rows="3" id="detail"></textarea></td>
</tr>
<tr>
<td><strong>Name</strong></td>
<td>:</td>
<td><input name="name" type="text" id="name" size="50" /></td>
</tr>
<tr>
<td><strong>Email</strong></td>
<td>:</td>
<td><input name="email" type="text" id="email" size="50" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Submit" /> <input type="reset" name="Submit2" value="Reset" /></td>
</tr>
</table>
</td>
</form>

</table>
   <?php


   include 'includes/overall/footer.php';?>