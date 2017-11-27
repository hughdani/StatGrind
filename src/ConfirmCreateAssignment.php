<!-- Page for professor after creating an assignment -->

<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<?php 

include 'Database.php';
$db = new Database();

    echo $db->getAssignmentTitle($_POST["assignment_id"]) . " successfully added.";
?>

<p>What would you like to do next?</p>
<!-- Quick path to get back to creating new assignments. -->
<form action="NewAssignment.php" method="post">
    <input type="submit" class="btn btn-default" value="Create New Assignment">
</form>

<!-- Quick path to view all created assignments. -->
<form action="AllCreatedAssignments.php" method="post">
    <input type="submit" class="btn btn-default" value="View All Assignments">
</form>

