<div class="widget">
                <h2>LOG IN/SIGN UP</h2>
                <div class="inner">
                   <form action= "login.php" method="post">
				   <ul id="login">
				   <li>Username:<br>
				   <input class="boxshadow" type="text" name="username">
				   </li>
				   <li>Password:<br>
				   <input class="boxshadow" type="password" name="password">
				   </li>
				   <li>
				    <b><input class="button2 width110 p5" type="submit" value="LOG IN" ></b>
				   </li>
				   <li>
				   <br/>
				   <br/>
				   <input class="button2 width110 p5" type="button" value="SIGN UP" onclick="window.location.href='register.php'" />
				  
				   </li>
				   <li>
				   <br/>
				   <br/>
				   <?php echo "<a href = \"SERUCalendar.pdf\" target = \"blank\">Stent Expiry Date Calendar </a>";?>
				   </li>
				   </ul>
				   </form>
                </div>
            </div>