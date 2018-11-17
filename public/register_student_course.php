<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
	<style>
		div.dataTables_wrapper {
        width: 850px;
    	}	
	</style>
</head>
<body>

<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';


$_SESSION['currentYear'] = date("Y");
$_SESSION['currentMonth'] = date("n");
$_SESSION['currentDate'] = date("d");


					$_SESSION["Message_BLANK"] = "";
					$_SESSION["IC_number_BLANK"] = false;
					$_SESSION["Matric_Number_BLANK"] = false;
					$_SESSION["Hand_Phone_Number_BLANK"] = false;
					$_SESSION["Kolej_Kediaman_BLANK"] = false;
					$_SESSION["CGPA_BLANK"] = false;


if($user_data['role'] == 'administrator')
{
	header("location: register_for_course.php");
}



		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
			mysql_select_db("seru_students")or die($connect_error);
			
			$theQuery = "SELECT * FROM users WHERE username LIKE '" . $user_data['username'] . 
										"' AND password LIKE '" . $user_data['password'] . "' ORDER BY role;";
										
		$sql = mysql_query($theQuery);

//$sql = mysql_query("SELECT * FROM users WHERE role like '%student%'");
			try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{	
					//echo "WORKING";
					$row_Val = $row["username"];
					
					$user_id = $row["user_id"];
					$username = $row["username"];
					$password = $row["password"];
					$first_name = $row["first_name"];
					$last_name = $row["last_name"];
					$email = $row["email"];
					$active = $row["active"];
					$role = $row["role"];
					$Title = $row["Title"];
					$IC_number = $row["IC_Number"];
					$Matric_Number = $row["Matric_Number"];
					$Hand_Phone_Number = $row["Hand_Phone_Number"];
					$Kolej_Kediaman = $row["Kolej_Kediaman"];
					$CGPA = $row["CGPA"];
					$Registration_Date = $row["Registration_Date"];
					
					
					if($IC_number == "" || strtolower($IC_number) == "null")
					{
						$_SESSION["IC_number_BLANK"] = true;
					}
					if($Matric_Number == "" || strtolower($Matric_Number) == "null")
					{
						$_SESSION["Matric_Number_BLANK"] = true;
					}
					if($Hand_Phone_Number == "" || strtolower($Hand_Phone_Number) == "null")
					{
						$_SESSION["Hand_Phone_Number_BLANK"] = true;
					}
					if($Kolej_Kediaman == "" || strtolower($Kolej_Kediaman) == "null")
					{
						$_SESSION["Kolej_Kediaman_BLANK"] = true;
					}
					if($CGPA == "" || strtolower($CGPA) == "null")
					{
						$_SESSION["CGPA_BLANK"] = true;
					}
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
			
					

			mysql_close($dbconn) or die ("could not close database");

 
					$_SESSION["Message_BLANK"] = "";
					
		if($_SESSION["IC_number_BLANK"] == true)
		{
			$_SESSION["Message_BLANK"] = $_SESSION["Message_BLANK"] . "<br/>" . "Please UPDATE IC Number";
		}
		if($_SESSION["Matric_Number_BLANK"] == true)
		{
			$_SESSION["Message_BLANK"] = $_SESSION["Message_BLANK"] . "<br/>" . "Please UPDATE Matric Number";
		}
		if($_SESSION["Hand_Phone_Number_BLANK"] == true)
		{
			$_SESSION["Message_BLANK"] = $_SESSION["Message_BLANK"] . "<br/>" . "Please UPDATE Hand Phone Number";
		}
		if($_SESSION["Kolej_Kediaman_BLANK"] == true)
		{
			$_SESSION["Message_BLANK"] = $_SESSION["Message_BLANK"] . "<br/>" . "Please UPDATE Kolej Kediaman";
		}
		if($_SESSION["CGPA_BLANK"] == true)
		{
			$_SESSION["Message_BLANK"] = $_SESSION["Message_BLANK"] . "<br/>" . "Please UPDATE CGPA";
		}
		
		if($_SESSION["Message_BLANK"] == "")
		{
		}
		else
		{
			if($user_data['role'] == 'student')
			{
				header("location: register_student.php");
			}
		}


	
		
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
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
	$registered;
	$Credits;
	$changeValue;
	$student_id;
	$Cost;
	$Paid;
	$Number_Of_Students;
	$Time;
	$JoinedWith;
	
	$JOINEDWITHGROUP = 0;
	
	$testMessages;
	
	
	
   
if( isset( $_POST['submit'] ))
{
	$JOINEDWITHGROUP = -1;
	
	$_SESSION['registered_status'] = $_POST["registered_status_choice"];
	
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
		
		if($_SESSION["JoinedWith" . $my_little_counter] != 0 && 
			$_POST["registered". $my_little_counter] != $_SESSION["registeredOri" . $my_little_counter] && 
			$_POST["registered". $my_little_counter] != "")
		{
			$my_small_counter = 0;
			$currentRegisteredStatus = $_POST["registered". $my_little_counter];
			while($my_small_counter < $_SESSION['counterMax'])
			{
				if($_SESSION["JoinedWith" . $my_small_counter] == $_SESSION["JoinedWith" . $my_little_counter])
				{
					$_POST["registered". $my_small_counter] = $_POST["registered". $my_little_counter];
				}
				$my_small_counter++;
			}
				$JOINEDWITHGROUP = $JoinedWith;
		}
		
		$my_little_counter++;
	}//end while($my_little_counter < $_SESSION['counterMax'])
	
	
	
	
	$my_little_counter = 0;
	
	while($my_little_counter < $_SESSION['counterMax'])
	{	
		
	$_SESSION['errorcheck'] = "";
		//echo "<br/>LASTA = " . $_POST['Year2'] . "=   <br/>";
		//echo "<br/>LAST = " . $_POST["Year1"] . "=   ";
	
					
		$changeValue = "" . $_POST["changeValue". $my_little_counter];
				
		//echo "<br/>CHANGE = " . $changeValue . "=   CounterMax =" . $_SESSION['counterMax'] . "=";
		
	
		
		if($_POST["registered". $my_little_counter] != $_SESSION["registeredOri" . $my_little_counter] && $_POST["registered". $my_little_counter] != "")
		{		
			$_SESSION["registered" . $my_little_counter] = $_POST["registered". $my_little_counter];
			if($_SESSION["registeredOri" . $my_little_counter] != "completed" && 
				$_SESSION["registeredOri" . $my_little_counter] != "incomplete" && 
				$_SESSION["registeredOri" . $my_little_counter] != "unregistered" && 
				$_SESSION["registered" . $my_little_counter] != "")
			{
				//echo "<br/> Changed";
				updateUsers($my_little_counter);
			}
			else
			{
				echo "CONDITION " . $my_little_counter . "=" . $_SESSION["registered" . $my_little_counter] . "=";
			}
		}//end if($changeValue == true)
	
		$my_little_counter++;
	}//end while($my_little_counter < $_SESSION['counterMax'])
	
	
	
}//end if( isset( $_POST['submit'] ))
else
{
	$_SESSION['search'] = "";
	
	$_SESSION['registered_status'] = "all";
	
	$_SESSION['errorcheck'] = "";
	
$_SESSION['numglobalMax'] = 0;
	$_SESSION['cfglobal'] = 0;
	$_SESSION['cfglobalMax'] = 0;
	$_SESSION['ActualCFFinal'] = 0;
	$_SESSION['counter2'] = 1;
	$_SESSION['counterMax'] = 1;
	
	
	$_SESSION['student_id'] = 0;
	$_SESSION['user_id'] = $user_data['user_id'];
	
	//echo "" . $user_data['user_id'];
	
	//echo "Setting Counter!!!";
	
	$_SESSION['answer'] = array();
	$_SESSION['answer_Literal'] = array();
	
}
mainDisplay();



