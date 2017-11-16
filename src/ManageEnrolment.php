<!-- Page containing all assignments created -->
  
<html>
<head>
    <title>Manage Enrolment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<h1>Manage Enrolment</h1>
<?php
session_start();
$mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');
$user_id = $_SESSION['user_id'];
$user_id = 124;
if (!permission_check($user_id)) {
    header('Location: Forbidden.php');
}
if (isset($_POST['course_id'])) {
    $c_id = ($_POST['course_id']);
    // get all instructors and TAs
    echo "<h2>Instructors</h2>";
    $query = "";
    $query = $query . "SELECT * FROM users u LEFT JOIN account_types t ";
    $query = $query . "ON u.account_type = t.account_type ";
    $query = $query . "WHERE u.user_id <> $user_id ";
    $query = $query . "AND t.type_description='Instructor' ";
    $query = $query . "ORDER BY u.last_name, u.first_name";
    $result = $mysqli->query($query);
    create_forms($result, 'teaching_course');
    echo "<h2>TAs</h2>";
    $query = "";
    $query = $query . "SELECT * FROM users u LEFT JOIN account_types t ";
    $query = $query . "ON u.account_type = t.account_type ";
    $query = $query . "WHERE u.user_id <> $user_id ";
    $query = $query . "AND t.type_description='TA' ";
    $query = $query . "ORDER BY u.last_name, u.first_name";
    $result = $mysqli->query($query);
    create_forms($result, 'teaching_course');
    // get all Students
    echo "<h2>Students</h2>";
    $query = "";
    $query = $query . "SELECT * FROM users u LEFT JOIN account_types t ";
    $query = $query . "ON u.account_type = t.account_type ";
    $query = $query . "WHERE u.user_id <> $user_id AND t.type_description = 'Student' ";
    $query = $query . "ORDER BY u.last_name, u.first_name";
    $result = $mysqli->query($query);
    create_forms($result, 'taking_course');
}
?>
<!-- Quick path to get back to managing courses. -->
<form action="EditCourses.php" method="post">
    <input type="submit" class="btn btn-default" value="Manage Courses">
</form>
<?php
/**
 * Creates a series of forms based on given data
 *
 * @param mixed   $data   the dataset to create forms for
 * @param string  $table the name of the table to check enrolment in
 */
function create_forms($data, $table) {
    global $mysqli;
    global $c_id;
    if ($data->num_rows > 0) {
        echo "<form method='post' action=''>";
        while ($row = $data->fetch_assoc()) {
            $u_id = $row['user_id'];
            $u_fname = $row['first_name'];
            $u_lname = $row['last_name'];
            $u_enrol = is_enrolled($u_id, $table) ? "checked" : "";
?>
      <br>
      <?php echo "<b>ID</b>: $u_id" ?>
      <br>
      <?php echo "<b>Name</b>: $u_lname, $u_fname" ?>
      <br>
      <label class='form-check-label'>
      <input type='checkbox' class='chk-enrol form-check-input' value='<?php echo "$c_id;$u_id;$table" ?>' <?php echo $u_enrol ?>> Enrolled </label>
      <br>
<?php
        }
        echo "</form>";
    }
}
/**
 * Returns true if the user is enrolled in course
 *
 * @param int $u_id   the id of the user to look up
 * @param int $table  the name of the table to look up the user on
 */
function is_enrolled($u_id, $table) {
    global $mysqli;
    global $c_id;
    $query = "SELECT * FROM $table WHERE user_id = $u_id AND course_id = $c_id";
    return (($mysqli->query($query))->num_rows > 0);
}
/**
 * Returns true if the user_id belongs to an instructor
 *
 * @param int $user_id  the id of the user accessing the page
 */
function permission_check($user_id) {
    global $mysqli;
    $query = "";
    $query = $query . "SELECT * FROM users LEFT JOIN account_types ";
    $query = $query . "ON users.account_type = account_types.account_type ";
    $query = $query . "WHERE users.user_id = $user_id AND account_types.type_description='Instructor'";
    // search the current user in instructor records
    $result = $mysqli->query($query);
    return ($result->num_rows != 0);
}
$mysqli->close();
?>
<script>
$(document).ready(function() {
  // event for visibility checkboxes
  $('.chk-enrol').change(function () {
    // get info about the checkbox's assignment
    var [c_id, u_id, table] = $(this).val().split(";");
    var u_enrol = $(this).is(':checked') ? 1 : 0;
    var u_data = {'f_set_enrolment': 'true', 'table': table, 'u_id': u_id, 'c_id': c_id, 'u_enrol': u_enrol};
    // send info to server
    $.ajax({
        url:"Ajax.php",
        type: "post",
        dataType: 'json',
        data: u_data,
        success: function(data) { console.log(data); },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        }
    });
  });
});
</script>
