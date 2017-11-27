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
    header("Location: Forbidden.php");
} elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
    header("Location: Forbidden.php");
}

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

<?php 

// Save new question to questions table
if (isset($_POST['question_text']))
{

	$dir = 'questions';

 	// create new directory with 744 permissions if it does not exist yet
 	// owner will be the user/group the PHP script is run under
 	if ( !file_exists($dir) ) {
     		$oldmask = umask(0);
     		mkdir ($dir, 0744);
 	}

	// Increment question number for file name.
	$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
	$file_name = "/question" . (iterator_count($fi) + 1) . ".txt";

	// Append answer to question.
	$qanda = $_POST['question_text'] . "\n\n\n\n ANSWER: " . $_POST['question_formula'];

	// Save question to file.
	$location = $dir . $file_name;
	file_put_contents($location, $qanda); // saves the string in the textarea into the file

	// Insert question into question table
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO questions (location) VALUES ('$location')";
	$mysqli->query($sql);

	$new_question_id = $mysqli->insert_id;

	$sql = "INSERT INTO in_assignment (assignment_id, question_id) VALUES ($assignment_id, $new_question_id)";
	$mysqli->query($sql);
}

// if question was selected, save that question
if (isset($_POST['question_id']))
{
	// Insert question into question table
	$question_id = $_POST['question_id'];
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO in_assignment (assignment_id, question_id) VALUES ($assignment_id, $question_id)";
	$mysqli->query($sql);
	
}
?>