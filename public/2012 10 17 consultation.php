<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';


   $counter = 1;
   
if( isset( $_POST['Submit'] ) )
{
	$_SESSION['counter2'] = $_SESSION['counter2'] + 1;
	$counter = $_SESSION['counter2'];
	
	//echo "Counter =" . $counter; 
	
	accessRules();
}//end if( isset( $_POST["resetButton"] ) )
else
{
	
	$_SESSION['counter2'] = 1;
	//echo "Setting Counter!!!";
	
	accessRules();
}
?>


</br>
</br>
<form name ="formOne" Method ="Post" ACTION ="consultation.php">
<?php
//<Form name ="formOne" Method ="Post" ACTION ="RadioButton.php">
?>
<Input type = 'Radio' Name ='gender' value= 'male'>Yes
</br>
<Input type = 'Radio' Name ='geznder' value= 'fexaxmale'>No
</br>
<P>
<Input type = "Submit" Name = "Submit" Value = "Submit">
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