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
	
create_head('Confirm Assignment Creation');
echo "<body>";

$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = $db->getPageTitle(basename(__FILE__));


include("NavigationBar.php");
create_site_header($header_text);

echo "<div class='container-fluid'>";
echo "<section class='wrapper style2 special'>";
echo "<div class='inner narrow'>";

echo $db->getAssignmentTitle($_POST["assignment_id"]) . " successfully added.";
?>

<p>What would you like to do next?</p>
<!-- Quick path to get back to creating new assignments. -->
<form action="NewAssignment.php" method="post">
    <input type="submit" class="btn btn-default" value="Create New Assignment">
</form>

<!-- Quick path to view all created assignments. -->
<form action="AllCreatedAssignments.php" method="post">
    <input type="submit" class="btn btn-default" value="View All Assignments">
</form>
</div>
</section>
</div>
</body>

