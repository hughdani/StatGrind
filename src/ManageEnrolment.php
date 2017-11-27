<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';
$db = new Database();

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
create_head('Course Enrolment');
echo "<body>";


$user = $_SESSION['user'];
$user_id = $user->getUserId();
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Manage Enrolment";

include("NavigationBar.php");
create_site_header($header_text);

if (isset($_POST['course_id'])) {
    $c_id = ($_POST['course_id']);
    // get all instructors and TAs
    echo "<div class='container-fluid'>";
    echo "<section class='wrapper style2 special'>";
    echo "<div class='inner narrow'>";
    echo "<h2>Instructors</h2>";
    $sql = "SELECT * FROM users
        INNER JOIN account_types ON users.account_type = account_types.account_type
        WHERE users.user_id <> $user_id
        AND account_types.type_description='Instructor'
        ORDER BY users.last_name, users.first_name";
    $instructors = $db->query($sql);
    create_forms($instructors, 'teaching_course');
    echo "<h2>TAs</h2>";
    $sql = "SELECT * FROM users
        INNER JOIN account_types ON users.account_type = account_types.account_type
        WHERE users.user_id <> $user_id
        AND account_types.type_description='TA'
        ORDER BY users.last_name, users.first_name";
    $tas = $db->query($sql);
    create_forms($tas, 'teaching_course');
    // get all Students
    echo "<h2>Students</h2>";
    $sql = "SELECT * FROM users
        INNER JOIN account_types ON users.account_type = account_types.account_type
        WHERE users.user_id <> $user_id
        AND account_types.type_description='Student'
        ORDER BY users.last_name, users.first_name";
    $students = $db->query($sql);
    create_forms($students, 'taking_course');
}
create_page_link('EditCourses.php', 'Edit Courses');
echo "</div>";
echo "</section>";
echo "</div>";
/**
 * Creates a series of forms based on given data
 *
 * @param mixed   $data   the dataset to create forms for
 * @param string  $table the name of the table to check enrolment in
 */
function create_forms($data, $table) {
    global $c_id;
    global $db;
    if ($data->num_rows > 0) {
        echo "<form method='post' action=''>";
        while ($row = $data->fetch_assoc()) {
            $u_id = $row['user_id'];
            $u_fname = $row['first_name'];
            $u_lname = $row['last_name'];
            $u_enrol = is_enrolled($u_id, $table) ? "checked" : "";
?>
      <br>
      <b> ID: <?= $u_id ?> </b>
      <br>
      <b> Name: <?= $u_lname, $u_fname ?> </b>
      <br>
      <input type='checkbox' id='ec-<?=$u_id;?>' class='chk-enrol form-check-input' value='<?= "$c_id;$u_id;$table" ?>' <?= $u_enrol ?>>
      <label for='ec-<?=$u_id;?>'> Enrolled </label>
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
    global $db;
    global $c_id;
    $mysqli = $db->getconn();
    $sql = "SELECT * FROM $table WHERE user_id = $u_id AND course_id = $c_id";
    return ($mysqli->query($sql)->num_rows > 0);
}
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
