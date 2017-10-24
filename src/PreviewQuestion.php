<html>
<head>
<title>Question Preview</title>
</head>
<body>
<?php
if (isset($_POST['questionText']))
{
		$question_text = $_POST['questionText'];
}
echo $question_text;
?>
</body>
</html>
