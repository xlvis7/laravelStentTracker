<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';


	$counter = 1;
	$arrayIndex = 0;
	$row_Val3;
	
	$total=0;
	$totalcf=0;
	$currentCF = 0;
	$prevAnswer =0;
	$prevCF = 0;
	$minCF = 0;
   
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
	$selected_radio = $_POST['userResponse'];
		$_SESSION['answer'][$arrayIndex] = $_POST['userResponse'];
		
		
	}
	
	/*
	for($i=0; $i < $arrayIndex + 1; $i++)
	{	
		//echo "previous value= ".$_SESSION['answer'][$i] . ",     ,";
	}//end for($i=0; $i < $arrayIndex + 1; $i++)/**/
	
	
		//CF FACTOR CALCULATION:
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		/*The generally prescribed rule for adding certainty factors is as follows:
			CFcombine (CFa CFb) = CFa + CFb(1 - Cfa)
		The rule for adding two negative certainties is simple: Treat the two factors as positive and negate the result 
			CFcombine (CFe CFf) = -(CFcombine (-CFe -CFf))
		The rule for adding positive and negative certainty factors is more complex: 
			CFcombine (CFg CFh) =  (CFg + CFh) / (1 - min{|CFg|, |CFn|})
		Thus if your certainty for an instance is 0.88 and your certainty factor against it is 0.90, the result is: 
               -.17     = (.88 - -.90) / (1 - min(.88, .90))
                        =   -.02 / .12
		I.e. take the difference, and then multiply that value by the reciprocal of the smallest remaining uncertainty. 
		These three rules provide an interval scale for certainty factors.
		
		Since you do not have any uncertainty factors . . . we use values of:
		*/
	
	$prevAnswer = $_SESSION['answer'][$arrayIndex];
	$prevCF = $_SESSION['ActualCFFinal'];
	
	$currentCF = $_SESSION['cfglobal'] / $_SESSION['cfglobalMax'] * $prevAnswer / 100;
	
	if($prevCF < $currentCF)
	{
		$minCF = $prevCF;
	}
	else
	{
		$minCF = $currentCF;
	}
	
	if($currentCF >= 0)
	{
		if($prevCF >= 0)
		{
			//Both are positive so use the first formula;
			//echo "FORMULA 1: currentCF = " . $currentCF . ",   prevCF = " . $prevCF;
			
			$_SESSION['ActualCFFinal'] = $prevCF + $currentCF * (1 - $prevCF);
		}
		else
		{
			//One Positive and One Negative so use the Third formula;
			//echo "FORMULA 3A: currentCF = " . $currentCF . ",   prevCF = " . $prevCF;
			
			$_SESSION['ActualCFFinal'] = ($currentCF + $prevCF) / (1 - $minCF);
		}
	}//end if($currentCF >= 0)
	else
	{
		if($prevCF >= 0)
		{
			//One Positive and One Negative so use the Third formula;
			//echo "FORMULA 3B: currentCF = " . $currentCF . ",   prevCF = " . $prevCF;
			
			$_SESSION['ActualCFFinal'] = ($currentCF + $prevCF) / (1 - $minCF);
		}
		else
		{
			//Both are Negative So use the Second Formula;
			//echo "FORMULA 2: currentCF = " . $currentCF . ",   prevCF = " . $prevCF;
			
			$prevCF = $prevCF * -1;
			$currentCF = $currentCF * -1;
			$_SESSION['ActualCFFinal'] = ($prevCF + $currentCF * (1 - $prevCF)) * (-1);
		}
	}//end else for if($currentCF >= 0)
	
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	
	
	//echo "Total CF = " . $_SESSION['ActualCFFinal'] . "     ";
	
	
	
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
	$_SESSION['cfglobal'] = 0;
	$_SESSION['cfglobalMax'] = 0;
	$_SESSION['ActualCFFinal'] = 0;
	$_SESSION['counter2'] = 1;
	//echo "Setting Counter!!!";
	
	$_SESSION['answer'] = array();
	
	getMaximumCFValue();
	
	accessRules();
}
?>

</br>
</br>
<form name ="formOne" method ="Post" action ="consultation.php">
<?php
//<Form name ="formOne" Method ="Post" ACTION ="RadioButton.php">
?>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "100" />5 : Extreme
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "75" />4 : High
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "50" />3 : Moderate
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "25" />2 : Minimal
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "-100" />1 : Not Experiencing This Symptom
</br>

<P>
<input type = "submit" name = "submit" value = "submit" />
</form>
<h1> <?php echo $user_data['first_name'];?> You have answered <?php echo $counter-1;?> question and total marks accumulated <?php echo $_SESSION['ActualCFFinal'];?> </h1>


   <?php include 'includes/overall/footer.php';
   
   function accessRules()
   {
		global $counter;
		global $user_data;
		global $total;
 
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
					$row_Val2 = $row["diagnose"];
					$_SESSION['cfglobal'] = $row["CF"];
					
					echo "Does the ".$row_Val;
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
   
   function getMaximumCFValue()
   {
		global $currentCF;
   
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", "")or die($connect_error);
			mysql_select_db("lr")or die($connect_error);
			
$sql = mysql_query("SELECT * FROM expert");
try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
					$currentCF = $row["CF"];
					
					if($currentCF > $_SESSION['cfglobalMax'])
					{
						$_SESSION['cfglobalMax'] = $currentCF;
					}
				}
				}
				else
				{
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
   }//end function getMaximumCFValue()
   
	
   
   ?>