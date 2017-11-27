<?php
 	require_once 'Database.php';
	require_once 'User.php';
	require_once 'Utils.php';
	$db = new Database();

	if (!isset($_SESSION)) {
  		session_start();
	}
	if (!isset($_SESSION['user'])) {
	    header("Location: error.php?error_status=401");
	    exit();
	} elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
	    header("Location: error.php?error_status=403");
	    exit();
	}

create_head('Assignment Answer');
?>
<body>
<form method="POST">
    Assignment ID: <input type="text" name="assignment_id"><br>
    <input type="submit" name="submit" value="Search Answer">
</form>


<?php
create_page_link('Home.php', 'Home');

if(isset($_POST['submit'])) {
    GetAssignment();
}
    ?>
</body>
</html>
