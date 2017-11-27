<html>
<head>
    <title>U2-create-new-assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/transition.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/collapse.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/moment.min.js"></script>
        <script src="js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<body>
<?php
// Determine how many rows exist in question table (for assignment_id).
$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
$result = $mysqli->query("SELECT assignment_id FROM assignments ORDER by assignment_id DESC");
$prev_assignment = $result->fetch_row();
$assignment_id = $prev_assignment[0] + 1;
$mysqli->close();
?>
    <div class="container-fluid">

        <div class="jumbotron">
            <h1>Create Assignment <?php echo $assignment_id; ?></h1>
        </div>

        <h2>Start Time</h2>
			<form action="EditAssignment.php" method="post">
                <div class="container">
					<div class="row">
						<div class='col-sm-6'>
							<div class="form-group">
								<div class='input-group date' id='datetimepicker1'>
									<input id="starttime" name="starttime" type='text' class="form-control" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<script type="text/javascript">
						$(function () {
							$('#datetimepicker1').datetimepicker();
						});
						</script>
					</div>
				</div>

                <h2>End Time</h2>
                <div class="container">
					<div class="row">
						<div class='col-sm-6'>
							<div class="form-group">
								<div class='input-group date' id='datetimepicker2'>
									<input id="endtime" name="endtime" type='text' class="form-control" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<script type="text/javascript">
						$(function () {
							$('#datetimepicker2').datetimepicker();
						});
						</script>
					</div>
				</div>
				<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
				Add tag(s) to assignment: <input type="text" name="assignment_tag" id="assignment_tag" placeholder="Assignment Tags">
				<input type="submit" class="btn btn-default" value="Create Assignment">
			</form>
    </div>
</body>

</html>
