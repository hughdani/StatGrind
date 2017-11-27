<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';
$db = new Database();

/*if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: error.php?error_status=401");
} elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
    header("Location: error.php?error_status=403");
}*/
include(permissions.php);

create_head('All Created Questions');
?>
<form method='post'>
<h4> Question Tag </h4>
<input type='text' name='tag'>
<br>
<input type='submit' value='Filter'>
</form>
<?php
$user = $_SESSION['user'];
$user_id = $user->getUserId();
$sql = "SELECT questions.question_id, questions.location, questions.tag, questions.type
    FROM questions
    INNER JOIN in_assignment ON questions.question_id = in_assignment.question_id
    INNER JOIN assignments ON in_assignment.assignment_id = assignments.assignment_id
    INNER JOIN teaching_course ON assignments.course_id = teaching_course.course_id
    WHERE teaching_course.user_id = $user_id";

if (isset ($_POST['tag'])) {
    $tag = $_POST['tag'];
    $sql = $sql . " AND questions.tag = '$tag'";
}
$questions = $db->query($sql);
?>

<?php if ($questions->num_rows > 0): ?>
    <?php while ($q = $questions->fetch_assoc()): ?>
        <form method='post' action='EditQuestion.php'>
        <h3> Question <?= $q['question_id'] ?> </h6>

        <span> (<?= $q['location'] ?>) </span>
        <br>
        <input type='submit' value='Edit'>
        <input type='hidden' name='question_id' value=<?= $q['question_id'] ?> >
        </form>
    <?php endwhile ?>
<?php else: ?>
    <?= "No questions available" ?>
<?php endif ?>

<?php 
create_page_link("Home.php", "Home");
?>
