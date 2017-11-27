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

create_head('Course Management');
echo "<body>";

$db = new Database();
$mysqli = $db->getconn();
$user = $_SESSION['user'];
$user_id = $user->getUserId();
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Course Management";

include("NavigationBar.php");
create_site_header($header_text);


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
$sql = "SELECT courses.course_id, courses.course_name, courses.course_desc
    FROM courses
    INNER JOIN teaching_course ON courses.course_id = teaching_course.course_id
    WHERE teaching_course.user_id = $user_id";
$courses = $mysqli->query($sql);
?>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
<?php if ($courses->num_rows > 0): ?>
    <?php while ($c = $courses->fetch_assoc()): ?>
    <form method='post'>
      <input type='hidden' name='course_id' value='<?= $c['course_id'] ?>'>

      <div class='form-group'>
        <label for='name<?= $c['course_id'] ?>'> <?= $c['course_name'] ?> </label>
        <input id='name<?= $c['course_id'] ?>' type='text' name='course_name' placeholder='<?= $c['course_name'] ?>' class='form-control'>
      </div>

      <div class='form-group'>
        <label for='desc<?= $c['course_id'] ?>'> <?= $c['course_desc'] ?> </label>
        <textarea id='desc<?= $c['course_id'] ?>' name='course_desc' placeholder='<?= $c['course_desc'] ?>' class='form-control'></textarea>
      </div>

      <div class='form-group'>
        <input type='submit' name='up_course' value='Submit Changes' class='btn btn-default'> 
      </div>
    </form>
    <form method='post' action='ManageEnrolment.php'>
      <div class='form-group'>
        <input type='hidden' name='course_id' value='<?= $c['course_id'] ?>'>
        <input type='submit' name='manage_enrolment' value='Manage Enrolment' class='btn btn-default'> 
      </div>
    </form>
    <?php endwhile ?>
<?php else: ?>
    No courses found!
<?php endif ?>

<?php
create_page_link('CreateCourse.php', 'Create Course');
?>
</div>
</section>
</div>

