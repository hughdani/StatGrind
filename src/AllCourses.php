<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<h2>Courses Taught By Me</h2>
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
//if (isset($_POST['user_id'])) {
if (true) {
    $mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');
    //$user_id = $_POST['user_id'];
    $user_id = 124;
    if (!permission_check($mysqli, $user_id)) {
        header('Location: Forbidden.php');
    }
    // do a look up on the courses taught by the user
    $query = "";
    $query = $query . "SELECT * FROM courses WHERE course_id IN";
    $query = $query . "(SELECT course_id FROM teaching_course WHERE user_id = $user_id)";
    $result = $mysqli->query($query);
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
?>

