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
			<form action="EditAssignmentPage.php" method="post">
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
        <!-- List of questions will be pulled from database. Dummy values used.
        <form action="NewAssignmentResult.php" method="post">
            <div class="checkbox">
                <label><input type="checkbox" value="question_id1" name="Question 1">1+1</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="question_id2" name="Question 2">2+2</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="question_id3" name="Question 3">3+3</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="question_id4" name="Question 4">4+4</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="question_id5" name="Question 5">5+5</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="question_id6" name="Question 6">6+6</label>
            </div>

            <input type="submit" value="Create Assignment">
        </form> -->

    </div>
    <!--
    <br>
    <br>
    <img src="https://hackdesign.imgix.net/lessons/week0.png?ixlib=rails-2.1.4&dpr=2&w=280&fm=jpeg&fit=max&auto=format&alt=A%20hot%20air%20balloon%20on%20a%20sunny%20day&s=5f23059913f937be1a71003c993cf4d1" style="width:245px; height:193px;">
    <br>
    <br>

    <form action="welcome.php" method="post">
      Name: <input type="text" name="name"><br>
      E-mail: <input type="text" name="email"><br>
      <input type="submit">
    </form>

    <form action="testing.php" method="post">
      Name: <input type="text" name="name"><br>
      E-mail: <input type="text" name="email"><br>
      <select name="samplelist" >
          <option value="op1">a</option>
          <option value="op2">b</option>
          <option value="op3">c</option>
          <option value="op4">d</option>
      </select>

      <input type="submit" value="To testing.php">
    </form>
    -->

</body>

</html>
