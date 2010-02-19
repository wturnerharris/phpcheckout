<?php 
require_once('config.php');
include('includes/heading.html'); 
$page = $_REQUEST['page'];

if (isset($page)){
} else {
		$page = "general";
}

if ($page==""){
		$page == "general";
		$gState = "active";
		$uState = $eState = $cState = $sState = "inactive";
} else {
if ($page == "general") {
		$gState = "active";
		$uState = $eState = $cState = $sState = "inactive";
} else {
		if ($page == "users") {
				$uState = "active";
				$gState = $eState = $cState = $sState = "inactive";
		} else {
				if ($page == "equipment") {
						$eState = "active";
						$uState = $gState = $cState = $sState = "inactive";
				} else {
						if ($page == "classes") {
								$cState = "active";
								$uState = $eState = $gState = $sState = "inactive";
						} else {
								if ($page == "students") {
										$sState = "active";
										$uState = $eState = $cState = $gState = "inactive";
								}		
						}
				}
		}
}
}
?>
<meta http-equiv="refresh" content="600;URL=admin.php?page=<? echo $page; ?>">
		<div id="admin-main">
				<div id="admin-page">
				<?php
						if ($page == "general") {
								include('general.php');
						} else	{							
								if ($page == "users") {
										include('users.php');								
								} else {
										if ($page == "equipment") {
												include('equipment.php');
										} else {
												if ($page == "classes") {
														include('classes.php');
												} else {
														if ($page == "students") {
																include('students.php');								
														}
												}
										}
								}
						}
				?>
				</div>
				<ul id="admin-nav">
					<li class="admin-link <?php echo $gState; ?>"><a href="?page=general">General</a></li>
					<li class="admin-link <?php echo $uState; ?>"><a href="?page=users">Users</a></li>
					<li class="admin-link <?php echo $eState; ?>"><a href="?page=equipment">Equipment</a></li>
					<li class="admin-link <?php echo $cState; ?>"><a href="?page=classes">Classes</a></li>
					<li class="admin-link <?php echo $sState; ?>"><a href="?page=students">Students</a></li>
				</ul>
		</div>
<?php
include('includes/footer.html'); 
?>
