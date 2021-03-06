<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';
$db = new Database();
$mysqli = $db->getconn();

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
create_head('Write Assignment');
echo "<body>";

$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$user_id = $user->getUserId();
$account_type = $user->getAccountType();
$header_text = $db->getPageTitle(basename(__FILE__));

include("NavigationBar.php");
create_site_header($header_text);

?>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
Find Assignment:
<form action="ChooseAssignment.php" method="post">
	<input type="text" name="search_param" id="search_param" placeholder="Search for Assignment Titles/Tags">
	<input type="submit" value ="Search">
</form>
<?php
// Select all assignments where the end date hasn't passed
$sql = "SELECT assignment_id, end_date FROM assignments INNER JOIN taking_course ON assignments.course_id = taking_course.course_id WHERE end_date > NOW() AND start_date <= NOW() AND visible=true AND taking_course.user_id = $user_id";

//Apply search params if any
if (isset($_POST['search_param'])) {
	$sql = $sql . " AND (tag LIKE '%".$_POST['search_param']."%' OR title LIKE '%".$_POST['search_param']."%')";
}
$assignments = $mysqli->query($sql);
// Loop through and display each assignment
while ($row = $assignments->fetch_assoc()) {
	$assignment_id = $row["assignment_id"];
	$assignment_title = $db->getAssignmentTitle($assignment_id);
	$end_date = $row["end_date"];
	echo "<h2>$assignment_title </h2><br>";
	// Get previous attempt mark
	$sql = "SELECT result FROM results WHERE student_id = '$user_id' AND assignment_id = $assignment_id ORDER BY attempt_id DESC";
	$result = $mysqli->query($sql);
	$attempts = $result->num_rows;
	if ($attempts > 0) {
		$mark = $result->fetch_assoc()["result"] . "%";
	} else {
		$mark = "N/A";
	}
	echo "Available until : " . $end_date . "<br>";
	echo "Last Attempt: " . $mark . "<br>";
	echo "<form action='WriteAssignment.php' method='post'>";
	echo "<input type='hidden' name='assignment_id' id='assignment_id' value='$assignment_id'>";
	echo "<input type='hidden' name='student_id' id='student_id' value='$user_id'>";
	echo "<input type='submit' value ='Write This Assignment'>";
        echo "</form><br>";
	
}

?>
</div>
</section>
</div>
</div>
</body>
</html>
