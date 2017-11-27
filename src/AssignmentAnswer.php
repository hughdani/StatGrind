<?php
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}

create_head('Assignment Answer');
?>
<body>
<form method="POST">
    Assignment ID: <input type="text" name="assignment_id"><br>
    <input type="submit" name="submit" value="Search Answer">
</form>


<?php
create_page_link('Home.php', 'Home');

if(isset($_POST['submit'])) {
    GetAssignment();
}
    ?>
</body>
</html>
