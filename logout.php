<?php
session_start();
include_once 'db_connect.php';

if (isset($_SESSION['admin'])) {
	
	unset($_SESSION['admin']);
	unset($_SESSION['userName']);
	unset($_SESSION['place']);
	session_destroy();
	mysqli_close($conn);
	// header("Location: index.php");
?>
	<script>
		window.open('admin_login.php','_blank');window.setTimeout(function(){this.close();},1); 
		// window.location.replace("admin_login.php");
	</script>
<?php
} else {
?>
	<script>
		window.open('admin_login.php','_blank');window.setTimeout(function(){this.close();},1);
		// window.location.replace("admin_login.php");
	</script>
<?php
	// header("Location: index.php");
}
exit;
?>