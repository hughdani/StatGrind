<div class="container-fluid">
<header class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
      <a class="navbar-brand" href="Home.php"><span class="fa fa-home"></span> StatGrind</a>
    </div>
    <ul class="nav navbar-nav">
    <?php      
	// Generate navigation bar options based on account type
	$sql = "SELECT pages.name, pages.filename FROM permissions LEFT JOIN pages on permissions.page_id = pages.page_id where pages.nav_item = 1 AND permissions.account_type = $account_type";
        foreach ($db->query($sql) as $p) {
	    $pageName = $p['name'];
	    $address = $p['filename']; ?>
            <li><a href="javascript:void(0)" onClick="navLink('<?php echo $address?>','<?php echo $pageName?>')"><?=$pageName;?></a></li>
	<?php        
	} ?>
	  <!--
      <li><a href="NewAssignment.php"><span class="glyphicon glyphicon-plus"></span> New Assignment</a></li>
      <li><a href="CreateQuestion.php"><span class="glyphicon glyphicon-plus"></span> New Question</a></li>
      <li><a href="AssignmentMarkingFeedback.php"><span class="glyphicon glyphicon-check"></span> Marking & Feedback</a></li>
      <li><a href="EditCourses.php"><span class="glyphicon glyphicon-cog"></span> Manage Course</a></li>
      -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="AccountLogin.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
</header>
</div>

<script>
function navLink(address, pagename) {
    var form = document.createElement("form");
    var element1 = document.createElement("input"); 

    form.method = "POST";
    form.action = address;   

    element1.value=pagename;
    element1.name="name";
    form.appendChild(element1);  

    document.body.appendChild(form);

    form.submit();
}
</script>

