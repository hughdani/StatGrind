<html>
<head>
    <title>Select Question</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php 
$assignment_id = $_POST['assignment_id'];
?>

<body>

<div class="container-fluid">

        <div class="jumbotron">
            <h1>Select Question</h1>
        </div>

		<?php
		$i = 1;
		$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
		$result = $mysqli->query("SELECT question_id, location FROM questions");
		$displayed = [];
		while ($row = $result->fetch_row()) {
			if (!in_array($row[1], $displayed)) {
				echo "<h2>Question $i</h2><br>";
				$filetxt = file_get_contents($row[1]);
				$q = explode("ANSWER:", $filetxt);
				echo $q[0] . "<br><br>";
				echo "ANSWER: " . $q[1];
				array_push($displayed, $row[1]);
				$i = $i + 1;
			
		?>
		<form action="EditAssignmentPage.php" method="post">
            <input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
			<input type="hidden" name="question_id" id="question_id" value="<?php echo $row[0]; ?>"/>
            <input type="submit" class="btn btn-default" value="Select Question">
        </form>
		
		<?php
			}
		}
		$mysqli->close();		
		?>

</div>
</body>
</html>
