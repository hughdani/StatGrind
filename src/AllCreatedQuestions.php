<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';


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

create_head('All Created Questions');
echo "<body>";

$db = new Database();
$mysqli = $db->getconn();
$user = $_SESSION['user'];
$user_id = $user->getUserId();
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = $db->getPageTitle(basename(__FILE__));


include("NavigationBar.php");
create_site_header($header_text);

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
	$qanda = $_POST['question_text'] . "<br> FORMULA: " . $_POST['question_formula'];

	// Save question to file.
	$location = $dir . $file_name;
	file_put_contents($location, $qanda); // saves the string in the textarea into the file

	// Insert question into question table
    $assignment_id = $_POST['assignment_id'];
    $tag = $_POST['question_tag'];
	$sql = "INSERT INTO questions (location, creator_id, tag) VALUES ('$location', $user_id, '$tag')";
	$mysqli->query($sql);
}




?>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
<form method='post'>
<h4> Question Tag </h4>
<input type='text' name='tag'>
<br>
<input type='submit' value='Filter'>
</form>
<?php
$user = $_SESSION['user'];
$user_id = $user->getUserId();
$sql = "SELECT DISTINCT question_id, location, tag
    FROM questions
    WHERE creator_id = $user_id";

if (isset ($_POST['tag'])) {
    $tag = $_POST['tag'];
    $sql = $sql . " AND (questions.tag LIKE '%$tag%' OR question_id = '$tag')";
}
$questions = $db->query($sql);
?>

<?php if ($questions->num_rows > 0): ?>
    <?php while ($q = $questions->fetch_assoc()): ?>
        <form method='post' action='EditQuestion.php'>
        <h3> Question <?= $q['question_id'] ?> </h6>

        <span> Tag: <?= $q['tag'] ?> </span>
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
</div>
</section>
</div>
