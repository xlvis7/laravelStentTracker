<div class="widget">
				<?php
					$theTitle = $user_data['Title'];
					if($theTitle == null || $theTitle == "null")
					{
						$theTitle = "";
					}
				?>
                <h2>Logged in: <br/> <?php echo $user_data['first_name'];?> <?php echo $user_data['last_name'];?></h2>
				
				<?php
				if($user_data['role'] == 'student')
				{
				?>
				<h3>
				<?php
						echo "PAYMENT DUE = RM" . getCostOwed($user_data['username'], $user_data['password'], false);
						echo "<br/>Paid = RM" . getCostOwed($user_data['username'], $user_data['password'], true);
				?>
				</h3>
				<?php
				}
				?>
                <div class="inner">
                <ul>
				<li>
				<input class="button2 width180 p10"  type="button" value="Log out" onclick="window.location.href='logout.php'" />
				</li>
				<li>
				<input class="button2 width180 p10" type="button" value="Change Password" onclick="window.location.href='changepassword.php'" />
				</li>
				<?php
					if($user_data['role'] == 'administrator')
					{
				?>
						<li>
						<input class="button2 width180 p10" type="button" value="Check Patient Check Ups" onclick="window.location.href='register_check_credits.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Stent Summary" onclick="window.location.href='register_check_attendance.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Manage Users" onclick="window.location.href='register_student.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Manage Stents" onclick="window.location.href='register_for_course.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Manage Patient Stents" onclick="window.location.href='register_confirm_courses.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Register Stents for Patients" onclick="window.location.href='register_student_course_admin.php'" />
						</li>
				<?php
					}
					else if($user_data['role'] == 'doctor')
					{
				?>
						<li>
						<input class="button2 width180 p10" type="button" value="Check Patient Check Ups" onclick="window.location.href='register_check_credits.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Stent Summary" onclick="window.location.href='register_check_attendance.php'" />
						</li>
						<!-- <li>
						<input class="button2 width180 p10" type="button" value="Manage Users" onclick="window.location.href='register_student.php'" />
						</li> -->
						<!-- <li>
						<input class="button2 width180 p10" type="button" value="Manage Stents" onclick="window.location.href='register_for_course.php'" />
						</li> -->
						<li>
						<input class="button2 width180 p10" type="button" value="Manage Patient Stents" onclick="window.location.href='register_confirm_courses.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Register Stents for Patients" onclick="window.location.href='register_student_course_admin.php'" />
						</li>
				<?php
					}
					else
					{
				?>
						<li>
						<input class="button2 width180 p10" type="button" value="Check Stent" onclick="window.location.href='register_student_course.php'" />
						</li>
						<li>
						<input class="button2 width180 p10" type="button" value="Update User Information" onclick="window.location.href='register_student.php'" />
						</li>
				<?php
				
					}
				?>
					<li>
					<?php echo "<a href = \"SERUCalendar.pdf\" target = \"blank\">Stent Expiration Date Calendar </a>";?>
					</li>
					<li>
					<?php echo "<a href = \"IncidentReportForm.pdf\" target = \"blank\">Stent Report Form </a>";?>
					</li>
				</ul>
                </div>
            </div>
			
			
			
			<?php
				
	function getCostOwed($username, $password, $getPaid)
	{
	
		$mysqlPassword = "";
		
		
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
			mysql_select_db("seru_students")or die($connect_error);
			
			
			
			$finalcounter = 0;
			$maxID = 0;
			$courses = "";
			$Cost = 0;
			
			$Paid = 0;
			if($getPaid == true)
			{
				$Paid = 1;
			}
			else
			{
				$Paid = 0;
			}
			
										
			$theQueryHere = "SELECT `user_id` FROM `users` WHERE `username` = '" . $username . "' AND `password` = '" . $password . "';";
			//echo "<br/>" . $theQueryHere;
			$sql = mysql_query($theQueryHere);
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$maxID= $row["user_id"];
						
						//echo "<br/>ID =" . $maxID;
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
			
								
			$theQueryHere = "SELECT `courses` FROM `students` WHERE `user_id` = '" . $maxID . "' AND `Paid` = '" . $Paid . "';";
			//echo "<br/>" . $theQueryHere;
			$sql = mysql_query($theQueryHere);
			
			try
			{
				if(!empty($sql))
				{	
					while($row = mysql_fetch_assoc($sql))
					{			
						$courses = $row["courses"];
						
						//echo "<br/>Courses =" . $courses . "=";
						
						$theMiniQuery = "SELECT `Cost` FROM `seru_courses` WHERE `No` = '" . $courses . "' AND `COST` NOT LIKE '%FOC%';";
						
						//echo "" . $theMiniQuery;
						
						$sqlMINI = mysql_query($theMiniQuery);
						
						try
						{
							if(!empty($sqlMINI))
							{
								while($rowMINI = mysql_fetch_assoc($sqlMINI))
								{
									$Cost = $rowMINI["Cost"];
									
									
									$finalcounter = $finalcounter + extract_numbersB("" . $Cost);
								}
							}
						}
						catch( PDOException $e)
						{
							echo "Query failed:".$e->getMessage();
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
			
						
						mysql_close($dbconn) or die ("could not close database");
			
			return $finalcounter;			
	}//end function getCreditsRegistered()
	
	function extract_numbersB($string)
	{
		$match = 0;
		
		$str = $string . "x0";
		preg_match_all('!\d+(?:\.\d+)?!', $str, $matches);
		$floats = array_map('floatval', $matches[0]);
		
		//print_r($floats);
		
		$match = $floats[0];
		
		//echo "" . $match;

		/*//METHOD BASIC
		$match = 0;
		
		$string = preg_replace("/[^0-9]/", '', $string);
		
		if($string == "" || $string == null)
		{
		}
		else
		{
			$match = intval($string);
		}
		/**/

		return $match;
	}//end function extract_numbersB($string)
	
			?>