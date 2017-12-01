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

create_head('Edit Question');
echo "<body>";
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = $db->getPageTitle(basename(__FILE__));

include("NavigationBar.php");
create_site_header($header_text);
?>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">

<form method='post'>

<?php
if (isset($_POST['question_id'])):
	$q_id =  $_POST['question_id'];
	$q = $db->query("SELECT * FROM questions WHERE question_id=$q_id");
	$q = $q->fetch_assoc();
	$q_details = load_question($q['location']);
?>
	<input type='hidden' name='save_path' value='<?= $q['location']; ?>'>
	<input type='hidden' name='q_type' value='<?= $q_details['type']; ?>'>

	<label for='q_text'>Question Text</label>
	<textarea id='q_text' name='question_text'><?= $q_details['question_text']; ?></textarea>
	<br>

	<?php if ($q_details['type'] == 'single'): ?>
		<label for='q_formula'>Question Formula</label>
		<input id = 'q_formula' type='text' name='question_formula' value = '<?= $q_details['question_formula']; ?>'>

	<?php elseif ($q_details['type'] == 'multi'): ?>
		Question is multiple choice, not implemented
	<?php endif; ?>
	</br>
	<input type='submit' name='save_question' value="Save">
<?php elseif(isset($_POST['save_path'])):
		$q_path = $_POST['save_path'];
		$q_text = $_POST['question_text'];
		$q_formula = $_POST['question_formula'];

		if (save_question($q_path, $q_text, $q_formula)):
			echo "Question saved!";
		else:
			echo "Failed to save question!";
		endif;
endif;
?>
</form>
<form method='post' action='AllCreatedQuestions.php'>
<input type='submit' value='Back'>
</form>
</div>
</section>
</div>
