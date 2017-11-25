<title>Edit Question</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<?php
include_once 'Database.php';
$db = new Database();
?>

<?php foreach ($db->query("SELECT * FROM questions") as $q) { ?>
	<form method='post' action='EditQuestion.php'>
	<h5> Question <?= $q['question_id'] ?> </h5>
	<span> (<?= $q['location'] ?>) </span>
	<br>
	<input type='submit' value='Edit'>
	<input type='hidden' name='question_id' value=<?= $q['question_id'] ?> >
	</form>
<?php } ?>

