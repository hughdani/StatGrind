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

create_head('Assignment Statistics');
echo "<body>";

$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$user_id = $user->getUserId();
$header_text = "Assignment Statistics";

    
require_once("NavigationBar.php");
create_site_header($header_text);
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">

	<form method="post">
		<div>
			View statistics for assignment: 
			<select name="select_assignment" onchange="this.form.submit();">
				<option disabled value="" selected hidden>Select Assignment</option>
				<option value="All Assignments">All Assignments</option>
				<?php 
                // select all the assignments in the courses taught by the user
				$sql = "SELECT assignment_id, title, course_name FROM assignments INNER JOIN teaching_course ON assignments.course_id = teaching_course.course_id INNER JOIN courses ON teaching_course.course_id = courses.course_id WHERE teaching_course.user_id = $user_id AND visible=1 AND NOW() >= start_date ORDER BY course_name, title";
				$result = $mysqli->query($sql);
				while ($row = $result->fetch_assoc()){
				echo "<option value='".$row["assignment_id"]."''> " . $row['course_name'] . " :: " . $row["title"] . "</option>";
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
                    
                    // get all the latest marks for the selected assignment for each student
                    $sql = "SELECT result
                            FROM
                                results AS outer_result
                            WHERE
                                date_submitted = 
                                (SELECT DISTINCT MAX(date_submitted)
                                FROM
                                    results
                                WHERE
                                    results.student_id = outer_result.student_id
                                    AND results.assignment_id = outer_result.assignment_id)
                            AND
                                outer_result.assignment_id = $selected_id;";
					$result2 = $db->query($sql);
					$assignment_total = 0;
					// Sum up the total marks for the current assignment
					while ($row1 = $result2->fetch_assoc()){
						$assignment_total += $row1["result"];
					}


					$attempts = $result2->num_rows;
                    // all students in the course specified by the assignment
                    $sql = "SELECT *
                            FROM
                                taking_course  
                            INNER JOIN
                                assignments ON taking_course.course_id = assignments.course_id
                            WHERE
                                assignments.assignment_id = $selected_id";
					$result3 = $mysqli->query($sql);
					$num_of_students = $result3->num_rows;

                    // get the number of student who completed this assignment
                    $sql = "SELECT COUNT(*) FROM (SELECT DISTINCT student_id FROM results INNER JOIN users ON results.student_id = users.user_id INNER JOIN account_types ON users.account_type = account_types.account_type WHERE results.assignment_id = $selected_id AND type_description='Student') AS students";
                    $result4 = $mysqli->query($sql);
                    $num_of_participate = ($result4->fetch_row()[0]);

					$average = round($assignment_total / $num_of_students, 2);

                    $sql = "SELECT COUNT(*) AS attempts FROM results WHERE assignment_id = $selected_id";
                    $attempt_results = $mysqli->query($sql);
                    $attempts = $attempt_results->fetch_assoc()['attempts'];


					echo "Number of registered students: " . $num_of_students . "<br> Total number of attempts for this assignment: " . $attempts . "<br> Average attempts: " . round($attempts/$num_of_students, 2) . "<br> Assignment average: " . $average . "<br>" . $num_of_participate . " out of " . $num_of_students . " registered students participated in this assignment <br>";
					

				}
				else
				{
                    // get all assignents for the courses the user is in
                    $sql = "SELECT assignment_id, title, course_name FROM assignments INNER JOIN teaching_course ON assignments.course_id = teaching_course.course_id INNER JOIN courses ON teaching_course.course_id = courses.course_id WHERE teaching_course.user_id = $user_id AND visible=1 AND NOW() >= start_date ORDER BY course_name, title";
                    $result = $mysqli->query($sql);					
					// Loop through all assignments
					echo "<table>
						<tr>
							</div>
							</section>
							</div>
							<th>Assignment Title</th>
							<th>Average Mark</th>
						</tr>";
						while ($row = $result->fetch_assoc()) {		
                            $a_id = $row['assignment_id'];
                            // select all results for this assignment
                            $sql = "SELECT result
                            FROM
                                results AS outer_result
                            WHERE
                                date_submitted = 
                                (SELECT DISTINCT MAX(date_submitted)
                                FROM
                                    results
                                WHERE
                                    results.student_id = outer_result.student_id
                                    AND results.assignment_id = outer_result.assignment_id)
                            AND
                                outer_result.assignment_id = $a_id;";
							$result5 = $mysqli->query($sql);
							$attempts = $result5->num_rows;
							$assignment_total = 0;
							// Sum up the total marks for the current assignment
							while ($row3 = $result5->fetch_assoc()){
								$assignment_total += $row3["result"];
							}
							// Get the number of students in the course for the assignment
                            $sql = "SELECT *
                            FROM
                                taking_course  
                            INNER JOIN
                                assignments ON taking_course.course_id = assignments.course_id
                            WHERE
                                assignments.assignment_id = $a_id";
							$result3 = $mysqli->query($sql);
							$num_of_students = $result3->num_rows;
							$average = round($assignment_total / $num_of_students, 2);
							// set the new table row
							echo "<tr>
									<th> " . $row['course_name'] . " :: " . $row['title'] . "</th>
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
