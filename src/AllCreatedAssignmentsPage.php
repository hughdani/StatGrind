<!-- Page containing all assignments created -->

<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<h2>List of Created Assignments</h2>
<?php
    $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
    $result = $mysqli->query("SELECT * FROM assignments");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_row()) {
            echo "<br> id: ". $row["assignment_id"]. "--start date: ". $row["start_date"]. " -- due date:". $row["due_date"] "<br>";
        }
    } else {
        echo "0 results"
    }
    $mysqli->close();
?>

<!-- Quick path to get back to creating new assignments. -->
<form action="NewAssignmentPage.php" method="post">
    <input type="submit" class="btn btn-default" value="Create New Assignment">
</form>