function mainDisplay()
{
?>
</br>
</br>
<form name ="formOne" method ="Post" action ="register_student_course.php">
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
		global $registered;
		global $Credits;
		global $changeValue;
		global $student_id;
		global $Cost;
		global $Paid;
		global $Number_Of_Students;
		global $Time;
		global $JoinedWith;
		
		global $testMessages;
		
		$my_little_counter = 0;
		$my_little_counter_disp = 1;
		
		if(!isset($_SESSION['search']))
		{
			$_SESSION['search'] = "";
		}
 
		?>
		<h1> STENT REGISTRATION PAGE</h1>
		
		<br/><br/>
					<label for="search">Search</label> &nbsp;&nbsp;
					<input class="boxshadow" type="text" name="search" id="search" value="<?php echo "" . $_SESSION['search']; ?>" />
					<br/><br/>
					
					<!Multi Select!>
					<label for="<?php echo "registered_status_choice"?>">Select Registered Status</label>&nbsp;&nbsp;
					<select class="boxshadow" name = "<?php echo "registered_status_choice";?>" id = "<?php echo "registered_status_choice";?>">
					<?php
					if($_SESSION['registered_status'] == "all")
					{
						?>
						<option value = "all" selected = "selected">ALL</option>
						<option value = "registered">REGISTERED</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "unregistered">DROPPED</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "registered")
					{
						?>
						<option value = "registered" selected = "selected">REGISTERED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "unregistered">DROPPED</option>
						<option value = "all">ALL</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "unregistered")
					{
						?>
						<option value = "unregistered" selected = "selected">DROPPED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "registered">REGISTERED</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<option value = "all">ALL</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "completed")
					{
						?>
						<option value = "completed" selected = "selected">COMPLETED</option>
						<option value = "registered">REGISTERED</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "unregistered">DROPPED</option>
						<option value = "all">ALL</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "notregistered")
					{
						?>
						<option value = "notregistered" selected = "selected">NOT REGISTERED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "registered">REGISTERED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "unregistered">DROPPED</option>
						<option value = "all">ALL</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "incomplete")
					{
						?>
						<option value = "incomplete" selected = "selected">INCOMPLETE</option>
						<option value = "completed">COMPLETED</option>
						<option value = "registered">REGISTERED</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<option value = "unregistered">DROPPED</option>
						<option value = "all">ALL</option>
						<?php
					}
					
					?>
					</select>
					
					<br/>
					<br/>
					<input class="button2 p5 width90" type = "submit" name = "submit" value = "Submit" />
					
					<br/>
					<br/>
		<?php
		
			echo "<br/><br/>TOTAL STENTS REGISTERED: " . getCreditsRegistered();
			echo "<br/><br/>TOTAL STENTS COMPLETED: " . getCreditsCompleted();
			
			
			
		
			//user_data($session_No, 'No', 'Programmes', 'password',  'Date', 'Year', 'email', 'active', 'role', 'Credits', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');
			if($_SESSION['search'] == "")
			{
				$sql = mysql_query("SELECT * FROM seru_courses WHERE Date != 'DELETED' ORDER BY Year DESC;");
			}
			else
			{
				$searchString = str_replace ("'", "\'", $_SESSION['search']);
				
				$sql = mysql_query("SELECT * FROM seru_courses WHERE Date != 'DELETED' AND (Programmes LIKE '%" . 
									$searchString . "%' OR Date LIKE '%" . $searchString . "%' OR Year LIKE '%" . 
									$searchString . "%' OR Credits LIKE '%" . 
									$searchString . "%' OR Cost LIKE '%" . $searchString . "%') ORDER BY Year DESC;");
			}

			try
			{
				?>
					<table class="ep_tm_main"><tr><td align="left">
					<h1 class="ep_tm_pagetitle"><?php echo "PATIENT STENTS";?> </h1>

	
				<table id="register_student_table" class="display nowrap table table-striped" style="width: 100%">
					<thead>
					<tr>
						<td><strong>No</strong></td> 
						<td><strong>Program:</strong></td> 
						<td><strong>Duration:</strong></td> 
						<td><strong>Time:</strong></td>
						<td><strong>Year:</strong></td>
						<td><strong>Merit Points:</strong></td>
						<td><strong>Program ID:</strong></td>	
						<td><strong>Sub-Program With:</strong></td>				
						<td><strong>Cost:</strong></td>					
						<td><strong>Paid:</strong></td>					
						<td><strong>Registration Status:</strong></td>	
						<td><strong></strong></td>					
					</tr>
					</thead>	
					<?php
					
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
					//$row_Val = $row["symptoms"];
					//$row_Val2 = $row["diagnose"];
					//$_SESSION['cfglobal'] = $row["CF"];
					$dateWithinFiveDays = false;
					
					$row_Val = $row["Programmes"];
					
					$No = $row["No"];
					$Programmes = $row["Programmes"];
					$Date = $row["Date"];
					$Year = $row["Year"];
					$active = $row["active"];
					$Credits = $row["Credits"];
					$Cost = $row["Cost"];	
					$Number_Of_Students = $row["Number_Of_Students"];
					$Time = $row["Time"];
					$JoinedWith = $row["JoinedWith"];
					$registered = "notregistered";
					$student_id = -100;
					
					$sql_mini = mysql_query("SELECT * FROM students WHERE user_id = '" . $user_data['user_id'] . "' AND courses = '" . $No . "';");
					
					
					try
					{
						if(!empty($sql_mini))
						{	
							while($rowB = mysql_fetch_assoc($sql_mini))
							{
								$student_id = $rowB["student_id"];
								$registered = $rowB["registered"];				
								$Paid = $rowB["Paid"];
							}//end while($row = mysql_fetch_assoc($sql_mini))
						}//end if(!empty($sql_mini))
					}
					catch( PDOException $e)
					{
						echo "Query failed:".$e->getMessage();
					}
					
					
					
					if(($_SESSION['currentYear'] <= $Year || $registered != "notregistered") && ($_SESSION['registered_status'] == "all" || $_SESSION['registered_status'] == $registered))
					{
					
					$_SESSION["registeredOri" . $my_little_counter] = $registered;
					$_SESSION["student_id" . $my_little_counter] = $student_id;
			/*
			echo "<br/>TEST LAST = " . $Date . "=   ";
			echo "<br/>TEST LAST = " . $Year . "=   ";
			echo "<br/>TEST LAST = " . $registered . "=   ";
			echo "<br/>TEST LAST = " . $Credits . "=   ";
			/**/
					
					
					$my_little_counter_disp = $my_little_counter + 1;
										
					$count_ = $my_little_counter_disp;
					
					
											if(($count_ % 2) == 1)
											{
												$color = "#e6e6fa";
											}
											else
											{
												$color = "#ffffff";
											}
											
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $my_little_counter_disp .  "</td>\r\n";
					
					$_SESSION["No" . $my_little_counter] = $No;
										
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Programmes .  "</td>\r\n";
					
					$_SESSION["Programmes" . $my_little_counter] = $Programmes;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Date .  "</td>\r\n";
					
					$_SESSION["Date" . $my_little_counter] = $Date;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Time .  "</td>\r\n";
					
					$_SESSION["Time" . $my_little_counter] = $Time;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Year .  "</td>\r\n";
					
					$_SESSION["Year" . $my_little_counter] = $Year;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Credits .  "</td>\r\n";
					
					$_SESSION["Credits" . $my_little_counter] = $Credits;
					
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $No .  "</td>\r\n";
					
					$JoinedMessage = "NONE";
					
					if($JoinedWith > 0)
					{
						$JoinedMessage = "Program Number: " . $JoinedWith;
					}
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $JoinedMessage .  "</td>\r\n";
					
					$_SESSION["JoinedWith" . $my_little_counter] = $JoinedWith;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Cost .  "</td>\r\n";
					
					$_SESSION["Cost" . $my_little_counter] = $Cost;
					
					$PaidSTring = "";
					
					if($Paid == 1)
					{
						$PaidSTring =  "Paid";
					}
					else
					{
						$PaidSTring =  "Not Paid";
					}
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $PaidSTring .  "</td>\r\n";
					
					
						$dateWithinFiveDays = checkDateClosing($my_little_counter, 4);
						 //echo "<br/>" . checkDateClosing($my_little_counter);
						 
						 
						$dateClashes = false;
						$dateClashText = "";
						
						 
						 if($registered == "notregistered")
						 {						
							$dateClashes = checkDateClosing($my_little_counter, 0);
							
							if($dateClashes == false)
							{
								//echo "<br/> Checking Date Clash...";
								$dateClashes = getDateClash($user_data['user_id']);
								//echo "<br/> dateClashes =" . $dateClashes;
								
								if($dateClashes == true)
								{
									//$dateClashes = getTIMEClash($user_data['user_id']);
									//if($dateClashes == true)
									//{
									$dateClashText = "; Stent Timing Clashes With Stent Already Registered";
									//}
								}
								else
								{
									$dateClashes = isMaxUsers($No, $Number_Of_Students);
									
									if($dateClashes == true)
									{
										$dateClashText = "; Stent Fully Subscribed";
									}
								}
							}
							else
							{
								$dateClashText = "; Cannot Register once Stent Over";
							}
						 }//end if($registered == "notregistered")
					?>
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<!Multi Select!>
					<select name = "<?php echo "registered" . $my_little_counter;?>" id = "<?php echo "registered" . $my_little_counter;?>" size = "5" multiple = "multiple">
					<?php
					if($registered == "notregistered")
					{
						?>
						<option value = "notregistered" selected = "selected">NOT REGISTERED<?php echo "" . $dateClashText;?></option>
						<?php
						if($_SESSION['currentYear'] <= $Year && $dateClashes == false)
						{
						?>
							<option value = "registered">Register</option>
						<?php
						}//end if($_SESSION['currentYear'] <= $Year)
					}
					else if($registered == "registered")
					{
						?>
						<option value = "registered" selected = "selected">REGISTERED<?php
																						if($dateWithinFiveDays == true)
																						{
																							echo " (cannot unregister 5 days before program starts)";
																						}?></option>
						<?php
						if($_SESSION['currentYear'] <= $Year && $dateWithinFiveDays == false)
						{
						?>
							<option value = "unregistered">Un-Register (once stent dropped, cannot re-register)</option>
						<?php
						}//end if($_SESSION['currentYear'] <= $Year)
					}
					else if($registered == "unregistered")
					{
						?>
						<option value = "unregistered" selected = "selected">DROPPED</option>
						<?php
					}
					else if($registered == "completed")
					{
						?>
						<option value = "completed" selected = "selected">COMPLETED</option>
						<?php
					}
					else if($registered == "incomplete")
					{
						?>
						<option value = "incomplete" selected = "selected">INCOMPLETE</option>
						<?php
					}
					
					?>
					</select>
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input class="button2 p5 width90" type = "submit" name = "submit" value = "Submit" />
					</td><?php echo "\r\n"; ?>
					
					
					<?php
										
					
					//echo "User ".$row_Val . "<br/>";
					$my_little_counter++;
					$_SESSION['counterMax'] = $my_little_counter;
					
					echo "</tr>\r\n";
					}//end if(($_SESSION['currentYear'] <= $Year || $registered != "notregistered") && ($_SESSION['registered_status'] == "all" || $_SESSION['registered_status'] == $registered))
				}//end while($row = mysql_fetch_assoc($sql))
				}
				else
				{
					echo "EMPTY...";
				}
				
				?>
				
				</table>
				</td></tr></table>
				
				<?php
				
				//echo "<br/><br/>" . $_SESSION['errorcheck'];
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
   }//end function accessRulesDisp()
   
   
   function isMaxUsers($No, $Number_Of_Students)
   {
		$maxedOut = false;
		
		$currentCount = 0;
		
		$sql_micro = mysql_query("SELECT * FROM students WHERE courses = '" . $No . "' AND registered NOT LIKE 'notregistered' AND registered NOT LIKE 'unregistered';");
					
								try
								{
									if(!empty($sql_micro))
									{	
										while($rowMicro = mysql_fetch_assoc($sql_micro))
										{
											$miniCourseDate = $rowMicro["user_id"];
											
											//echo "<br/> miniCourseDate =" . $miniCourseDate;
											$currentCount++;
											
											if($currentCount >= $Number_Of_Students)
											{
												$maxedOut = true;
											}
											
										}//end while($row = mysql_fetch_assoc($sql_micro))
									}//end if(!empty($sql_micro))
								}
								catch( PDOException $e)
								{
									echo "Query failed:".$e->getMessage();
								}
		return $maxedOut;
   }//end function isMaxUsers($No)
   
   
   function getDateClash($user_id)
   {		
		global $Year;
						$dateClashesB = false;
						$miniQuery = "";
						$miniCourseNum = -1;
						$miniCourseDate = "";
						
						
						$sql_mini = mysql_query("SELECT * FROM students WHERE user_id = '" . $user_id . "' AND registered = 'registered';");
					
					try
					{
						if(!empty($sql_mini))
						{	
							while($rowB = mysql_fetch_assoc($sql_mini))
							{
								$miniCourseNum = intval($rowB["courses"]);
								//echo "<br/>Course Num =" . $miniCourseNum . "=";
								
								$sql_micro = mysql_query("SELECT * FROM seru_courses WHERE No = '" . $miniCourseNum . "';");
					
								try
								{
									if(!empty($sql_micro))
									{	
										while($rowMicro = mysql_fetch_assoc($sql_micro))
										{
											$miniCourseDate = $rowMicro["Date"];
											
											//echo "<br/> miniCourseDate =" . $miniCourseDate;
											
											if($miniCourseDate == "" || $miniCourseDate == null)
											{
											}
											else
											{
												if($dateClashesB == false)
												{
													$dateClashesB = checkDateClash(0, $miniCourseDate);
													//echo "<br/> dateClashesB=" . $dateClashesB . "=";
													
													if($dateClashesB == true)
													{
														$miniCourseDate = $rowMicro["Time"];
														
														if($miniCourseDate == "" || $miniCourseDate == null)
														{
														}
														else
														{
															$dateClashesB = checkTIMEClash(0, $miniCourseDate);
														}
													}
												}
											}
										}//end while($row = mysql_fetch_assoc($sql_micro))
									}//end if(!empty($sql_micro))
								}
								catch( PDOException $e)
								{
									echo "Query failed:".$e->getMessage();
								}
								
							}//end while($row = mysql_fetch_assoc($sql_mini))
						}//end if(!empty($sql_mini))
					}
					catch( PDOException $e)
					{
						echo "Query failed:".$e->getMessage();
					}
					
		return $dateClashesB;
   }//end function getDateClash()
   
   
   
   function checkTIMEClash($my_little_counter, $miniCourseDate)
   {
		global $Time;
		global $Year;
		
		
		
		$dateWithinFiveDays = false;
		$extractYear = 5000;
		$extractMonth = 14;
		$extractDate = 2400;
		$extractDate2 = 2400;
		$extractMonthSet = false;
		$extractDateSet = false;
		
		
		$extractYearB = 5000;
		$extractMonthB = 14;
		$extractDateB = 2400;
		$extractDateB2 = 2400;
		$extractMonthBSet = false;
		$extractDateBSet = false;
		
		$CheckString = "";
		
		
		$TimeDifference = 0;
		
		//echo "<br/>START TIME DATE";
		
		if($miniCourseDate != null)
		{
		$dateComponents = explode(" ", strToLower($miniCourseDate));
		
		$miniDate = "";
		
		
		for($i = 0; $i < count($dateComponents); $i++)
		{		
			$miniDate = "" . $dateComponents[$i];
			if(strpos("x".$miniDate,'-') == true && $i < 1)
			{
				$dateComponentsB = explode("-", $miniDate);
				
						//echo "<br/>A MINI DATE..." . $miniDate . "=";
						
				$miniDate = $dateComponentsB[0];
				
				
				if(is_numeric($miniDate) == true)
				{
					if(intval($miniDate) < 2401)
					{
						$extractDateB = intval($miniDate);
						$extractDateB2 = $extractDateB;
						$extractDateBSet = true;
						
						$CheckString = $CheckString . "<br/>FIRST ExtractDateB=" . $extractDateB2;
						//echo "<br/>A EXTRACTING DATE..." . $miniDate . "=" . $extractDate;
					}
					if(count($dateComponentsB) > 0)
					{
						$extractDateB2 = $extractDateB;
						
						$miniDate = $dateComponentsB[1];
						
						if(intval($miniDate) < 2401)
						{
							$extractDateB2 = intval($miniDate);
						}
						if(intval($miniDate) < 2401 && intval($miniDate) >= $extractDateB)
						{
							$TimeDifference = intval($miniDate) - $extractDateB;
						}
						
							$CheckString = $CheckString . "<br/>SECOND ExtractDateB2=" . $extractDateB2;
						//echo "<br/>A REMAINING DATE..." . $miniDate . "=" . $extractDate2;
					}
				}
			}//end if(strpos("x".$miniDate,'-') == true && $i < 1)
			
			
			//echo "<br/> MOVE HERE =" . $miniDate;
			
			if(is_numeric($miniDate) == true && strlen("" . $miniDate) > 3)
			{
				//echo "<br/> ENTERED YEAR...";
				
				$extractYearB = intval($miniDate);
				
				if($i == 1)
				{
					$extractDateB = 2400;
					
					if($extractMonthBSet == false)
					{
						if(intval($dateComponents[0]) < 13)
						{
							$extractMonthB = intval($dateComponents[0]);
							$extractMonthBSet = true;
						}
					}//end if($extractMonthBSet == false)
				}//end if($i == 1)
			}//end if(srtlen($miniDate) > 3 && is_numeric($miniDate))
			else if(is_numeric($miniDate) == true && strlen("" . $miniDate) < 3 && $extractDateBSet == false)
			{
				if(intval($miniDate) < 2401)
				{
					$extractDateB = intval($miniDate);
					$extractDateB2 = $extractDateB;
					$extractDateBSet = true;
				}
			}
			else
			{
				//echo "<br/>CONDITION NOT...";
			}
			
			
			
			if(strpos("X" . $miniDate, "jan"))
			{
				$extractMonthB = 1;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "feb"))
			{
				$extractMonthB = 2;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "mar") || strpos("X" . $miniDate, "mac"))
			{
				$extractMonthB = 3;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "apr"))
			{
				$extractMonthB = 4;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "may") || strpos("X" . $miniDate, "mei"))
			{
				$extractMonthB = 5;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "jun"))
			{
				$extractMonthB = 6;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "jul"))
			{
				$extractMonthB = 7;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "aug") || strpos("X" . $miniDate, "ogo"))
			{
				$extractMonthB = 8;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "sep"))
			{
				$extractMonthB = 9;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "oct") || strpos("X" . $miniDate, "okt"))
			{
				$extractMonthB = 10;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "nov"))
			{
				$extractMonthB = 11;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "dec") || strpos("X" . $miniDate, "dis"))
			{
				$extractMonthB = 12;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "pm"))
			{
				$extractMonthB = 13;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "am"))
			{
				$extractMonthB = 14;
				$extractMonthBSet = true;
			}
			
			//echo "<br/>MONTH =" . $extractMonthB;
		}//end for($i = 0; $i < count($dateComponents); $i++)
		}//end if($miniCourseDate != null)
		
		
		if($Time != null)
		{
		$dateComponents = explode(" ", strToLower($Time));
		
		$miniDate = "";
		
		for($i = 0; $i < count($dateComponents); $i++)
		{		
			$miniDate = "" . $dateComponents[$i];
			if(strpos("x".$miniDate,'-') == true && $i < 1)
			{
				$dateComponentsB = explode("-", $miniDate);
				
						//echo "<br/>B MINI DATE..." . $miniDate . "=";
						
				$miniDate = $dateComponentsB[0];
				
				
				if(is_numeric($miniDate) == true)
				{
					if(intval($miniDate) < 2401)
					{
						$extractDate = intval($miniDate);
						$extractDateSet = true;
						$extractDate2 = $extractDate;
												
						$CheckString = $CheckString . "<br/>FIRST ExtractDate=" . $extractDate;
						//echo "<br/>B EXTRACTING DATE..." . $miniDate . "=" . $extractDate;
					}
					if(count($dateComponentsB) > 0)
					{
						$extractDate2 = $extractDate;
						
						$miniDate = $dateComponentsB[1];
						
						if(intval($miniDate) < 2401)
						{
							$extractDate2 = intval($miniDate);
						}
						if(intval($miniDate) < 2401 && intval($miniDate) > $extractDate)
						{
							$TimeDifference = intval($miniDate) - $extractDate;
						}
						
						$CheckString = $CheckString . "<br/>SECOND ExtractDate=" . $extractDate2;
						//echo "<br/>B REMAINING DATE..." . $miniDate . "=" . $extractDateB2;
					}
				}
			}//end if(strpos("x".$miniDate,'-') == true && $i < 1)
			
			
			//echo "<br/> MOVE HERE =" . $miniDate;
			
			if(is_numeric($miniDate) == true && strlen("" . $miniDate) > 3)
			{
				//echo "<br/> ENTERED YEAR...";
				
				$extractYear = intval($miniDate);
				
				if($i == 1)
				{
					$extractDate = 2400;
					
					if($extractMonthSet == false)
					{
						if(intval($dateComponents[0]) < 13)
						{
							$extractMonth = intval($dateComponents[0]);
							$extractMonthSet = true;
						}
					}//end if($extractMonthSet == false)
				}//end if($i == 1)
			}//end if(srtlen($miniDate) > 3 && is_numeric($miniDate))
			else if(is_numeric($miniDate) == true && strlen("" . $miniDate) < 3 && $extractDateSet == false)
			{
				if(intval($miniDate) < 2401)
				{
					$extractDate = intval($miniDate);
					$extractDate2 = $extractDate;
					$extractDateSet = true;
				}
			}
			else
			{
				//echo "<br/>CONDITION NOT...";
			}
			
			
			
			if(strpos("X" . $miniDate, "jan"))
			{
				$extractMonth = 1;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "feb"))
			{
				$extractMonth = 2;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "mar") || strpos("X" . $miniDate, "mac"))
			{
				$extractMonth = 3;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "apr"))
			{
				$extractMonth = 4;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "may") || strpos("X" . $miniDate, "mei"))
			{
				$extractMonth = 5;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "jun"))
			{
				$extractMonth = 6;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "jul"))
			{
				$extractMonth = 7;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "aug") || strpos("X" . $miniDate, "ogo"))
			{
				$extractMonth = 8;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "sep"))
			{
				$extractMonth = 9;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "oct") || strpos("X" . $miniDate, "okt"))
			{
				$extractMonth = 10;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "nov"))
			{
				$extractMonth = 11;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "dec") || strpos("X" . $miniDate, "dis"))
			{
				$extractMonth = 12;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "pm"))
			{
				$extractMonth = 13;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "am"))
			{
				$extractMonth = 14;
				$extractMonthSet = true;
			}
			
			//echo "<br/>MONTH =" . $extractMonth;
		}//end for($i = 0; $i < count($dateComponents); $i++)
		}//end if($Time != null)
		
		$extractYear = $Year;
		$extractYearB = $Year;
		
		$dateWithinFiveDays = false;
		
		$testDate = $extractDateB + $TimeDifference;
		$testDateB = $extractDateB - $TimeDifference;
		
		
		$testDate = $extractDateB;
		$testDateB = $extractDateB;
		
		//if($extractYearB == $extractYear && $extractMonthB == $extractMonth && ($testDate >= $extractDate && $testDateB <= $extractDate))
		if($extractYearB == $extractYear && $extractMonthB == $extractMonth && 
			(($extractDateB <= $extractDate && $extractDateB2 >= $extractDate) || ($extractDateB <= $extractDate2 && $extractDateB2 >= $extractDate2) ||
			($extractDate <= $extractDateB && $extractDate2 >= $extractDateB) || ($extractDate <= $extractDateB2 && $extractDate2 >= $extractDateB2)))
		{
			$dateWithinFiveDays = true;
			$_SESSION['errorcheck'] = $_SESSION['errorcheck'] . "<br/>" . $miniCourseDate . " and " . $Time . "" . $CheckString . " TRUE:" . $extractDate . "-" . $extractDate2 . " and " . $extractDateB . "-" . $extractDateB2;
		}
		else
		{
			$dateWithinFiveDays = false;
			//echo "<br/>" . $miniCourseDate . " and " . $Time . "" . $CheckString . " FALSE:" . $extractDate . "-" . $extractDate2 . " and " . $extractDateB . "-" . $extractDateB2;
		}
		
		//echo "<br/>END CHECK DATE, YEAR =" . $extractYear . ", MONTH =" . $extractMonth . ", DATE =" . $extractDate;
		//echo "<br/>END CHECK DATE, YEAR =" . $extractYearB . ", MONTH =" . $extractMonthB . ", DATE =" . $extractDateB;
		//echo "<br/> Date Within Five Days =" . $dateWithinFiveDays;
		
		return $dateWithinFiveDays;
   }//end function checkTIMEClash($my_little_counter, $miniCourseDate)
   
   
   function checkDateClash($my_little_counter, $miniCourseDate)
   {
		global $Date;
		global $Year;
		
		global $testMessages;
		
		$dateWithinFiveDays = false;
		$extractYear = 5000;
		$extractMonth = 12;
		$extractDate = 31;
		$extractDate2 = 31;
		$extractMonthSet = false;
		$extractDateSet = false;
		
		
		$extractYearB = 5000;
		$extractMonthB = 12;
		$extractDateB = 31;
		$extractDateB2 = 31;
		$extractMonthBSet = false;
		$extractDateBSet = false;
		
		$CheckString = "";
		
		
		$DateDifference = 0;
		
		//echo "<br/>START CHECK DATE";
		
		if($miniCourseDate != null)
		{
		$dateComponents = explode(" ", strToLower($miniCourseDate));
		
		$miniDate = "";
		
		
		for($i = 0; $i < count($dateComponents); $i++)
		{		
			$miniDate = "" . $dateComponents[$i];
			if(strpos("x".$miniDate,'-') == true && $i < 1)
			{
				$dateComponentsB = explode("-", $miniDate);
				
						//echo "<br/>A MINI DATE..." . $miniDate . "=";
						
				$miniDate = $dateComponentsB[0];
				
				
				if(is_numeric($miniDate) == true)
				{
					if(intval($miniDate) < 32)
					{
						$extractDateB = intval($miniDate);
						$extractDateB2 = $extractDateB;
						$extractDateBSet = true;
						
						$CheckString = $CheckString . "<br/>FIRST ExtractDateB=" . $extractDateB2;
						//echo "<br/>A EXTRACTING DATE..." . $miniDate . "=" . $extractDate;
					}
					if(count($dateComponentsB) > 0)
					{
						$extractDateB2 = $extractDateB;
						
						$miniDate = $dateComponentsB[1];
						
						if(intval($miniDate) < 32)
						{
							$extractDateB2 = intval($miniDate);
						}
						if(intval($miniDate) < 32 && intval($miniDate) >= $extractDateB)
						{
							$DateDifference = intval($miniDate) - $extractDateB;
						}
						
							$CheckString = $CheckString . "<br/>SECOND ExtractDateB2=" . $extractDateB2;
						//echo "<br/>A REMAINING DATE..." . $miniDate . "=" . $extractDate2;
					}
				}
			}//end if(strpos("x".$miniDate,'-') == true && $i < 1)
			
			
			//echo "<br/> MOVE HERE =" . $miniDate;
			
			if(is_numeric($miniDate) == true && strlen("" . $miniDate) > 3)
			{
				//echo "<br/> ENTERED YEAR...";
				
				$extractYearB = intval($miniDate);
				
				if($i == 1)
				{
					$extractDateB = 31;
					
					if($extractMonthBSet == false)
					{
						if(intval($dateComponents[0]) < 13)
						{
							$extractMonthB = intval($dateComponents[0]);
							$extractMonthBSet = true;
						}
					}//end if($extractMonthBSet == false)
				}//end if($i == 1)
			}//end if(srtlen($miniDate) > 3 && is_numeric($miniDate))
			else if(is_numeric($miniDate) == true && strlen("" . $miniDate) < 3 && $extractDateBSet == false)
			{
				if(intval($miniDate) < 32)
				{
					$extractDateB = intval($miniDate);
					$extractDateB2 = $extractDateB;
					$extractDateBSet = true;
				}
			}
			else
			{
				//echo "<br/>CONDITION NOT...";
			}
			
			
			
			if(strpos("X" . $miniDate, "jan"))
			{
				$extractMonthB = 1;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "feb"))
			{
				$extractMonthB = 2;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "mar") || strpos("X" . $miniDate, "mac"))
			{
				$extractMonthB = 3;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "apr"))
			{
				$extractMonthB = 4;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "may") || strpos("X" . $miniDate, "mei"))
			{
				$extractMonthB = 5;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "jun"))
			{
				$extractMonthB = 6;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "jul"))
			{
				$extractMonthB = 7;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "aug") || strpos("X" . $miniDate, "ogo"))
			{
				$extractMonthB = 8;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "sep"))
			{
				$extractMonthB = 9;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "oct") || strpos("X" . $miniDate, "okt"))
			{
				$extractMonthB = 10;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "nov"))
			{
				$extractMonthB = 11;
				$extractMonthBSet = true;
			}
			else if(strpos("X" . $miniDate, "dec") || strpos("X" . $miniDate, "dis"))
			{
				$extractMonthB = 12;
				$extractMonthBSet = true;
			}
			
			//echo "<br/>MONTH =" . $extractMonthB;
		}//end for($i = 0; $i < count($dateComponents); $i++)
		}//end if($miniCourseDate != null)
		
		
		if($Date != null)
		{
		$dateComponents = explode(" ", strToLower($Date));
		
		$miniDate = "";
		
		for($i = 0; $i < count($dateComponents); $i++)
		{		
			$miniDate = "" . $dateComponents[$i];
			if(strpos("x".$miniDate,'-') == true && $i < 1)
			{
				$dateComponentsB = explode("-", $miniDate);
				
						//echo "<br/>B MINI DATE..." . $miniDate . "=";
						
				$miniDate = $dateComponentsB[0];
				
				
				if(is_numeric($miniDate) == true)
				{
					if(intval($miniDate) < 32)
					{
						$extractDate = intval($miniDate);
						$extractDateSet = true;
						$extractDate2 = $extractDate;
												
						$CheckString = $CheckString . "<br/>FIRST ExtractDate=" . $extractDate;
						//echo "<br/>B EXTRACTING DATE..." . $miniDate . "=" . $extractDate;
					}
					if(count($dateComponentsB) > 0)
					{
						$extractDate2 = $extractDate;
						
						$miniDate = $dateComponentsB[1];
						
						if(intval($miniDate) < 32)
						{
							$extractDate2 = intval($miniDate);
						}
						if(intval($miniDate) < 32 && intval($miniDate) > $extractDate)
						{
							$DateDifference = intval($miniDate) - $extractDate;
						}
						
						$CheckString = $CheckString . "<br/>SECOND ExtractDate=" . $extractDate2;
						//echo "<br/>B REMAINING DATE..." . $miniDate . "=" . $extractDateB2;
					}
				}
			}//end if(strpos("x".$miniDate,'-') == true && $i < 1)
			
			
			//echo "<br/> MOVE HERE =" . $miniDate;
			
			if(is_numeric($miniDate) == true && strlen("" . $miniDate) > 3)
			{
				//echo "<br/> ENTERED YEAR...";
				
				$extractYear = intval($miniDate);
				
				if($i == 1)
				{
					$extractDate = 31;
					
					if($extractMonthSet == false)
					{
						if(intval($dateComponents[0]) < 13)
						{
							$extractMonth = intval($dateComponents[0]);
							$extractMonthSet = true;
						}
					}//end if($extractMonthSet == false)
				}//end if($i == 1)
			}//end if(srtlen($miniDate) > 3 && is_numeric($miniDate))
			else if(is_numeric($miniDate) == true && strlen("" . $miniDate) < 3 && $extractDateSet == false)
			{
				if(intval($miniDate) < 32)
				{
					$extractDate = intval($miniDate);
					$extractDate2 = $extractDate;
					$extractDateSet = true;
				}
			}
			else
			{
				//echo "<br/>CONDITION NOT...";
			}
			
			
			
			if(strpos("X" . $miniDate, "jan"))
			{
				$extractMonth = 1;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "feb"))
			{
				$extractMonth = 2;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "mar") || strpos("X" . $miniDate, "mac"))
			{
				$extractMonth = 3;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "apr"))
			{
				$extractMonth = 4;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "may") || strpos("X" . $miniDate, "mei"))
			{
				$extractMonth = 5;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "jun"))
			{
				$extractMonth = 6;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "jul"))
			{
				$extractMonth = 7;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "aug") || strpos("X" . $miniDate, "ogo"))
			{
				$extractMonth = 8;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "sep"))
			{
				$extractMonth = 9;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "oct") || strpos("X" . $miniDate, "okt"))
			{
				$extractMonth = 10;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "nov"))
			{
				$extractMonth = 11;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "dec") || strpos("X" . $miniDate, "dis"))
			{
				$extractMonth = 12;
				$extractMonthSet = true;
			}
			
			//echo "<br/>MONTH =" . $extractMonth;
		}//end for($i = 0; $i < count($dateComponents); $i++)
		}//end if($Date != null)
		
		$extractYear = $Year;
		$extractYearB = $Year;
		
		$dateWithinFiveDays = false;
		
		$testDate = $extractDateB + $DateDifference;
		$testDateB = $extractDateB - $DateDifference;
		
		
		$testDate = $extractDateB;
		$testDateB = $extractDateB;
		
		//if($extractYearB == $extractYear && $extractMonthB == $extractMonth && ($testDate >= $extractDate && $testDateB <= $extractDate))
		if($extractYearB == $extractYear && $extractMonthB == $extractMonth && 
			(($extractDateB <= $extractDate && $extractDateB2 >= $extractDate) || ($extractDateB <= $extractDate2 && $extractDateB2 >= $extractDate2) ||
			($extractDate <= $extractDateB && $extractDate2 >= $extractDateB) || ($extractDate <= $extractDateB2 && $extractDate2 >= $extractDateB2)))
		{
			$dateWithinFiveDays = true;
			$_SESSION['errorcheck'] = $_SESSION['errorcheck'] . "<br/>" . $miniCourseDate . " and " . $Date . "" . $CheckString . " TRUE:" . $extractDate . "-" . $extractDate2 . " and " . $extractDateB . "-" . $extractDateB2;
		}
		else
		{
			$dateWithinFiveDays = false;
			//echo "<br/>FALSE";
		}
		
		//$testMessages = "<br/>END CHECK DATE, YEAR =" . $extractYear . ", MONTH =" . $extractMonth . ", DATE =" . $extractDate . 
		//					"<br/>END CHECK DATE, YEAR =" . $extractYearB . ", MONTH =" . $extractMonthB . ", DATE =" . $extractDateB;
		//echo "<br/>END CHECK DATE, YEAR =" . $extractYear . ", MONTH =" . $extractMonth . ", DATE =" . $extractDate;
		//echo "<br/>END CHECK DATE, YEAR =" . $extractYearB . ", MONTH =" . $extractMonthB . ", DATE =" . $extractDateB;
		//echo "<br/> Date Within Five Days =" . $dateWithinFiveDays;
		
		return $dateWithinFiveDays;
   }//end function checkDateClash($my_little_counter)
   
   
   
   function checkDateClosing($my_little_counter, $DateModifier)
   {
		global $Date;
		global $Year;
		
		$dateWithinFiveDays = false;
		$extractYear = 5000;
		$extractMonth = 12;
		$extractDate = 31;
		$extractMonthSet = false;
		$extractDateSet = false;
		
		//echo "START CHECK DATE";
		
		if($Date != null)
		{
		$dateComponents = explode(" ", strToLower($Date));
		
		$miniDate = "";
		
				//echo "<br/>MIni Date BIG =" . $Date . "<br/>";
		
		for($i = 0; $i < count($dateComponents); $i++)
		{		
			$miniDate = "" . $dateComponents[$i];
			if(strpos("x".$miniDate,'-') == true && $i < 1)
			{
				$dateComponentsB = explode("-", $miniDate);
				
				$miniDate = $dateComponentsB[0];
				
				if(is_numeric($miniDate) == true)
				{
					if(intval($miniDate) < 32)
					{
						$extractDate = intval($miniDate);
						$extractDateSet = true;
						//echo "<br/>EXTRACTING DATE..." . $extractDate;
					}
					if(count($dateComponentsB) > 0)
					{
						$miniDate = $dateComponentsB[1];
					}
				}
			}//end if(strpos("x".$miniDate,'-') == true && $i < 1)
			
			
			//echo "<br/> MOVE HERE =" . $miniDate;
			
			if(is_numeric($miniDate) == true && strlen("" . $miniDate) > 3)
			{
				//echo "<br/> ENTERED YEAR...";
				
				$extractYear = intval($miniDate);
				
				if($i == 1)
				{
					$extractDate = 31;
					
					if($extractMonthSet == false)
					{
						if(intval($dateComponents[0]) < 13)
						{
							$extractMonth = intval($dateComponents[0]);
							$extractMonthSet = true;
						}
					}//end if($extractMonthSet == false)
				}//end if($i == 1)
			}//end if(srtlen($miniDate) > 3 && is_numeric($miniDate))
			else if(is_numeric($miniDate) == true && strlen("" . $miniDate) < 3 && $extractDateSet == false)
			{
				if(intval($miniDate) < 32)
				{
					$extractDate = intval($miniDate);
					//echo "<br/>MIni Date =" . $miniDate . "<br/>";
					$extractDateSet = true;
				}
			}
			else
			{
				//echo "<br/>CONDITION NOT...";
			}
			
			
			
			if(strpos("X" . $miniDate, "jan"))
			{
				$extractMonth = 1;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "feb"))
			{
				$extractMonth = 2;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "mar") || strpos("X" . $miniDate, "mac"))
			{
				$extractMonth = 3;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "apr"))
			{
				$extractMonth = 4;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "may") || strpos("X" . $miniDate, "mei"))
			{
				$extractMonth = 5;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "jun"))
			{
				$extractMonth = 6;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "jul"))
			{
				$extractMonth = 7;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "aug") || strpos("X" . $miniDate, "ogo"))
			{
				$extractMonth = 8;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "sep"))
			{
				$extractMonth = 9;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "oct") || strpos("X" . $miniDate, "okt"))
			{
				$extractMonth = 10;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "nov"))
			{
				$extractMonth = 11;
				$extractMonthSet = true;
			}
			else if(strpos("X" . $miniDate, "dec") || strpos("X" . $miniDate, "dis"))
			{
				$extractMonth = 12;
				$extractMonthSet = true;
			}
			
			//echo "<br/>MONTH =" . $extractMonth;
		}//end for($i = 0; $i < count($dateComponents); $i++)
		}//end if($Date != null)
		
		$extractYear = $Year;
		
		$dateWithinFiveDays = false;
		
		$testDate = $_SESSION['currentDate'] + $DateModifier;
		
		//$_SESSION['currentMonth'] = 9;//FOR TESTING!!!
		
		if($_SESSION['currentYear'] > $extractYear)
		{
			$dateWithinFiveDays = true;
			//echo "<br/>TRUE";
		}
		else if($_SESSION['currentMonth'] > $extractMonth)
		{
			$dateWithinFiveDays = true;
			//echo "<br/>TRUE";
		}
		else if($_SESSION['currentYear'] <= $extractYear && $_SESSION['currentMonth'] < $extractMonth && $testDate >= $extractDate)
		{
			$dateWithinFiveDays = false;
			//echo "<br/>FALSE testDate = " . $testDate . "  extractDate = " . $extractDate;
		}
		else if($_SESSION['currentYear'] == $extractYear && $_SESSION['currentMonth'] == $extractMonth && $testDate >= $extractDate)
		{
			$dateWithinFiveDays = true;
			//echo "<br/>TRUE testDate = " . $testDate . "  extractDate = " . $extractDate;
		}
		/*
		if($_SESSION['currentYear'] >= $extractYear && $_SESSION['currentMonth'] >= $extractMonth && $testDate >= $extractDate)
		{
			$dateWithinFiveDays = true;
			//echo "<br/>TRUE";
		}
		else
		{
			$dateWithinFiveDays = false;
			//echo "<br/>FALSE";
		}
		/**/
		//echo "<br/>END CHECK DATE, YEAR =" . $extractYear . ", MONTH =" . $extractMonth . ", DATE =" . $extractDate;
		//echo "<br/>END CHECK DATE CURRENT, YEAR =" . $_SESSION['currentYear'] . ", MONTH =" . $_SESSION['currentMonth'] . ", DATE =" . $_SESSION['currentDate'] . "<br/>";
		//echo "<br/> Date Within Five Days =" . $dateWithinFiveDays;
		
		return $dateWithinFiveDays;
   }//end function checkDateClosing($my_little_counter)
   
   
   function updateUsers($my_little_counter)
   {		
		global $No;
		global $Programmes;
		global $Date;
		global $Year;
		global $registered;
		global $Credits;
		global $student_id;
		global $Cost;
		global $JoinedWith;
		
		$hereUser_ID = $_SESSION['user_id'];
		
		$theQueryToExecute = "";
		
 
			
			$No = $_SESSION["No" . $my_little_counter];
			$Programmes = $_SESSION["Programmes" . $my_little_counter];
			$Date = $_SESSION["Date". $my_little_counter];
			$Year = $_SESSION["Year". $my_little_counter];
			$Credits = $_SESSION["Credits". $my_little_counter];
			$Cost = $_SESSION["Cost". $my_little_counter];
			$registered = $_POST["registered". $my_little_counter];
			$student_id = $_SESSION["student_id" . $my_little_counter];
			$JoinedWith = $_SESSION["JoinedWith" . $my_little_counter];
			/*
			echo "<br/>LAST Programmes= " . $Programmes . "=   ";
			echo "<br/>LAST No= " . $No . "=   ";
			echo "<br/>LAST Date= " . $Date . "=   ";
			echo "<br/>LAST Year= " . $Year . "=   ";
			echo "<br/>LAST registered= " . $registered . "=   ";
			echo "<br/>LAST Credits= " . $Credits . "=   ";
			/**/
 
			if($Programmes == "")
			{
				echo "<br/>Programmes cannot be NULL";
			}
			else if($Date == "")
			{
				echo "<br/>Date cannot be NULL";
			}
			else if($Year == "")
			{
				echo "<br/>Year cannot be NULL";
			}
			else if($Credits == "")
			{
				echo "<br/>credits cannot be NULL";
			}
			else if($registered == "")
			{
				echo "<br/>registered cannot be NULL";
			}
			else
			{
				if($student_id == -100)
				{
					$student_id = getMaxStudentID() + 1;
					$theQueryToExecute = "INSERT INTO `seru_students`.`students`".
										" (`student_id`, `user_id`, `courses`, ".
										"`registered`, `credits`) ".
										"VALUES ('" . $student_id . "', '" . $hereUser_ID . "', '" . $No . "', ".
										"'" . $registered . "', '" . $Credits . "');";
					
					//echo "<br/>" . $theQueryToExecute;
										
					$sql = mysql_query($theQueryToExecute);
										
					if($sql == null)
					{
						echo "<br/><br/>";
						?>
						<h1><font color="red">could not add stent</font></h1>
						<?php
					}
					else
					{
						echo "<br/>";
						?>
						<h1><font color="red"><b>NEW STENT ADDED</b></font></h1>
						<?php
					}
				}//end if($student_id == -100)
				else
				{	
					$theQueryToExecute = "UPDATE students SET registered = '". $registered .
																"', credits = '". $Credits .
																"' WHERE student_id = '" . $student_id . 
																"' AND user_id = '" . $hereUser_ID . 
																"' AND courses = '" . $No . "';";
					//echo "<br/>" . $theQueryToExecute;
					
					
					$sql = mysql_query($theQueryToExecute);
											
					if($sql == null)
					{
						echo "<br/><br/>";
						?>
						<h1><font color="red">could not update stent</font></h1>
						<?php
					}
					else
					{
						echo "<br/>";
						?>
						<h1><font color="red"><b>STENT UPDATED</b></font></h1>
						<?php
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
	
	function getMaxStudentID()
	{
			$finalcounter = 0;
			$maxID = 0;
			$sql = mysql_query("SELECT * FROM students");
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["student_id"];
						if($finalcounter > $maxID)
						{
							$maxID = $finalcounter;
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
			
			return $maxID;
	}//end function getMaxStudentID()
	
	
	function getCreditsRegistered()
	{
			$finalcounter = 0;
			$maxID = 0;
			$hereUser_ID = $_SESSION['user_id'];
			$sql = mysql_query("SELECT * FROM students WHERE user_id = '" . $hereUser_ID . "' AND registered = 'registered';");
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["credits"];
						$maxID = $maxID + $finalcounter;
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
			
			return $maxID;
	}//end function getCreditsRegistered()
	
	
	function getCreditsCompleted()
	{
			$finalcounter = 0;
			$maxID = 0;
			$hereUser_ID = $_SESSION['user_id'];
			$sql = mysql_query("SELECT * FROM students WHERE user_id = '" . $hereUser_ID . "' AND registered = 'completed';");
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["credits"];
						$maxID = $maxID + $finalcounter;
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
			
			return $maxID;
	}//end function getCreditsCompleted()
   
   
   
			mysql_close($dbconn) or die ("could not close database");
   
   ?>

   </body>
		<script>
			$(document).ready(function() {
    		$('#register_student_table').DataTable( {
        		"scrollX": true
    			} );
			} );
		</script>
</html>