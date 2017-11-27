<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: Forbidden.php");
}

create_head('Multiple Choice');
echo "<body>";

$db = new Database();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Create Multiple Choice Question";

include("NavigationBar.php");</div>
</section>
create_site_header($header_text);
?>
    <script>
        $(document).ready(function(){
            // construct the question to send         
            $("#submit_question").click(function(){              
                var question = $("#mc_question").val() + "<br>";
                var option_counter = 1;
                $('.option').each(function() {
                    question += option_counter + ") " + $(this).val() + "<br>";
                    option_counter++;
                })
                // update post variables to have the correct question and answer
                $("#question_text").val(question);
                $("#question_formula").val($("#correct_opt").val());
            });    
        });
    </script>
</head>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
    <form method="post">
        <div class="form-group">
            <label for="num_options"> Number of Options:</label>
            <input class="form-control" type="number" id="num_options" name="num_options" min="2" required>
            <br />
            <input type="submit" class="btn btn-default" name="new_mc" id="new_mc" value="Create">
            <?php if (isset($_POST['assignment_id'])) : ?>
                <input class="hidden" name="assignment_id" id="assignment_id" value="<?= $_POST["assignment_id"]; ?>">
            <?php endif; ?>
        </div>
    </form>

    <form action="SelectQuestionType.php" method="post">
        <input type="submit" class="btn btn-default" id="cancel" value="Cancel">
        <?php if (isset($_POST['assignment_id'])) : ?>
            <input class="hidden" name="assignment_id" id="assignment_id" value="<?= $_POST["assignment_id"]; ?>">
        <?php endif; ?>
    </form>

    <?php if(isset($_POST["new_mc"])) : ?>
        <?php $num_options = $_POST["num_options"]; ?>

        <form method='post' action="<?php if(isset($_POST['assignment_id'])){ echo 'EditAssignment.php'; } else { echo 'AllCreatedQuestions.php';};?>">
            <div class='form-group'>
            <label for="mc_question"> Question:</label>
            <textarea type="submit" class="form-control" rows="5" name="mc_question" id="mc_question" required></textarea>

                <h3>Options</h3>

                <?php for($i = 1; $i <= $num_options; $i++) : ?>
                    <label for=mc_option<?=$i?>>Option <?=$i?> </label>
                    <input class='form-control option' type='text' id=mc_option<?=$i?> value='' required> 
                    <br />
                <?php endfor; ?>

                <label for="correct_opt">Correct Option Number </label>
                <select class="form-control" id="correct_opt">

                <!-- Select from a set of correct options -->
                <?php for($i = 1; $i <= $num_options; $i++) : ?>
                    <option><?=$i?></option>
                <?php endfor; ?>
            
                <input class="hidden" name="question_text" id="question_text" value="">
                <input class="hidden"name="question_formula" id="question_formula" value="">

                <!-- if making questions on the fly using new assignment -->
                <?php if (isset($_POST['assignment_id'])) : ?>
                    <input class="hidden" name="assignment_id" id="assignment_id" value="<?= $_POST['assignment_id']; ?>">
                <?php endif; ?>


                <br />
                <input type="submit" class="btn btn-default" id="submit_question" value="Submit"> 
            </div>
        </form>    
    <?php endif; ?>
</div>
</section>
</div>

</body>
</html>
