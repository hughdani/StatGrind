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

create_head('Assignment Answer');
echo "<body>";

$db = new Database();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = $db->getPageTitle(basename(__FILE__));


include("NavigationBar.php");
create_site_header($header_text);
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
<form method="POST">
    Assignment: 
			<select name="assignment_id" onchange="this.form.submit();">
				<option disabled value="" selected hidden>Select Assignment</option>
				<?php 
				$sql = "SELECT assignment_id, title FROM assignments";
				if ($account_type == 2){
					$sql = $sql . " where end_date < NOW()";
				}
				$result = $db->query($sql);
				while ($row = $result->fetch_assoc()){
				echo "<option value='".$row["assignment_id"]."'> ". $row["title"] . "</option>";
                }
				?>
			</select>

</form>


<?php

if(isset($_POST['assignment_id'])) {
    GetAssignment();
}

create_page_link('Home.php', 'Home');
    ?>
</div>
</section>
</div>
</body>
</html>
