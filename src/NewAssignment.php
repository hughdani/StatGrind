<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
  header("Location: error.php?error_status=401");
  exit();
} elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
  header("Location: error.php?error_status=403");
  exit();
}
create_head('New Assignment');
echo "<body>";

$db = new Database();

?>
<head>
<title>Create New Assignment</title>
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
<?php
$user = $_SESSION['user'];
$user_id = $user->getUserId();
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = $db->getPageTitle(basename(__FILE__));

include("NavigationBar.php");
create_site_header($header_text);

$sql = "SELECT courses.course_id, courses.course_name
    FROM courses 
    INNER JOIN teaching_course ON courses.course_id = teaching_course.course_id
    WHERE teaching_course.user_id = $user_id";
$courses = $db->query($sql);
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">

   <form action="EditAssignment.php" method="post">
		<h2>Assignment Title:</h2>
		<input type="text" name="assignment_title" id="assignment_title" placeholder="Assignment Title" required>
       <h2>Start Time</h2>
               <div class="form-group">
                  <div class='input-group date' id='datetimepicker1'>
                     <input id="starttime" name="starttime" type='text' class="form-control" required/>
                     <span class="input-group-addon">
                     <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                  </div>
               </div>
            <script type="text/javascript">
               $(function () {
                   $('#datetimepicker1').datetimepicker();
               });
            </script>
      <h2>End Time</h2>
               <div class="form-group">
                  <div class='input-group date' id='datetimepicker2'>
                     <input id="endtime" name="endtime" type='text' class="form-control" required/>
                     <span class="input-group-addon">
                     <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                  </div>
               </div>
            <script type="text/javascript">
               $(function () {
                   $('#datetimepicker2').datetimepicker();
               });
            </script>
      Course:
      <select name="course_id" required>
      <option disabled value="" selected hidden>Select Course</option>
<?php while ($c = $courses->fetch_assoc()): ?>
      <option value=<?=$c['course_id']?>> <?= $c['course_name'] ?> </option>
<?php endwhile ?>
      </select>
      Add a tag to assignment: <input type="text" name="assignment_tag" id="assignment_tag" placeholder="Assignment Tag">
      <input type="submit" class="btn btn-default" value="Create Assignment">
   </form>
</div>
</section>
</div>
</body>
</html>
