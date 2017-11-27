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


<html>
<head>
    <title>Confirm Submission</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
<div class="container-fluid">

	<div class="jumbotron">
		<h1>Confirm Submission</h1>
	</div>

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
</body>
</html>
