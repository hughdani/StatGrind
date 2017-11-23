<title>Edit Question</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<h1>Edit Question</h1>
<form method='post'>

<?php
include_once 'database.php';
include_once 'filemanager.php';
$db = new database();
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
