<!-- Page containing all assignments created -->
  
<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<h2>List of Created Assignments</h2>
<?php

require_once 'Database.php';
$db = new database();
$mysqli = $db->getconn();

?>

<?php foreach ($db->query("SELECT * FROM assignments") as $a) { ?>
    <form method='post' action=''>
	<?php $assignment_title = $db->getAssignmentTitle($a['assignment_id']); ?>
	<br> <strong><?= $assignment_title; ?> </strong>
    	<br> id: <?= $a['assignment_id']; ?>
        <br> start date: <?= $a['start_date']; ?>
        <br> end date: <?= $a['end_date']; ?>
        <br> <label class='form-check-label'>
	<input name='vis-$a_id' type='checkbox' value=$a_id class='chk-vis form-check-input' <?= ($a['visible']) ? 'checked' : '' ?> >
        Visible
        </label><br>
    </form>
<?php } ?>
<!-- Quick path to get back to creating new assignments. -->
<form action="NewAssignmentPage.php" method="post">
    <input type="submit" class="btn btn-default" value="Create New Assignment">
</form>
<script>
$(document).ready(function() {
  // event for visibility checkboxes
  $('.chk-vis').change(function () {
    // get info about the checkbox's assignment
    var a_id = $(this).val();
    var a_vis = $(this).is(':checked') ? 1 : 0;
    var a_data = {'f_set_visibility': 'true', 'a_id': a_id, 'a_vis': a_vis};

    // send info to server
    $.ajax({
        url:"Ajax.php",
        type: "post",
        dataType: 'json',
        data: a_data,
        success: function(data) { console.log(data); },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        }
    });
  });
});
</script>
