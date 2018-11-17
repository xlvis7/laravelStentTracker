<div class="widget">
				<?php
					$theTitle = $user_data['Title'];
					if($theTitle == null || $theTitle == "null")
					{
						$theTitle = "";
					}
				?>
                <h2>Logged in: <?php echo $theTitle;?> <?php echo $user_data['first_name'];?> <?php echo $user_data['last_name'];?></h2>
                <div class="inner">
                <ul>
				<li>
				<a href="logout.php">Log out</a>
				</li>
				<li>
				<a href="changepassword.php">Change Password</a>
				</li>
				<?php
					if($user_data['role'] == 'administrator'||$user_data['role'] == 'doctor')
					{
				?>
						<li>
						<a href="register_check_credits.php">Check Patients Attendances</a>
						</li>
						<li>
						<a href="register_student.php">Manage Patients</a>
						</li>
						<li>
						<a href="register_for_course.php">Manage Stents</a>
						</li>
						<li>
						<a href="register_confirm_courses.php">Manage Patients Stents</a>
						</li>
				<?php
					}
					else
					{
				?>
						<li>
						<a href="register_student_course.php">Check Stents</a>
						</li>
				<?php
					}
				?>
				</ul>
                </div>
            </div>