<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

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


create_head('Display Assignment');
echo "<body>";

$db = new Database();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Display Assignment";

include("NavigationBar.php");
create_site_header($header_text);
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">

	<form method="POST">
		Assignment ID: <input type="text" name="assignment_id"><br>
		<input type="submit" name="submit" value="Submit">
	</form>
<?php
create_page_link('Home.php', 'Home');

if(isset($_POST['submit'])) {
    GetAssignment();
}
?>
</div>
</section>
</div>

</html>
