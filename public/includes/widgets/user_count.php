<div class="widget">
                <h2>Patients</h2>
                <div class="inner">
				<?php
				$user_count = user_count();
				$suffix = ($user_count !=1) ? 's' : '';
				?>
                We currently have <?php echo $user_count; ?> registered user<?php echo $suffix; ?>.
                </div>
            </div>