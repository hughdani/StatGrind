<?php
require_once 'Database.php';
require_once 'Utils.php';
$db = new Database();

create_head('Edit Assignment');

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
