<html>
<head>
    <title>Assignment Statistics</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Assignment Statistics</h1>
	</div>

	<form method="post">
		<div>
			View statistics for: 
			<select name="selectAssignment" onchange="this.form.submit();">
				<option disabled value="" selected hidden>Select Assignment</option>
				<option value="All Assignments">All Assignments</option>
				<?php 
				$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
				$sql = "SELECT assignment_id FROM assignments";
				$result = $mysqli->query($sql);
				while ($row = $result->fetch_row()){
				echo "<option value='".$row[0]."''> Assignment". $row[0] . "</option>";
				}
				?>
			</select>
			<br>

			<?php
			if(isset($_POST['selectAssignment'])){
				$selectedId = $_POST['selectAssignment'];
				if($selectedId != "All Assignments"){
					echo "<h3>Assignment ". $selectedId ."</h3><br>";
					$sql = "SELECT result FROM results WHERE assignment_id = $selectedId";
					$result2 = $mysqli->query($sql);
					$attempts = $result2->num_rows;
					$assignmentTotal = 0;
					// Sum up the total marks for the current assignment
					while ($row1 = $result2->fetch_row()){
						$assignmentTotal += $row1[0];
					}

					// Get the number of students in the db, account_type = 2 is for students
					$sql = "SELECT username FROM users WHERE account_type = 2";
					$result3 = $mysqli->query($sql);
					$num_of_students = $result3->num_rows;

					while($row2 = $result3->fetch_row()){
						$sql = "SELECT COUNT(student_id) FROM results WHERE student_id IN (SELECT user_id FROM users WHERE account_type = 2) and assignment_id = $selectedId";
						$result4 = $mysqli->query($sql);
						$num_of_participate = ($result4->fetch_row())[0];
					}

					$average = $assignmentTotal / $num_of_students;
					echo "Number of registered students: " . $num_of_students . "<br> Total number of attempts for this assignment: " . $attempts . "<br> Average attempts: " . $attempts/$num_of_students . "<br> Assignment average: " . $average . "<br>" . $num_of_participate . " out of " . $num_of_students . " registered students participated in this assignment <br>";
					

				}
				else
				{
					// declare array to be pass into drawChart function
					$assignmentsArray = array("Assignment Number", "Average Grade");
					$sql = "SELECT assignment_id FROM assignments";
					$result = $mysqli->query($sql);					
					// Loop through all assignments
					while ($row = $result->fetch_row()) {		
						$sql = "SELECT result FROM results WHERE assignment_id = $row[0]";
						$result5 = $mysqli->query($sql);
						$attempts = $result5->num_rows;
						$assignmentTotal = 0;
						// Sum up the total marks for the current assignment
						while ($row3 = $result5->fetch_row()){
							$assignmentTotal += $row3[0];
						}
						// Get the number of students in the db, account_type = 2 is for students
						$sql = "SELECT username FROM users WHERE account_type = 2";
						$result3 = $mysqli->query($sql);
						$num_of_students = $result3->num_rows;
						$average = $assignmentTotal / $num_of_students;
						// set the new array
						$newArray = array("Assignment ".$row[0], $average);
						array_push($assignmentsArray, $newArray);
					}
					print_r($assignmentsArray);

					echo "<div id='avgChart'></div>";
					?>
					<script>
						// Load google charts
						google.charts.load('current', {'packages':['corechart']});
						google.charts.setOnLoadCallback(drawChart);

						// Draw the chart and set the chart values
						function drawChart(dataArray, divID) {
						  var data = google.visualization.arrayToDataTable(dataArray(<?php $assignmentsArray ?>,"avgChart"));

						  // Optional; add a title and set the width and height of the chart
						  var options = {'title':'Assignments Average', 'width':550, 'height':400};

						  // Display the chart inside the <div> element with id="piechart"
						  var chart = new google.visualization.BarChart(document.getElementById(divID));
						  chart.draw(data, options);
						}
					</script>

					<?php
				}
			}

			?>
		</div>
	</form>
</div>
</body>
</html>