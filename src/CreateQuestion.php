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

create_head('Question Creator');
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
  <form method="post" action="<?php if(isset($_POST['assignment_id'])){ echo 'EditAssignment.php'; } else { echo 'AllCreatedQuestions.php';};?>" name="form1">
    <!-- Question Variables -->
    <div class="form-row">
      <h4>Add Random Variable</h4>
	  <div class="col-xs-2">
	  <label for="sel1">Domain:</label>
		<select class="form-control" id="sel1">
			<option>Integer</option>
			<option>Real</option>
		</select>
	  </div>
      <div class="col-xs-4">
          <div class="col-xs-6">
		  <label for="lowBound">Min:</label>
		  <input class="form-control" id="lowBound" name="lowBound" type="text" value="">
          </div>
          <div class="col-xs-6">
		  <label for="upBound">Max:</label>
          <input class="form-control" id="upBound" name="upBound" type="text" value="">
          </div>
      </div>
	  <br>
      <div class="form-row">
        <input onclick='addvar()' type='button' class="btn btn-primary" name="addVar" value="Add">
      </div>
    </div>
	<script>
	// Variable name alphabet.
	var str = "abcdefghijklmnopqrstuvwxyz";
	// Second character index.
	var i = 0;
	// First character index.
	var y = -1;
	
	
	function addvar(){
		// If second character index is on "Z" then reset, and increment first character index.
		if (i == 26) {
			i = 0; y++;
		}
		// If first character index is -1, then only use second character index.
		if (i <= 25 && y < 0) {
			var name = str.charAt(i);
		} else {
		// Else, use first and second chacter indices.
			var name = str.charAt(y) + str.charAt(i);
		}
		
		// Get varable type, real or int.
		var e = document.getElementById("sel1");
		var vartype = e.options[e.selectedIndex].text;
		
		// Get Min and Max range for random number.
		var minv = document.getElementById("lowBound").value;
		var maxv = document.getElementById("upBound").value;
		// Set default Min value if none entered.
		if (minv == "") {
			minv = "0";
		}
		// Set default Max value if none entered.
		if (maxv == "") {
			maxv = "300";
		}
		
		// Build variable type text.
		if (vartype == "Real"){
			var qtype = "=random_real(";
		} else {
		// Default to integer.
			var qtype = "=random_int(";
		}
		
		// Build random variable declaration text.
		var text = " $" + name + qtype + minv + "," + maxv + ")";
		// Append variable text to question text.
		var oldtext = document.forms.form1.question_text.value;
		document.forms.form1.question_text.value = oldtext + text;
		
		// Append variable reference to formula text.
		var oldform = document.forms.form1.question_formula.value;
		document.forms.form1.question_formula.value = oldform + " $" + name;
		
		i++;
	}    
	</script>
	
	<br><br>
    <!-- Question Text -->
    <div class="form-row">
      <textarea id="question_text" name="question_text" class="form-control" rows="10" placeholder="Question Text" required></textarea>
      <input type="hidden" name="assignment_id" id="assignment_id" value="<?php if (isset($_POST['assignment_id'])){ echo $_POST['assignment_id']; } else { echo 1; } ?>" />
    </div>
    <!-- Question Formula -->
    <div class="form-row">
      <input id="question_formula" name="question_formula" type="text" class="form-control" placeholder="Question Formula">
    </div>
    <!-- Question Tags -->
    <div class="form-row">
      <input id="question_tag" name="question_tag" type="text" class="form-control" placeholder="Question Tag" required>
    </div>
    <div class="form-row">
      <button type="button" class="btn btn-danger" onclick="history.back();"> Back </button>
      <button type="submit" class="btn btn-primary" name="submit" value="submit"> Create </button>
    </div>
  </form>
</div>
</section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
