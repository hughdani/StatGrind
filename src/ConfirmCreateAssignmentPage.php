<!-- Page for professor after creating an assignment -->

<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php 
    echo $_POST["assignment_id"] . " successfully added.";
?>

<p>What would you like to do next?</p>
<!-- Quick path to get back to creating new assignments. -->
<form action="NewAssignmentPage.php" method="post">
    <input type="submit" class="btn btn-default" value="Create New Assignment">
</form>

<!-- Quick path to view all created assignments. -->
<form action="AllCreatedAssignmentsPage.php" method="post">
    <input type="submit" class="btn btn-default" value="View All Assignments">
</form>

