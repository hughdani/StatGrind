<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: Forbidden.php");
}

create_head('Confirm Submission');
echo "<body>";

$db = new Database();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Confirm Submission";

include("NavigationBar.php");
create_site_header($header_text);

$results = unserialize($_POST['results']);
$student_id = $_POST['student_id'];
$assignment_id = $_POST['assignment_id'];

// Determine result of last question.
If ($_POST['user_answer'] == $_POST['right_answer']){
	$results[] = 100;
} else {
	$results[] = 0;
}
// Calculate results.
$final = 0;
foreach ($results as &$value) {
	$final = $final + $value;
}
$final = $final / count($results);
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">


	<h2>Mark: <?php echo $final . "%"; ?> </h2><br>
	Do you wish to save this attempt? This will overwrite any previous attempts.<br><br>
	<form action="AssignmentOverview.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id; ?>"/>
		<input type="hidden" name="result" id="result" value="<?php echo $final; ?>"/>
		<input type="submit" class="btn btn-default" value="Confirm Submission">
	</form>
	<form action="WriteAssignment.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Try Again">
	</form>
	

</div>
</section>
</div>

</body>
</html>
