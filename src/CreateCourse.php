<html>
<head>
    <title>Edit My Courses</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<h1>Add a New Course</h1>
<form method='post' action='EditCourses.php'>
  <div class='form-group'>
    <label for='new_cname'>New Course Name</label>
    <input id='new_cname' type='text' name='new_cname' placeholder='Course Name' class='form-control'>
  </div>

  <div class='form-group'>
    <label for='new_cdesc>'>New Course Description</label>
    <textarea id='new_cdesc' name='new_cdesc' placeholder='Course Description' class='form-control'></textarea>
  </div>

  <div class='form-group'>
    <input type='submit' name='create_course' value='Add Course' class='btn btn-default'> 
</form>
<?php
session_start();
$mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');

$user_id = $_SESSION['user_id'];
$user_id = 124;

if (!permission_check($mysqli, $user_id)) {
    header('Location: Forbidden.php');
}
$mysqli->close();

/**
 * Returns true if the user_id belongs to an instructor
 *
 * @param int $user_id  the id of the user accessing the page
 */
function permission_check($mysqli, $user_id) {
    $query = "";
    $query = $query . "SELECT * FROM users LEFT JOIN account_types ";
    $query = $query . "ON users.account_type = account_types.account_type ";
    $query = $query . "WHERE users.user_id = $user_id AND account_types.type_description='Instructor'";
    // search the current user in instructor records
    $result = $mysqli->query($query);
    return ($result->num_rows != 0);
}
?>

