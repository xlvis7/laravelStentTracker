<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';


$_SESSION['currentYear'] = date("Y");
$_SESSION['currentMonth'] = date("n");
$_SESSION['currentDate'] = date("d");

if($user_data['role'] != 'administrator' && $user_data['role'] != 'doctor')
{
	header("location: register_student_course.php");
}
 
 
	
		
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
//SHOULD BE DIFFERENT FOR INSTALLED SERU BECAUSE OF THE root PASSWORD 'jhtp6'
		//$dbconn = mysql_connect("localhost", "root", "jhtp6")or die($connect_error);
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
			mysql_select_db("seru_students")or die($connect_error);


	$counter = 1;
	$arrayIndex = 0;
	$row_Val3;
	
	$total=0;
	$totalcf=0;
	$currentCF = 0;
	$prevAnswer =0;
	$prevCF = 0;
	$minCF = 0;
	
	$No;
	$Programmes;
	$Date;
	$Year;
	$role;
	$Credits;
	$Attendance;
	$changeValue;
	$Cost;
	$Number_Of_Students;
	$Time;
	$JoinedWith;
	
	
	
   
if( isset( $_POST['submit'] ))
{
	$_SESSION['search'] = $_POST['search'];
	
	if(isset( $_POST['userResponse'] ))
	{
		$_SESSION['counter2'] = $_SESSION['counter2'] + 1;
	}
	$counter = $_SESSION['counter2'];
	$arrayIndex = $counter - 2;
	
	//echo "Counter =" . $counter; 
	
	$my_little_counter = 0;
	
	while($my_little_counter < $_SESSION['counterMax'])
	{	
		//echo "<br/>LASTA = " . $_POST['Year2'] . "=   <br/>";
		//echo "<br/>LAST = " . $_POST["Year1"] . "=   ";
	
					
		$changeValue = "" . $_POST["changeValue". $my_little_counter];
				
		//echo "<br/>CHANGE = " . $changeValue . "=   CounterMax =" . $_SESSION['counterMax'] . "=";
		
		if($changeValue == "true" && $user_data['role'] == 'administrator' || $changeValue == "true" && $user_data['role'] == 'doctor' )
		{			
			updateUsers($my_little_counter);
		}//end if($changeValue == true)
	
		$my_little_counter++;
	}//end while($my_little_counter < $_SESSION['counterMax'])
	
	
	
	if(isset( $_POST['userResponse'] ))
	{
		$selected_radio = $_POST['userResponse'];
	
		$_SESSION['answer'][$arrayIndex] = $_POST['userResponse'];
		
		if($selected_radio == 100)
		{
			$_SESSION['answer_Literal'][$arrayIndex] = "Extreme";
		}
		else if($selected_radio == 75)
		{
			$_SESSION['answer_Literal'][$arrayIndex] = "High";
		}
		else if($selected_radio == 50)
		{
			$_SESSION['answer_Literal'][$arrayIndex] = "Moderate";
		}
		else if($selected_radio == 25)
		{
			$_SESSION['answer_Literal'][$arrayIndex] = "Minimal";
		}
		else if($selected_radio == -100)
		{
			$_SESSION['answer_Literal'][$arrayIndex] = "Not Experiencing This Symptom";
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
	
		if($counter >$_SESSION['numglobalMax'])
		{
			header('Location: history.php');
			exit();
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
	
	}//end if(isset( $_POST['userResponse'] ))
	
	
	
	//accessRules();//1 of 2
	
}//end if( isset( $_POST["resetButton"] ) )
else
{
$_SESSION['search'] = "";


$_SESSION['numglobalMax'] = 0;
	$_SESSION['cfglobal'] = 0;
	$_SESSION['cfglobalMax'] = 0;
	$_SESSION['ActualCFFinal'] = 0;
	$_SESSION['counter2'] = 1;
	$_SESSION['counterMax'] = 1;
	//echo "Setting Counter!!!";
	
	$_SESSION['answer'] = array();
	$_SESSION['answer_Literal'] = array();
	
	getMaximumCFValue();
	
	//accessRules();//2 of 2
	getMaxCounterVal();


}
mainDisplay();



function mainDisplay()
{
?>
</br>
</br>
<form name ="formOne" method ="Post" action ="register_for_course.php">
<?php
	accessRulesDisp();
?>

<P>

	
</form>

<!--
<h1> <?php echo $user_data['Date'];?> You have answered <?php echo $counter-1;?> question and total marks accumulated <?php echo $_SESSION['ActualCFFinal'];?> <?php echo $_SESSION['numglobalMax'];?> </h1>
-->



   <?php 
   }//end function mainDisplay()
   
   include 'includes/overall/footer.php';
   
    
   function accessRulesDisp()
   {
		global $counter;
		global $user_data;
		global $total;
		
		
		global $No;
		global $Programmes;
		global $Date;
		global $Year;
		global $role;
		global $Credits;
		global $changeValue;
		global $Attendance;
		global $Cost;
		global $Number_Of_Students;
		global $Time;
		global $JoinedWith;
		
		$JoinedWith = "NONE";
		
		$my_little_counter = 0;
		$my_little_counter_disp = 1;
		
		if(!isset($_SESSION['search']))
		{
			$_SESSION['search'] = "";
		}
		
			
 
		?>
		<h1> STENT MANAGEMENT PAGE</h1>
		
		
					<label for="search">Search</label>
					&nbsp;&nbsp;
					<input class="boxshadow" type="text" name="search" id="search" value="<?php echo "" . $_SESSION['search']; ?>" />
					
					&nbsp;&nbsp;
					<input class="button2 p5 width90" type = "submit" name = "submit" value = "Submit" />
					</br>
		<?php
		
			//user_data($session_No, 'No', 'Programmes', 'password',  'Date', 'Year', 'email', 'active', 'role', 'Credits', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');
			
			if($_SESSION['search'] == "")
			{
				$sql = mysql_query("SELECT * FROM seru_courses WHERE Date != 'DELETED' ORDER BY Year DESC;");
				//$sql = mysql_query("SELECT * FROM users WHERE role like '%student%'");
			}
			else
			{
				$searchString = str_replace ("'", "\'", $_SESSION['search']);
									
				
				$sql = mysql_query("SELECT * FROM seru_courses WHERE Date != 'DELETED' AND (Programmes LIKE '%" . 
									$searchString . "%' OR Date LIKE '%" . $searchString . "%' OR Year LIKE '%" . 
									$searchString . "%' OR Credits LIKE '%" . 
									$searchString . "%' OR Attendance LIKE '%" . $searchString . "%' OR Cost LIKE '%" . 
									$searchString . "%') ORDER BY Year DESC;");
			}

			
			try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
					//$row_Val = $row["symptoms"];
					//$row_Val2 = $row["diagnose"];
					//$_SESSION['cfglobal'] = $row["CF"];
					
					$row_Val = $row["Programmes"];
					
					$No = $row["No"];
					$Programmes = $row["Programmes"];
					$Date = $row["Date"];
					$Year = $row["Year"];
					$active = $row["active"];
					$role = $row["role"];
					$Credits = $row["Credits"];
					$Attendance = $row["Attendance"];
					$Cost = $row["Cost"];
					$Number_Of_Students = $row["Number_Of_Students"];
					$Time = $row["Time"];
					$JoinedWith = $row["JoinedWith"];
					
					$_SESSION['ORI_Number_Of_Students'] = $Number_Of_Students;
					$_SESSION['ORI_JoinedWith'] = $JoinedWith;
			/*
			echo "<br/>TEST LAST = " . $Date . "=   ";
			echo "<br/>TEST LAST = " . $Year . "=   ";
			echo "<br/>TEST LAST = " . $role . "=   ";
			echo "<br/>TEST LAST = " . $Credits . "=   ";
			/**/
					
					echo "<br/><br/>";
					
					$my_little_counter_disp = $my_little_counter + 1;
					echo "" . $my_little_counter_disp . ") ";
					
					$_SESSION["No" . $my_little_counter] = $No;
					?>
					
					<label for="<?php echo "Programmes" . $my_little_counter;?>">Stent Name*</label>
					<input class="boxshadow" type="text" name="<?php echo "Programmes" . $my_little_counter;?>" id="<?php echo "Programmes" . $my_little_counter;?>" value="<?php echo "$Programmes";?>" />
					&nbsp;&nbsp;
					<label for="<?php echo "Date" . $my_little_counter;?>">Date*</label>
					<input class="boxshadow" type="text" name="<?php echo "Date" . $my_little_counter;?>" id="<?php echo "Date" . $my_little_counter;?>" value="<?php echo "$Date";?>" />
					&nbsp;&nbsp;
					<label for="<?php echo "Time" . $my_little_counter;?>">Time*</label>
					<input class="boxshadow" type="text" name="<?php echo "Time" . $my_little_counter;?>" id="<?php echo "Time" . $my_little_counter;?>" value="<?php echo "$Time";?>" />
					</br></br>
					<label for="<?php echo "Year" . $my_little_counter;?>">Expiry Year*</label>
					<input class="boxshadow" type="text" name="<?php echo "Year" . $my_little_counter;?>" id="<?php echo "Year" . $my_little_counter;?>" value="<?php echo "$Year";?>" />
					&nbsp;&nbsp;
					
					<!--
					<!Multi Select!>
					<label for="<?php echo "role" . $my_little_counter;?>">role*</label>
					<select name = "<?php echo "role" . $my_little_counter;?>" id = "<?php echo "role" . $my_little_counter;?>" size = "1" multiple = "multiple">
					<?php
					if($role == "student")
					{
						?>
						<option value = "student" selected = "selected">student</option>
						<option value = "administrator">administrator</option>
						<?php
					}
					else if($role == "administrator")
					{
						?>
						<option value = "administrator" selected = "selected">administrator</option>
						<option value = "student">student</option>
						<?php
					}
					else if($role == "doctor")
					{
						?>
						<option value = "doctor" selected = "selected">doctor</option>
						<option value = "student">student</option>
						<?php
					}
					?>
					</select>
					-->
					
					<label for="<?php echo "Credits" . $my_little_counter;?>">Duration</label>
					<input class="boxshadow" type="text" name="<?php echo "Credits" . $my_little_counter;?>" id="<?php echo "Credits" . $my_little_counter;?>" value="<?php echo "$Credits";?>" />
					</br></br>
					<label for="<?php echo "Attendance" . $my_little_counter;?>">No of Check Ups</label>
					<input class="boxshadow" type="text" name="<?php echo "Attendance" . $my_little_counter;?>" id="<?php echo "Attendance" . $my_little_counter;?>" value="<?php echo "$Attendance";?>" />
					&nbsp;&nbsp;
					<label for="<?php echo "Cost" . $my_little_counter;?>">Cost</label>
					<input class="boxshadow" type="text" name="<?php echo "Cost" . $my_little_counter;?>" id="<?php echo "Cost" . $my_little_counter;?>" value="<?php echo "$Cost";?>" />
					</br></br>
					<label for="<?php echo "Number_Of_Students" . $my_little_counter;?>">Number of Patients</label>
					<input class="boxshadow" type="text" name="<?php echo "Number_Of_Students" . $my_little_counter;?>" id="<?php echo "Number_Of_Students" . $my_little_counter;?>" value="<?php echo "$Number_Of_Students";?>" />
					&nbsp;&nbsp;
					
					
					<label for="<?php echo "JoinedWith" . $my_little_counter;?>">Joined With</label>
					<input class="boxshadow" type="text" name="<?php echo "JoinedWith" . $my_little_counter;?>" id="<?php echo "JoinedWith" . $my_little_counter;?>" value="<?php echo "$JoinedWith";?>" />
					<br/><br/>
					
					<label for="<?php echo "ID" . $my_little_counter;?>">ID</label>
					<input class="boxshadow" type="text" name="<?php echo "ID" . $my_little_counter;?>" id="<?php echo "ID" . $my_little_counter;?>" readonly="true" value="<?php echo "$No";?>" />
					
					
					
					<br/>
					</br>
					<!Checkbox!>
					<label for="<?php echo "changeValue" . $my_little_counter;?>">UPDATE</label>
					<input class="boxshadow" type="checkbox" name="<?php echo "changeValue" . $my_little_counter;?>" id="<?php echo "changeValue" . $my_little_counter;?>" value="true" />
					
					<!Checkbox!>
					<label for="<?php echo "deleteValue" . $my_little_counter;?>">DELETE STENT</label>
					<input class="boxshadow" type="checkbox" name="<?php echo "deleteValue" . $my_little_counter;?>" id="<?php echo "deleteValue" . $my_little_counter;?>" value="true" />
					
					<input class="button2 p5 width90" type = "submit" name = "submit" value = "Submit" />
					</br></br>
					<!--<!Multi Select!>
					<label for="<?php echo "multiValue" . $my_little_counter;?>">multiValue</label>
					<select name = "multiValue" id = "multiValue" size = "3" multiple = "multiple">
						<option value = "1">1</option>
						<option value = "2">2</option>
						<option value = "3">3</option>
						<option value = "4">4</option>
						<option value = "5">5</option>
					</select>
					-->
					
					
					<?php
					
					/*
					<label for="<?php echo "" . $my_little_counter;?>"></label>
					<input type="text" name="<?php echo "" . $my_little_counter;?>" id="<?php echo "" . $my_little_counter;?>" value="<?php echo "$";?>" />
					
					<label for=""></label>
					<input type="text" name="" id="" value="<?php echo "$";?>" />
					*/
										
					
					//echo "User ".$row_Val . "<br/>";
					$my_little_counter++;
					$_SESSION['counterMax'] = $my_little_counter;
				}//end while($row = mysql_fetch_assoc($sql))
				}
				else
				{
					echo "EMPTY...";
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
			
					$my_little_counter_disp = $my_little_counter + 1;
					echo "<br/><br/>" . $my_little_counter_disp . ") ";
					
					$No = getMaxUserID() + 1;
					//echo "<br/>MAX ID = " . $No;
					//$No = $No + 1;
					$Programmes = "";
					$Date = "";
					$Year = "";
					$role = "";
					$Credits = "";
					$Number_Of_Students = 50;
					$Time = "0";
					$JoinedWith = 0;
					
					echo "ADD NEW STENT:<br/>";
					$_SESSION["No" . $my_little_counter] = $No;
					?>
					</br></br>
					<label for="<?php echo "Programmes" . $my_little_counter;?>">Stent Name*</label>
					<input class="boxshadow" type="text" name="<?php echo "Programmes" . $my_little_counter;?>" id="<?php echo "Programmes" . $my_little_counter;?>" value="<?php echo "$Programmes";?>" />
					&nbsp;&nbsp;
					<label for="<?php echo "Date" . $my_little_counter;?>">Date*</label>
					<input class="boxshadow" type="text" name="<?php echo "Date" . $my_little_counter;?>" id="<?php echo "Date" . $my_little_counter;?>" value="<?php echo "$Date";?>" />
					&nbsp;&nbsp;
					<label for="<?php echo "Time" . $my_little_counter;?>">Time*</label>
					<input class="boxshadow" type="text" name="<?php echo "Time" . $my_little_counter;?>" id="<?php echo "Time" . $my_little_counter;?>" value="<?php echo "$Time";?>" />
					</br></br>
					<label for="<?php echo "Year" . $my_little_counter;?>">Expiry Year*</label>
					<input class="boxshadow" type="text" name="<?php echo "Year" . $my_little_counter;?>" id="<?php echo "Year" . $my_little_counter;?>" value="<?php echo "$Year";?>" />
					&nbsp;&nbsp;
					
					
					<!--
					<!Multi Select!>
					<label for="<?php echo "role" . $my_little_counter;?>">role*</label>
					<select name = "<?php echo "role" . $my_little_counter;?>" id = "<?php echo "role" . $my_little_counter;?>" size = "1" multiple = "multiple">
					<?php
					if($role == "student")
					{
						?>
						<option value = "student" selected = "selected">student</option>
						<option value = "administrator">administrator</option>
						<option value = "doctor">doctor</option>
						<?php
					}
					else if($role == "administrator")
					{
						?>
						<option value = "administrator" selected = "selected">administrator</option>
						<option value = "student">student</option>
						<option value = "doctor">doctor</option>
						<?php
					}
						else if($role == "doctor")
					{
						?>
						<option value = "doctor" selected = "selected">doctor</option>
						<option value = "student">student</option>
						<option value = "administrator">administrator</option>
						<?php
					}
					else
					{
						?>
						<option value = "student" selected = "selected">student</option>
						<option value = "administrator">administrator</option>
						<option value = "doctor">doctor</option>
						<?php
					}
					?>
					</select>
					-->
					
					
					<label for="<?php echo "Credits" . $my_little_counter;?>">Duration</label>
					<input class="boxshadow" type="text" name="<?php echo "Credits" . $my_little_counter;?>" id="<?php echo "Credits" . $my_little_counter;?>" value="<?php echo "$Credits";?>" />
					&nbsp;&nbsp;
					
					
					<label for="<?php echo "Attendance" . $my_little_counter;?>">No of Check Ups</label>
					<input class="boxshadow" type="text" name="<?php echo "Attendance" . $my_little_counter;?>" id="<?php echo "Attendance" . $my_little_counter;?>" value="<?php echo "$Attendance";?>" />
					</br></br>
		
					<label for="<?php echo "Cost" . $my_little_counter;?>">Cost</label>
					<input class="boxshadow" type="text" name="<?php echo "Cost" . $my_little_counter;?>" id="<?php echo "Cost" . $my_little_counter;?>" value="<?php echo "$Cost";?>" />
					&nbsp;&nbsp;
					
					<label for="<?php echo "Number_Of_Students" . $my_little_counter;?>">Number of Patients</label>
					<input class="boxshadow" type="text" name="<?php echo "Number_Of_Students" . $my_little_counter;?>" id="<?php echo "Number_Of_Students" . $my_little_counter;?>" value="<?php echo "$Number_Of_Students";?>" />
					&nbsp;&nbsp;
					
					<label for="<?php echo "JoinedWith" . $my_little_counter;?>">Joined With</label>
					<input class="boxshadow" type="text" name="<?php echo "JoinedWith" . $my_little_counter;?>" id="<?php echo "JoinedWith" . $my_little_counter;?>" readonly="true" value="<?php echo "$JoinedWith";?>" />
					&nbsp;&nbsp;
					
					<!Checkbox!>
					<label for="<?php echo "changeValue" . $my_little_counter;?>">ADD</label>
					<input class="boxshadow" type="checkbox" name="<?php echo "changeValue" . $my_little_counter;?>" id="<?php echo "changeValue" . $my_little_counter;?>" value="true" />
					
					
					<input class="button2 p5 width90" type = "submit" name = "submit" value = "Submit" />
					
					<?php
					$my_little_counter++;
					$_SESSION['counterMax'] = $my_little_counter;
					
			
   }//end function accessRulesDisp()
   
   
   
   
   function updateUsers($my_little_counter)
   {		
		global $No;
		global $Programmes;
		global $Date;
		global $Year;
		global $role;
		global $Credits;
		global $Attendance;
		global $Cost;
		global $Number_Of_Students;
		global $Time;
		global $JoinedWith;
		
		
		$theQueryToExecute = "";
		
 
			
			$No = $_SESSION["No" . $my_little_counter];
			$Programmes = $_POST["Programmes" . $my_little_counter];
			$Date = $_POST["Date". $my_little_counter];
			$Year = $_POST["Year". $my_little_counter];
			$Credits = $_POST["Credits". $my_little_counter];
			$Attendance = $_POST["Attendance". $my_little_counter];
			$Cost = $_POST["Cost". $my_little_counter];
			$Time = $_POST["Time". $my_little_counter];
			/*
			echo "<br/>LAST Programmes= " . $Programmes . "=   ";
			echo "<br/>LAST No= " . $No . "=   ";
			echo "<br/>LAST Date= " . $Date . "=   ";
			echo "<br/>LAST Year= " . $Year . "=   ";
			echo "<br/>LAST role= " . $role . "=   ";
			echo "<br/>LAST Credits= " . $Credits . "=   ";
			/**/
			
			if($Attendance < 0)
			{
				$Attendance = 0;
			}
			
			if($Cost == "")
			{
				$Cost = "FOC";
			}
			
			$Programmes = str_replace ("'", "\'", $Programmes);
			$Date = str_replace ("'", "\'", $Date);
			$Year = str_replace ("'", "\'", $Year);
			$Cost = str_replace ("'", "\'", $Cost);
			
			
			if(is_numeric($_POST["JoinedWith". $my_little_counter]))
			{
				$JoinedWith = intval($_POST["JoinedWith". $my_little_counter]);
				//echo "IS NUMBER =" . $JoinedWith  . "=";
			}
			else
			{
				$JoinedWith = $_SESSION['ORI_JoinedWith'];
				//echo "NOT NUMBER";
				if(is_numeric($JoinedWith))
				{
				}
				else
				{
					$JoinedWith = 0;
				//echo "NOT NUMBER";
				}
			}
			
			if(is_numeric($_POST["Number_Of_Students". $my_little_counter]))
			{
				$Number_Of_Students = intval($_POST["Number_Of_Students". $my_little_counter]);
				//echo "IS NUMBER =" . $Number_Of_Students  . "=";
			}
			else
			{
				$Number_Of_Students = $_SESSION['ORI_Number_Of_Students'];
				//echo "NOT NUMBER";
			}
 
			if($Programmes == "")
			{
				echo "<br/>Programmes cannot be NULL";
			}
			else if($Date == "")
			{
				echo "<br/>Date cannot be NULL";
			}
			else if($Time == "")
			{
				echo "<br/>Time cannot be NULL";
			}
			else if($Year == "")
			{
				echo "<br/>Year cannot be NULL";
			}
			else if($Credits == "")
			{
				echo "<br/>Merit Points cannot be NULL";
			}
			else
			{
				
				if($_POST["deleteValue". $my_little_counter] == true)
				{
					$theQueryToExecute = "SELECT * FROM students WHERE courses = '" . $No . 
											"' AND (registered = 'registered' OR registered = 'completed' OR registered = 'notregistered' OR registered = 'incomplete' OR registered = 'unregistered');";
											
					//echo "<br/>" . $theQueryToExecute;
					
					$sql = mysql_query($theQueryToExecute);
					
					if($sql != null && $row = mysql_fetch_assoc($sql) != null)
					{						
						//echo "<br/>courses =" . $row["courses"] . "= ";
						echo "<br/>PATIENTS ALREADY REGISTERED FOR STENT, DELETE NOT POSSIBLE!";
					}//end if($sql == null)
					else
					{
						//CANNOT DELETE BECAUSE THE INDEXES WILL CHANGE AND THE COURSES REGISTERED WILL NOT TALLY!!!
						/*$theQueryToExecute = "DELETE FROM seru_courses WHERE No = '" . $No . 
																"' AND Programmes = '". $Programmes .
																"' AND Date = '". $Date .
																"' AND Year = '". $Year .
																"' AND Credits = '". $Credits .
																"';";
																*/
						
						$theQueryToExecute = "UPDATE seru_courses SET Programmes = '". $Programmes .
																"', Date = 'DELETED', Year = '". $Year .
																"', Credits = '". $Credits .
																"', Attendance = '". $Attendance .
																"', Cost = '". $Cost .
																"', Number_Of_Students = '". $Number_Of_Students .
																"', Time = '". $Time .
																"', JoinedWith = '". $JoinedWith .
																"' WHERE No = '" . $No . "';";
																
						//echo "<br/> . The Query =" . $theQueryToExecute;
						
						$sql_mini_mini = mysql_query($theQueryToExecute);
						
						if($sql_mini_mini == null)
						{
							echo "<br/><br/>Could Not Delete Stent";
						}
						else
						{
							echo "<br/><br/>STENT DELETED";
						}
					}
				}//end if($_POST["deleteValue". $my_little_counter] == true)
				else if($No > getMaxUserID())
				{
					$JoinedWith = 0;
					
					$theQueryToExecute = "INSERT INTO `seru_students`.`seru_courses`".
										" (`No`, `Programmes`, `Date`, ".
										"`Year`, `Credits`, `Attendance`, `Cost`, `Number_Of_Students`, `Time`, `JoinedWith`) ".
										"VALUES (" . $No . ", '" . $Programmes . "', '" . $Date . "', ".
										"'" . $Year . "', '" . $Credits . "', '" . $Attendance . "', '" . $Cost . "', '" . 
										$Number_Of_Students . "', '" . $Time . "', '" . $JoinedWith . "');";
										
					
					//echo "<br/>" . $theQueryToExecute;
										
					$sql = mysql_query($theQueryToExecute);
										
					if($sql == null)
					{
						echo "<br/><br/>Could Not Add Stent";
					}
					else
					{
						echo "<br/>NEW STENT ADDED";
					}
				}//end if($No > getMaxUserID())
				else
				{			
					$sql = mysql_query("UPDATE seru_courses SET Programmes = '". $Programmes .
																"', Date = '". $Date .
																"', Year = '". $Year .
																"', Credits = '". $Credits .
																"', Attendance = '". $Attendance .
																"', Cost = '". $Cost .
																"', Number_Of_Students = '". $Number_Of_Students .
																"', Time = '". $Time .
																"', JoinedWith = '". $JoinedWith .
																"' WHERE No = '" . $No . "';");
											
					if($sql == null)
					{
						echo "<br/><br/>Could Not Update Stent";
					}
					else
					{
						echo "<br/>DATABASE UPDATED";
					}
				}//end else for if($sqlTest == null)
			}
   }//end function updateUsers()
   
   
	function getMaxUserID()
	{
			$finalcounter = 0;
			$sql = mysql_query("SELECT * FROM seru_courses");
			
			try
			{
				if(!empty($sql))
				{	
					$_SESSION['numIDMax'] = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["No"];
						if($finalcounter > $_SESSION['numIDMax'])
						{
							$_SESSION['numIDMax'] = $finalcounter;
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
			
			return $_SESSION['numIDMax'];
	}//end function getMaxUserID()
   
   function accessRulesB()
   {
		global $counter;
		global $user_data;
		global $total;
		global $mysqlPassword;
 
		?>
		<h1> consultation page</h1>
		<?php echo $counter; ?>) So <?php echo $user_data['Date'];?> ,
		<?php
 
 
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
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
			
			
			
   }//end function accessRulesB()
   
   function getMaximumCFValue()
   {
		global $currentCF;
		global $mysqlPassword;
   
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
			mysql_select_db("seru_students")or die($connect_error);
			
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
   
	function getMaxCounterVal()
	{
	global $finalcounter;
			$sql = mysql_query("SELECT * FROM expert");
			try{
			if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
				$finalcounter= $row["number"];
				if($finalcounter > $_SESSION['numglobalMax']){
				$_SESSION['numglobalMax']=$finalcounter;
				}
				}
				}
				else {}
				}
				catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
				
	}
   
   
			mysql_close($dbconn) or die ("could not close database");
   
   ?>