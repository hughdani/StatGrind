<html>
<head>
  <title>Question Creator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css" />
</head>
<body>

<div class="jumbotron text-center">
  <p>Question Creator</p> 
</div>
  
<div class="container">
  <form method="post" action="EditAssignment.php" name="form1">
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
        <input onclick='addvar()' type='button' class="btn btn-primary" name="addVar" value="Add"
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
      <input id="question_tags" name="question_tags" type="text" class="form-control" placeholder="Question Tag(s)">
    </div>
    <div class="form-row">
      <button type="button" class="btn btn-danger" onclick="history.back();"> Back </button>
      <button type="submit" class="btn btn-primary" name="submit" value="submit"> Create </button>
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
