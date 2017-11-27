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
?>
<html>
<head>
    <title>Add Random Questions</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<?php

	$assignment_id = $_POST['assignment_id'];
	$num_questions = $_POST['num_questions'];
	$assignment_title = $db->getAssignmentTitle($assignment_id) ;
?>

<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Adding <?= $num_questions; ?> question(s) to <?= $assignment_title; ?></h1>
	</div>

	<?php
		for ($i = 1; $i <= $num_questions; $i++) {
			$sql = "SELECT question_id FROM `questions`";
			
			// Apply filter if any
			if (isset($_POST['question_tag'])){
				$filter = $_POST['question_tag'];
				$sql = $sql . " WHERE tag LIKE '%$filter%'";
			}
			
        		$result = $db->query($sql);
			for ($j = 1; $j <= rand(1, $result->num_rows); $j++){
				$row = $result->fetch_row();
			}
			$question_id = $row[0];
			$insertsql = "INSERT INTO in_assignment (assignment_id, question_id) 
					VALUES ($assignment_id, $question_id)";
			$db->query($insertsql);
		}
	?>

	<form action="EditAssignment.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Ok">
	</form>




</div>
</body>
</html>



