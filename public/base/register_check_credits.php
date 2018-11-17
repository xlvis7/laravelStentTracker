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
//$_SESSION['currentdate'] = date("Y-m-d H:i:s");

echo "" . $_SESSION['currentYear'] . " - " . $_SESSION['currentMonth'] . " - " . $_SESSION['currentDate'];



if($user_data['role'] != 'administrator' && $user_data['role'] != 'doctor')
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
	
	$user_id;
	$username;
	$password;
	$first_name;
	$last_name;
	$email;
	$active;
	$role;
	$Title;
	$IC_number;
	$Matric_Number;
	$Hand_Phone_Number;
	$Kolej_Kediaman;
	$changeValue;
	$total_Credits;
	
   
mainDisplay();



function mainDisplay()
{
?>
</br>
</br>
<form name ="formOne" method ="Post" action ="register_check_credits.php">
<?php
	accessRulesDisp();
?>

<P>

	
</form>


   <?php 
   }//end function mainDisplay()
   
   
   include 'includes/overall/footer.php';
   
    
   function accessRulesDisp()
   {
		global $counter;
		global $user_data;
		global $total;
		
		
		global $user_id;
		global $username;
		global $password;
		global $first_name;
		global $last_name;
		global $email;
		global $active;
		global $role;
		global $Title;
		global $IC_number;
		global $Matric_Number;
		global $Hand_Phone_Number;
		global $Kolej_Kediaman;
		global $changeValue;
		global $total_Credits;
		
		$my_little_counter = 0;
		$my_little_counter_disp = 1;
 
		
			//user_data($session_user_id, 'user_id', 'username', 'password',  'first_name', 'last_name', 'email', 'active', 'role', 'Title', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');
			
$sql = mysql_query("SELECT * FROM users WHERE role = 'student' ORDER BY first_name;");
//$sql = mysql_query("SELECT * FROM users WHERE role like '%student%'");
try
			{
			?>

					<table class="ep_tm_main"><tr><td align="left">
					<h1 class="ep_tm_pagetitle"><?php echo "PATIENT STENT STATUS";?> </h1>

	
				<table id="stents_status" class="display nowrap table table-striped" style="width: 100%">
					<thead>
					<tr>
						<td><strong>No</strong></td> 
						<td><strong>Username:</strong></td> 
						<td><strong>First Name:</strong></td> 
						<td><strong>Last Name:</strong></td>
						<td><strong>Email Address:</strong></td>		
						<td><strong>IC Number:</strong></td>					
						<td><strong>Gender:</strong></td>					
						<td><strong>Patients ID:</strong></td>					
						<td><strong>Hand Phone Number:</strong></td>					
						<td><strong>Address:</strong></td>				
						<td><strong>Total Check Ups Registered:</strong></td>					
						<td><strong>Total Check Ups Completed:</strong></td>					
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
					
					
			/*
			echo "<br/>TEST LAST = " . $first_name . "=   ";
			echo "<br/>TEST LAST = " . $last_name . "=   ";
			echo "<br/>TEST LAST = " . $email . "=   ";
			echo "<br/>TEST LAST = " . $active . "=   ";
			echo "<br/>TEST LAST = " . $role . "=   ";
			echo "<br/>TEST LAST = " . $Title . "=   ";
			echo "<br/>TEST LAST = " . $IC_number . "=   ";
			echo "<br/>TEST LAST = " . $Matric_Number . "=   ";
			echo "<br/>TEST LAST = " . $Hand_Phone_Number . "=   ";
			echo "<br/>TEST LAST = " . $Kolej_Kediaman . "=   ";
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
					
					$_SESSION["user_id" . $my_little_counter] = $user_id;
					$_SESSION["password" . $my_little_counter] = $password;
					
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $username .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $first_name .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $last_name .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $email .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $IC_number .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Title .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Matric_Number .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Hand_Phone_Number .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Kolej_Kediaman .  "</td>\r\n";
					
					$total_Credits = getCreditsRegistered($user_id, "true");
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $total_Credits .  "</td>\r\n";
					
					$total_Credits = getCreditsCompleted($user_id, "true");
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $total_Credits .  "</td>\r\n";
									
					
					//echo "User ".$row_Val . "<br/>";
					$my_little_counter++;
					$_SESSION['counterMax'] = $my_little_counter;
					
					echo "</tr>\r\n";
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
   
	function getCreditsRegistered($student_id_here, $reprocess)
	{
			if(isset($_SESSION["studentCreditsRegistered" . $student_id_here]) && $reprocess == "false")
			{
				//echo "BASIC";
				$maxID = $_SESSION["studentCreditsRegistered" . $student_id_here];
			}
			else
			{
			$finalcounter = 0;
			$maxID = 0;
			$hereUser_ID = $student_id_here;
			$theQueryHere = "SELECT * FROM students WHERE user_id = '" . $hereUser_ID . "' AND registered = 'registered';";
			//echo "" . $theQueryHere;
			$sql = mysql_query($theQueryHere);
			
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
			
			$_SESSION["studentCreditsRegistered" . $hereUser_ID] = $maxID;
			
				//echo "REPROSES =" . $_SESSION["studentCreditsCompleted" . $hereUser_ID] . "=  id = " . $hereUser_ID;
			}
			
			return $maxID;
	}//end function getCreditsRegistered()
	
	
	function getCreditsCompleted($student_id_here, $reprocess)
	{
			if(isset($_SESSION["studentCreditsCompleted" . $student_id_here]) && $reprocess == "false")
			{
				//echo "BASIC";
				$maxID = $_SESSION["studentCreditsCompleted" . $student_id_here];
			}
			else
			{
			$finalcounter = 0;
			$maxID = 0;
			$hereUser_ID = $student_id_here;
			
			$theQueryHere = "SELECT * FROM students WHERE user_id = '" . $hereUser_ID . "' AND registered = 'completed';";
			//echo "" . $theQueryHere;
			$sql = mysql_query($theQueryHere);
			
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
			
			$_SESSION["studentCreditsCompleted" . $hereUser_ID] = $maxID;
			
				//echo "REPROSES =" . $_SESSION["studentCreditsCompleted" . $hereUser_ID] . "=  id = " . $hereUser_ID;
			}
			
			return $maxID;
	}//end function getCreditsCompleted()
   
   
   
   
   
			mysql_close($dbconn) or die ("could not close database");
   
   ?>

   </body>
		<script>
			$(document).ready(function() {
    		$('#stents_status').DataTable( {
        		"scrollX": true
    			} );
			} );
		</script>
</html>