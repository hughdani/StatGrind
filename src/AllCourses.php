<!-- Page containing all courses for an instructor-->
  
<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php
session_start();

/**
 * Returns true if the user_id belongs to an instructor
 *
 * @param int $user_id  the id of the user accessing the page
 */
function permission_check($user_id) {
  $user_id = 
  $mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');

  // search the current user in instructor records 
  $result = $mysqli->query("SELECT * FROM users LEFT JOIN account_types ON user.account_type = account_types.account_type WHERE user.user_id = $user_id AND account_types.type_description='Instructor'");

  // user was not found as an instructor
  if ($result->num_rows == 0) {
    return false;
  }

  return true;
}

if (isset($_SESSION['user_id'])) {
  if (!permission_check($_SESSION['user_id'])){
    header('Location: Forbidden.php');
  }

  // do a look up on the courses taught by the user
  $result = $mysqli->query("SELECT * FROM courses WHERE course_id IN (SELECT course_id FROM teaching_course WHERE user_id = $user_id)";
  if ($result->num_rows > 0) {
    echo "<form method='post' action='ManageCourse.php'>";
    while ($row = $result->fetch_assoc()) {
      $course_id = $row['course_id'];
      $course_name = $row['course_name'];
      $course_desc = $row['course_desc'];
      echo "<br> <b>$course_name</b>";
      echo "<br> $course_desc";
      echo "<br> <input type='submit' name='course-$course_id' value=$course_id class='btn btn-default'> <br>";
    }
    echo "</form>";
  } else {
    echo "No courses found!";
  }
}

