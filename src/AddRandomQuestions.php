<html>
<head>
    <title>Add Random Questions</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<?php

include 'Database.php';
$db = new Database();

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
			if (isset($_POST['questionTag'])){
				$filter = $_POST['questionTag'];
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

	<form action="EditAssignmentPage.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Ok">
	</form>




</div>
</body>
</html>



