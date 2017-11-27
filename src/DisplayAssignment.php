<?php
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}

create_head('Display Assignment');
?>
<body>
	<form method="POST">
		Assignment ID: <input type="text" name="assignment_id"><br>
		<input type="submit" name="submit" value="Submit">
	</form>
<?php
create_page_link('Home.php', 'Home');

if(isset($_POST['submit'])) {
    GetAssignment();
}
?>
</body>
</html>
