<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';

/*
sir i have try included the array to store the answer for the consultation page..
but i still see some error sir on it especially in line 30 when i try run it..
my concept in line 30 is for each posted answer, if the user answer yes, 
a 1 integer value will be assign to the $answer[$counter] at line 32, 
if the user answer no, a integer value o will be assigned to$answer[$counter].. 
but there's still error sir */

	$counter = 1;
	$arrayIndex = 0;
   
if( isset( $_POST['submit'] ))
{
	if(isset( $_POST['userResponse'] ))
	{
		$_SESSION['counter2'] = $_SESSION['counter2'] + 1;
	}
	$counter = $_SESSION['counter2'];
	$arrayIndex = $counter - 2;
	
	//echo "Counter =" . $counter; 
	
	
	if(isset( $_POST['userResponse'] ))
	{
		$_SESSION['answer'][$arrayIndex] = $_POST['userResponse'];
	}
	
	/*
	echo "<br\>arrayIndex =" . $arrayIndex . "="; 
	if($arrayIndex >= 0)
	{
		echo "<br\>answer =" . $_SESSION['answer'][$arrayIndex] . "="; 
		if($arrayIndex > 0)
		{
			echo "<br\>prev answer =" . $_SESSION['answer'][$arrayIndex - 1] . "="; 
		}
	}
	/**/
	
	accessRules();
}//end if( isset( $_POST["resetButton"] ) )
else
{
	
	$_SESSION['counter2'] = 1;
	//echo "Setting Counter!!!";
	
	$_SESSION['answer'] = array();
	
	accessRules();
}
?>

</br>
</br>
<form name ="formOne" method ="Post" action ="consultation.php">
<?php
//<Form name ="formOne" Method ="Post" ACTION ="RadioButton.php">
?>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "1" />Yes
</br>
<input type = 'radio' name = "userResponse" id = "userResponseNo" value = "0" />No
</br>
<P>
<input type = "submit" name = "submit" value = "submit" />
</form>




   <?php include 'includes/overall/footer.php';
   
   function accessRules()
   {
		global $counter;
		global $user_data;
 
 
		?>
		<h1> consultation page</h1>
		<?php echo $counter;?>) So <?php echo $user_data['first_name'];?> ,
		<?php
 
 
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", "")or die($connect_error);
			mysql_select_db("lr")or die($connect_error);
			
$sql = mysql_query("SELECT * FROM expert WHERE number = $counter");
try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
					$row_Val = $row["symptoms"];
					$row_Val2= $row["diagnose"];
					echo $row_Val, " and ".$row_Val2;
				}
				}
				else
				{
					/*
					$row_Val = "symptoms";
					$row_Val2= "diagnose";
					echo $row_Val, " and ".$row_Val2;
					/**/
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
			
			
   }//end function accessRules()
   
	
   
   ?>