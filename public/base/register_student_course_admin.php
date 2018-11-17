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

 if($user_data['role'] == 'student')
{
	header("location: register_student_course.php");
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
	
	
	
   
if( isset( $_POST['submit'] ))
{
	
	$_SESSION['nameOrMatric'] = $_POST['nameOrMatric'];
	
	$_SESSION['student_select'] = $_POST["student_select_choice"];
	
	$_SESSION['registered_status'] = $_POST["registered_status_choice"];
	
	$_SESSION['search'] = $_POST['search'];
	
	if($_SESSION['searchStudent'] != $_POST['searchStudent'])
	{
		$_SESSION['student_select'] = "all";
	}
	$_SESSION['searchStudent'] = $_POST['searchStudent'];
	
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
	$_SESSION['searchStudent'] = "";
	$_SESSION['search_user_id'] = "";
	$_SESSION['student_select'] = "all";
	$_SESSION['course_select'] = "all";
	
	
	$_SESSION['nameOrMatric'] = "name";
	
	$_SESSION['registered_status'] = "all";
	
	
	$_SESSION['userID_select'] = 1;
	
	$_SESSION['registered_status'] = "all";
	
$_SESSION['numglobalMax'] = 0;
	$_SESSION['cfglobal'] = 0;
	$_SESSION['cfglobalMax'] = 0;
	$_SESSION['ActualCFFinal'] = 0;
	$_SESSION['counter2'] = 1;
	$_SESSION['counterMax'] = 1;
	
	
	$_SESSION['student_id'] = 0;
	$_SESSION['user_id'] = $user_data['user_id'];
	$_SESSION['user_id_student'] = 0;
	
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
<form name ="formOne" method ="Post" action ="register_student_course_admin.php">
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
		
		$my_little_counter = 0;
		$my_little_counter_disp = 1;
		
		if(!isset($_SESSION['search']))
		{
			$_SESSION['search'] = "";
		}
 
		?>
		<h1> STENT REGISTRATION PAGE</h1>
		
		
					
					<label for="search">Search Patients</label>&nbsp;
					<input class="boxshadow" type="text" name="searchStudent" id="searchStudent" value="<?php echo "" . $_SESSION['searchStudent']; ?>" />
					
					<br/>
					<br/>
										
					
					<!Multi Select!>
					<label for="<?php echo "nameOrMatric"?>">Select By</label>&nbsp;
					<select class="boxshadow" name = "<?php echo "nameOrMatric";?>" id = "<?php echo "nameOrMatric";?>">
					<?php
					if($_SESSION['nameOrMatric'] == "first_name")
					{
						?>
						<option value = "first_name" selected = "selected">NAME</option>
						<option value = "Matric_Number">PATIENT ID</option>
						<?php
					}
					else 
					{
						?>
						<option value = "Matric_Number" selected = "selected">PATIENT ID</option>
						<option value = "first_name">NAME</option>
						<?php
					}
					?>
					</select>
					
					<br/>
					<br/>
				
					<!Multi Select!>
					<label for="<?php echo "student_select_choice"?>">Select Patient:</label>
					<select class="boxshadow" name = "<?php echo "student_select_choice";?>" id = "<?php echo "student_select_choice";?>">
					<?php
					
					
					$selectedAlready = false;
				
					if($_SESSION['searchStudent'] == "")
					{
						$sql_mini = mysql_query("SELECT * FROM users WHERE Role = 'student' ORDER BY " . $_SESSION['nameOrMatric'] . " ASC, last_name ASC;");
					}
					else
					{
						$sql_mini = mysql_query("SELECT * FROM users WHERE Role = 'student' AND (first_name LIKE '%" . $_SESSION['searchStudent'] . 
												"%' OR last_name LIKE '%" . $_SESSION['searchStudent'] . 
												"%' OR username LIKE '%" . $_SESSION['searchStudent'] . 
												"%' OR Matric_Number LIKE '%" . $_SESSION['searchStudent'] . 
												"%') ORDER BY " . $_SESSION['nameOrMatric'] . " ASC, last_name ASC;");
					}
					
					if(!empty($sql_mini))
					{	
						while($row = mysql_fetch_assoc($sql_mini))
						{
							if($_SESSION['nameOrMatric'] == "first_name")
							{
								$studentName = $row["first_name"];
								$studentName = $studentName . " " . $row["last_name"];
							}
							else
							{
								$studentName = $row["Matric_Number"];
							}
							
							
							if($_SESSION['student_select'] == $studentName && $selectedAlready == false)
							{
								$selectedAlready = true;
								$_SESSION['userID_select'] = $row["user_id"];
								?>
								<option value = "<?php echo "" . $studentName;?>" selected = "selected"><?php echo "" . $studentName;?></option>
								<?php
							}
							else
							{
								?>
								<option value = "<?php echo "" . $studentName;?>"><?php echo "" . $studentName;?></option>
								<?php
							}
						}//end while($row = mysql_fetch_assoc($sql_mini))
					}//end if(!empty($sql_mini))
					
					if($selectedAlready == false)
					{
								?>
								<option value = "all" selected = "selected">all</option>
								<?php
					}
					else
					{
								?>
								<option value = "all">all</option>
								<?php
					}
		
					?>
					</select>
					<br/>
					<br/>
					<label for="search">Search Stents</label>
					<input class="boxshadow" type="text" name="search" id="search" value="<?php echo "" . $_SESSION['search']; ?>" />
					<br/><br/>

					<!Multi Select!>
					<label for="<?php echo "registered_status_choice"?>">Select Registered Status</label>
					<select class="boxshadow" name = "<?php echo "registered_status_choice";?>" id = "<?php echo "registered_status_choice";?>" >
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
					
					<br/><br/>
					<input class="button2 width110 p5" type = "submit" name = "submit" value = "Submit" />
					
					<br/>
					<br/>
		<?php
		
			echo "<br/><br/>TOTAL STENTS REGISTERED: " . getCreditsRegistered();
			echo "<br/><br/>TOTAL STENTS COMPLETED: " . getCreditsCompleted();
			
			
			
		
			//user_data($session_No, 'No', 'Programmes', 'password',  'Date', 'Year', 'email', 'active', 'role', 'Credits', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');
			$temporaryString = "";
			
			if($_SESSION['student_select'] == "all")
			{
				$_SESSION['user_id_student'] = 0;
			}
			else
			{
				$_SESSION['user_id_student'] = $_SESSION['userID_select'];
				if($_SESSION['search'] == "")
				{
					$temporaryString = "SELECT * FROM seru_courses WHERE Date != 'DELETED' ORDER BY Year DESC;";
					
					$sql = mysql_query($temporaryString);
				}
				else
				{
					$searchString = str_replace ("'", "\'", $_SESSION['search']);
				
					$temporaryString = "SELECT * FROM seru_courses WHERE Date != 'DELETED' AND (Programmes LIKE '%" . 
									$searchString . "%' OR Date LIKE '%" . $searchString . "%' OR Year LIKE '%" . 
									$searchString . "%' OR Credits LIKE '%" . 
									$searchString . "%' OR Cost LIKE '%" . $searchString . "%') ORDER BY Year DESC;";
					$sql = mysql_query($temporaryString);
				}
				
				//echo "<br/>" . $temporaryString . "<br/>";
			}

			try
			{
				?>
					<table class="ep_tm_main"><tr><td align="left">
					<h1 class="ep_tm_pagetitle"><?php echo "PATIENT STENTS FOR " . /*$_SESSION['user_id_student'] . ": " .*/ $_SESSION['student_select'];?> </h1>

	
				<table id="patient_stents" class="display nowrap table table-striped" style="width: 100%">
					<thead>
					<tr>
						<td><strong>No</strong></td> 
						<td><strong>Program:</strong></td> 
						<td><strong>Duration:</strong></td> 
						<td><strong>Time:</strong></td>
						<td><strong>Year:</strong></td>
						<td><strong>Check Ups Confirmed:</strong></td>		
						<td><strong>Cost:</strong></td>					
						<td><strong>Paid:</strong></td>					
						<td><strong>Registration Status:</strong></td>	
						<td><strong></strong></td>					
					</tr>
					</thead>	
					<?php
					
				if(!empty($sql))
				{	
				//echo "WORKING....";
				while($row = mysql_fetch_assoc($sql))
				{			
				//echo "WORKING....";
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
					$registered = "notregistered";
					$student_id = -100;
					$Paid = 0;
					
					if($_SESSION['registered_status'] == "all")
					{
						$temporaryString = "SELECT * FROM students WHERE user_id = '" . $_SESSION['user_id_student'] . "' AND courses = '" . $No . "';";
					}
					else
					{
						$temporaryString = "SELECT * FROM students WHERE user_id = '" . $_SESSION['user_id_student'] . "' AND courses = '" . $No . "' AND registered = '" . $_SESSION['registered_status'] . "';";
					}
					$sql_mini = mysql_query($temporaryString);
					

					//echo "<br/>" . $temporaryString . "<br/>";					
					
					
					//echo "<br/>BEFORE:" . $student_id;
					
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
					
					//echo "<br/>AFTER:" . $student_id;
					
					
					
					//if(($_SESSION['currentYear'] <= $Year || $registered != "notregistered") && ($_SESSION['registered_status'] == "all" || $_SESSION['registered_status'] == $registered))
					//{
					if($_SESSION['registered_status'] == "all" ||  $registered == $_SESSION['registered_status'])
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
								$dateClashes = getDateClash($_SESSION['user_id_student']);
								//echo "<br/> dateClashes =" . $dateClashes;
								
								if($dateClashes == true)
								{
									$dateClashText = "; Stent Clashes With Stent Already Registered";
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
							
							$dateClashes = false;
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
						
							<option value = "registered">REGISTER</option>
						<?php
					}
					else if($registered == "registered")
					{
						?>
						<option value = "registered" selected = "selected">REGISTERED<?php
																						if($dateWithinFiveDays == true)
																						{
																							echo " (cannot unregister 5 days before program starts)";
																						}?></option>
						
							<option value = "unregistered">UN-REGISTER (once stent dropped, cannot re-register)</option>
						<?php
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
					//}//end if(($_SESSION['currentYear'] <= $Year || $registered != "notregistered") && ($_SESSION['registered_status'] == "all" || $_SESSION['registered_status'] == $registered))
				}//end if($_SESSION['registered_status'] == "all" ||  $registered == $_SESSION['registered_status'])
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
													//echo "<br/> dateClashesB=" . $dateClashesB . 
													
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
			//echo "<br/>" . $miniCourseDate . " and " . $Time . "" . $CheckString . " TRUE:" . $extractDate . "-" . $extractDate2 . " and " . $extractDateB . "-" . $extractDateB2;
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
			//echo "<br/>" . $miniCourseDate . " and " . $Date . "" . $CheckString . " TRUE:" . $extractDate . "-" . $extractDate2 . " and " . $extractDateB . "-" . $extractDateB2;
		}
		else
		{
			$dateWithinFiveDays = false;
			//echo "<br/>FALSE";
		}
		
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
		
		//echo "<br/>END CHECK DATE, YEAR =" . $extractYear . ", MONTH =" . $extractMonth . ", DATE =" . $extractDate;
		//echo "<br/>END CHECK DATE, YEAR =" . $_SESSION['currentYear'] . ", MONTH =" . $_SESSION['currentMonth'] . ", DATE =" . $_SESSION['currentDate'];
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
		
		$hereUser_ID = $_SESSION['user_id_student'];
		
		$theQueryToExecute = "";
		
 
			
			$No = $_SESSION["No" . $my_little_counter];
			$Programmes = $_SESSION["Programmes" . $my_little_counter];
			$Date = $_SESSION["Date". $my_little_counter];
			$Year = $_SESSION["Year". $my_little_counter];
			$Credits = $_SESSION["Credits". $my_little_counter];
			$Cost = $_SESSION["Cost". $my_little_counter];
			$registered = $_POST["registered". $my_little_counter];
			$student_id = $_SESSION["student_id" . $my_little_counter];
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
						?>
						<font size="6" "color="red"><br/><br/>could not add stent</font>
						<?php
						//echo "<br/><br/>could not add course";
					}
					else
					{
						?>
						<font size="6" color="red"><br/>NEW STENT ADDED</font>
						<?php
						//echo "<br/>NEW COURSE ADDED";
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
						?>
						<font size="6" color="red"><br/><br/>could not update stent</font>
						<?php
						//echo "<br/><br/>could not update course";
					}
					else
					{
						?>
						<font size="6" color="red"><br/>STENT UPDATED</font>
						<?php
						//echo "<br/>COURSE UPDATED";
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
			$hereUser_ID = $_SESSION['user_id_student'];
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
			$hereUser_ID = $_SESSION['user_id_student'];
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
    		$('#patient_stents').DataTable( {
        		"scrollX": true
    			} );
			} );
		</script>
</html>