
<head>
    <title>Edit My Courses</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<h1>Courses Taught By Me</h1>
<?php
session_start();
$mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');
$user_id = $_SESSION['user_id'];
$user_id = 124;
if (!permission_check($mysqli, $user_id)) {
    header('Location: Forbidden.php');
}
// Update records before pulling them if posting back to the same page
if (isset($_POST['up_course'])) {
    $course_id = $_POST['course_id'];
    $up_cname = $_POST['course_name'];
    $up_cdesc = $_POST['course_desc'];
    if ($up_cname != "" && $up_cdesc == "") {
        $query = "UPDATE courses SET course_name = '$up_cname' WHERE course_id = $course_id";
    }
    if ($up_cname == "" && $up_cdesc != "") {
        $query = "UPDATE courses SET course_desc = '$up_cdesc' WHERE course_id = $course_id";
    }
    if ($up_cname != "" && $up_cdesc != "") {
        $query = "UPDATE courses SET course_name = '$up_cname', course_desc = '$up_cdesc' WHERE course_id = $course_id";
    }
    $mysqli->query($query);
}
if (isset($_POST['create_course'])) {
    $new_cname = $_POST['new_cname'];
    $new_cdesc = $_POST['new_cdesc'];
    $query = "INSERT INTO courses (course_name, course_desc) VALUES ('$new_cname', '$new_cdesc')";
    $mysqli->query($query);
    $query = "INSERT INTO teaching_course (user_id, course_id) VALUES ($user_id, $mysqli->insert_id)";
    $mysqli->query($query);
}
// do a look up on the courses taught by the user
$query = "";
$query = $query . "SELECT * FROM courses WHERE course_id IN";
$query = $query . "(SELECT course_id FROM teaching_course WHERE user_id = $user_id)";
$result = $mysqli->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course_id = $row['course_id'];
        $course_name = $row['course_name'];
        $course_desc = $row['course_desc'];
?>
<form method='post'>
  <input type='hidden' name='course_id' value='<?php echo $course_id ?>'>

  <div class='form-group'>
    <label for='name<?php echo $course_id ?>'> <?php echo $course_name ?> </label>
    <input id='name<?php echo $course_id ?>' type='text' name='course_name' placeholder='<?php echo $course_name ?>' class='form-control'>
  </div>

  <div class='form-group'>
    <label for='desc<?php echo $course_id ?>'> <?php echo $course_desc ?> </label>
    <textarea id='desc<?php echo $course_id ?>' name='course_desc' placeholder='<?php echo $course_desc ?>' class='form-control'></textarea>
  </div>

  <div class='form-group'>
    <input type='submit' name='up_course' value='Submit Changes' class='btn btn-default'> 
  </div>
</form>
<form method='post' action='ManageEnrolment.php'>
  <div class='form-group'>
    <input type='hidden' name='course_id' value='<?php echo $course_id ?>'>
    <input type='submit' name='manage_enrolment' value='Manage Enrolment' class='btn btn-default'> 
  </div>
</form>
<?php
    }
} else {
    echo "No courses found!";
}
$mysqli->close();
?>
<form method='post' action='CreateCourse.php'>
  <input type='submit' value='New Course' class='btn btn-default'>
</form>
<?php
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

