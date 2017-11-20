<head>
    <title>U2-create-new-assignment-test</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<p> Here are the question ids of the selected questions. </p>
<p> This list is to be stored in the database as an assignment instance.</p>
<?php
    $assignment = $_POST;

    foreach ($assignment as $question) {
        echo $question, '<br>';
    }

    echo '<br>';

    foreach ($assignment as $key => $value) {
        echo $key, ": ", $value, '<br>';
    }
?>
