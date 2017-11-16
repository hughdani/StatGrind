<!-- Page containing all assignments created -->
  
<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<h2>List of Created Assignments</h2>
<?php
$mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');
$result = $mysqli->query('SELECT * FROM assignments');
if ($result->num_rows > 0) {
    echo "<form method='post' action=''>";
    while ($row = $result->fetch_assoc()) {
        $a_id = $row['assignment_id'];
        $a_start = $row['start_date'];
        $a_end = $row['end_date'];
        $a_chk = ($row['visible'] ? "checked" : "");
        // create entry for assignment
        echo "<br> id: $a_id";
        echo "<br> start date: $a_start";
        echo "<br> end date: $a_end";
        echo "<br> <label class='form-check-label'>";
        // set the name and value based on the id, set the check status based on visibility
        echo "<input name='vis-$a_id' type='checkbox' value=$a_id class='chk-vis form-check-input' $a_chk>";
        echo "Visible";
        echo "</label><br>";
    }
    echo "</form>";
} else {
    echo "0 results";
}
$mysqli->close();
?>
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
