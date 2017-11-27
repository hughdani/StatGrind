<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';
$db = new Database();

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: Forbidden.php");
}

$user = $_SESSION['user'];
$user_id = $user->getUserId();

create_head('New Assignment');
$sql = "SELECT courses.course_id, courses.course_name
    FROM courses 
    INNER JOIN teaching_course ON courses.course_id = teaching_course.course_id
    WHERE teaching_course.user_id = $user_id";
$courses = $db->query($sql);
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
      Course:
      <select name="select_course">
      <option disabled value="" selected hidden>Select Course</option>
<?php while ($c = $courses->fetch_assoc()): ?>
      <option value=<?=$c['course_id']?>> <?= $c['course_name'] ?> </option>
<?php endwhile ?>
      </select>
      <input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
      Add a tag to assignment: <input type="text" name="assignment_tag" id="assignment_tag" placeholder="Assignment Tag">
      <input type="submit" class="btn btn-default" value="Create Assignment">
   </form>
</div>
</body>
