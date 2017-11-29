<?php
    require_once 'Database.php';
    require_once 'User.php';
    require_once 'Utils.php';
    $db = new Database();

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

create_head('List of Created Assignments');

$user = $_SESSION['user'];
$user_id = $user->getUserId();
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "All Created Assignments";


include("NavigationBar.php");
create_site_header($header_text);

$sql = "SELECT assignment_id, title, start_date, end_date, visible ";
$sql = $sql . "FROM assignments INNER JOIN teaching_course ON assignments.course_id = teaching_course.course_id ";
$sql = $sql . "WHERE teaching_course.user_id = $user_id";
$assignments = $db->query($sql);
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
<?php if ($assignments->num_rows > 0): ?>
    <?php while ($a = $assignments->fetch_assoc()): ?>
        <form method='post' action=''>
            <h2><?= $a['title']; ?></h2>
            <div class="row">
                Start Date: <?= $a['start_date']; ?>
            </div>
            <div class="row">
                End Date: <?= $a['end_date']; ?>
            </div>
            <input name='vis-$a_id' id='a-<?= $a['assignment_id'];?>' type='checkbox' value=<?= $a['assignment_id'] ?> class='chk-vis form-check-input' <?= ($a['visible']) ? 'checked' : '' ?> >
            <label for='a-<?= $a['assignment_id'];?>'>Visible</label><br>
        </form>
    <?php endwhile ?>
<?php else: ?>
    <?= "No assignments available" ?>
<?php endif ?>

<?php
create_page_link("NewAssignment.php", "New Assignment");
create_page_link("Home.php", "Home");
?>
</div>
</section>
</div>

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
