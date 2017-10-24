<html>
<head>
<title>Question Preview</title>
</head>
<body>
<?php
function saveString($questionInput){ // function that takes in a string and store into a file
  $file_name = "question.txt";
  file_put_contents($file_name, $questionInput);
}

if (isset($_POST['questionText']))
{
	$question_text = $_POST['questionText'];
	saveString($_POST["questionText"]); // saves the string in the textarea into the file
	echo $question_text;
}
?>
</body>
</html>
