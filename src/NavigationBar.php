<header  class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"><span class="fa fa-home"></span> StatGrind</a>
    </div>
    <ul class="nav navbar-nav">
    <?php      
        foreach ($db->query("SELECT name, filename FROM pages WHERE home_item=1") as $p) {
            echo "<li>";
            create_page_link($p['filename'], $p['name']);
            echo "</li>";
        }
    ?>
	  <!--
      <li><a href="NewAssignment.php"><span class="glyphicon glyphicon-plus"></span> New Assignment</a></li>
      <li><a href="CreateQuestion.php"><span class="glyphicon glyphicon-plus"></span> New Question</a></li>
      <li><a href="AssignmentMarkingFeedback.php"><span class="glyphicon glyphicon-check"></span> Marking & Feedback</a></li>
      <li><a href="EditCourses.php"><span class="glyphicon glyphicon-cog"></span> Manage Course</a></li>
      -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="AccountLogin.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="AccountLogin.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</header >



