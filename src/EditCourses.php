<html>
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
if (isset ($_POST['course_id'])) {
  $course_id = $_POST['course_id'];
  $new_cname = $_POST['course_name'];
  $new_cdesc = $_POST['course_desc'];
  if ($new_cname != "" && $new_cdesc == "") {
    $query = "UPDATE courses SET course_name = '$new_cname' WHERE course_id = $course_id";
  }
  if ($new_cname == "" && $new_cdesc != "") {
    $query = "UPDATE courses SET course_desc = '$new_cdesc' WHERE course_id = $course_id";
  }
  if ($new_cname != "" && $new_cdesc != "") {
    $query = "UPDATE courses SET course_name = '$new_cname' AND course_desc = '$new_cdesc' WHERE course_id = $course_id";
  }
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
    <input type='submit' value='Submit Changes' class='btn btn-default'> 
  </div>

</form>
<?php
    }
} else {
    echo "No courses found!";
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

