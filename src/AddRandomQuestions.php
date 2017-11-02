<html>
<head>
    <title>Add Random Questions</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php
	$assignment_id = $_POST['assignment_id'];
	$num_questions = $_POST['num_questions'];
?>

<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Adding <?php echo $num_questions; ?> question(s) to assignment <?php echo $assignment_id; ?></h1>
	</div>

	<?php
        	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
        	$question_id = $mysqli->query("SELECT * FROM `questions`")->num_rows + 1;
		for ($i = 1; $i <= $num_questions; $i++) {
        		$result = $mysqli->query("SELECT DISTINCT location FROM `questions`");
			for ($j = 1; $j <= rand(1, $result->num_rows); $j++){
				$row = $result->fetch_row();
			}
			$newquestionlocation = $row[0];
			$insertsql = "INSERT INTO questions (question_id, assignment_id, location) 
					VALUES ($question_id, $assignment_id, '$newquestionlocation')";
			$mysqli->query($insertsql);
			$question_id = $question_id + 1;
		}
		$mysqli->close();
	?>

	<form action="EditAssignmentPage.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Ok">
	</form>




</div>
</body>
</html>



