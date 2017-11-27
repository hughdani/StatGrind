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

create_head('Assignment Statistics');
echo "<body>";

$db = new Database();
$mysqli = $db->getconn();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Assignment Statistics";

include("NavigationBar.php");
create_site_header($header_text);
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">

	<form method="post">
		<div>
			View statistics for: 
			<select name="select_assignment" onchange="this.form.submit();">
				<option disabled value="" selected hidden>Select Assignment</option>
				<option value="All Assignments">All Assignments</option>
				<?php 
				$sql = "SELECT assignment_id FROM assignments";
				$result = $mysqli->query($sql);
				while ($row = $result->fetch_assoc()){
				echo "<option value='".$row["assignment_id"]."''> Assignment". $row["assignment_id"] . "</option>";
                }
				?>
			</select>
			<br>
			<?php
			if(isset($_POST['select_assignment'])){
				$selected_id = $_POST['select_assignment'];
				if($selected_id != "All Assignments"){
					$assignmentTitle = $db->getAssignmentTitle($selected_id);
					echo "<h3>". $assignmentTitle ."</h3><br>";
					$sql = "SELECT result FROM results WHERE assignment_id = $selected_id";
					$result2 = $db->query($sql);
					$attempts = $result2->num_rows;
					$assignment_total = 0;
					// Sum up the total marks for the current assignment
					while ($row1 = $result2->fetch_assoc()){
						$assignment_total += $row1["result"];
					}

					// Get the number of students in the db, account_type = 2 is for students
					$sql = "SELECT username FROM users INNER JOIN account_types WHERE type_description='Student'";
					$result3 = $mysqli->query($sql);
					$num_of_students = $result3->num_rows;

					while($row2 = $result3->fetch_assoc()){
						$sql = "SELECT COUNT(student_id) FROM results WHERE student_id IN (SELECT user_id FROM users WHERE account_type = 2) and assignment_id = $selected_id";
						$result4 = $mysqli->query($sql);
						$num_of_participate = ($result4->fetch_row()[0]);
					}

					$average = $assignment_total / $num_of_students;
					echo "Number of registered students: " . $num_of_students . "<br> Total number of attempts for this assignment: " . $attempts . "<br> Average attempts: " . $attempts/$num_of_students . "<br> Assignment average: " . $average . "<br>" . $num_of_participate . " out of " . $num_of_students . " registered students participated in this assignment <br>";
					

				}
				else
				{
					$sql = "SELECT assignment_id FROM assignments";
					$result = $mysqli->query($sql);					
					// Loop through all assignments
					echo "<table>
						<tr>
							</div>
</section>
</div>
<th>Assignment Number</th>
							<th>Average Mark</th>
						</tr>";
						while ($row = $result->fetch_assoc()) {		
                            $a_id = $row['assignment_id'];
							$sql = "SELECT result FROM results WHERE assignment_id = $a_id";
							$result5 = $mysqli->query($sql);
							$attempts = $result5->num_rows;
							$assignment_total = 0;
							// Sum up the total marks for the current assignment
							while ($row3 = $result5->fetch_assoc()){
								$assignment_total += $row3["result"];
							}
							// Get the number of students in the db, account_type = 2 is for students
							$sql = "SELECT username FROM users WHERE account_type = 2";
							$result3 = $mysqli->query($sql);
							$num_of_students = $result3->num_rows;
							$average = $assignment_total / $num_of_students;
							// set the new table row
							echo "<tr>
									<th>Assignment ". $row[0] . "</th>
									<th>". $average ."</th>
								</tr>";
						}
					echo "</table>";
				}
			}

			?>
		</div>
	</form>
</div>
</section>
</div>

</body>
</html>
