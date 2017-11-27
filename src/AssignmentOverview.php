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


create_head('Assignment Overview');
echo "<body>";

$mysqli = $db->getconn();
$user = $_SESSION['user'];
$user_id = $user->getUserId();
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Assignment Overview";

include("NavigationBar.php");
create_site_header($header_text);
// If comming from ConfirmSubmission page, insert submission into results table
if (isset($_POST['result'])) {
	$result = $_POST['result'];
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO results (student_id, assignment_id, result) VALUES ('$user_id', $assignment_id, $result)";
	$mysqli->query($sql);
}
?>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
Find assignment:
<form action="AssignmentOverview.php" method="post">
	<input type="text" name="search_param" id="search_param" placeholder="Search for assignments">
	<input type="hidden" name="student_id" id="student_id" <?php if ($student_id){ echo "value=$student_id";} ?>>
	<input type="submit" value ="Search">
</form>

<?php
// Select all assignment from assignment table.
$sql = "SELECT assignment_id, start_date, end_date FROM assignments WHERE NOW() >= start_date AND visible=1";

//Apply search params if any
if (isset($_POST['search_param'])) {
	$filter = $_POST['search_param'];
	$sql = $sql . " AND tag LIKE '%$filter%' OR title LIKE '%$filter%'";
}

$result = $mysqli->query($sql);
// Display open assignments.
while ($row = $result->fetch_assoc()) {
	$assignment_title = $db->getAssignmentTitle($row["assignment_id"]);
		echo "<h2>$assignment_title</h2>";
        $a_id = $row['assignment_id'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];

		// Select all student attempts for this assignment.
		$sql = "SELECT result, feedback FROM results WHERE student_id = '$user_id' AND assignment_id = $a_id ORDER BY attempt_id DESC LIMIT 1";
		$result2 = $mysqli->query($sql);
		$attempts = $result2->num_rows;
		if ($attempts > 0) {
            $row2 = $result2->fetch_assoc();
			$mark = $row2['result'];
            $feedback = $row2['feedback'];
        } else {
            $mark = 'TBA';
            $feedback = 'TBA';
        }
		echo "<b> Posted </b>: $start_date <br>";
        echo "<b> Due </b>: $end_date <br>";
		echo "<b> Mark </b>: $mark <br>";
		echo "<b> Instructor feedback </b>: $feedback <br><br><br><br>";
}

?>
</div>
</section>
</div>
</div>
</body>
</html>
