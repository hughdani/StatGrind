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
  <form method="post" action="PreviewQuestion.php" name="form1">
    <!-- Question Variables -->
    <div class="form-row">
      <h4>Add Random Variable</h4>
      <!-- <div class="form-row">
        <ul class="list-group" id="varList">
          <li class="list-group-item"> 
          </li>
        </ul>
      </div>
      <div class="col-xs-4">
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="ddlVarTyoe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Type
          <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a>Type</a></li>
            <li role="separator" class="divider"></li>
            <li><a id="selRealVal">Value</a></li>
            <li><a id="selIntVal">Matrix</a></li>
          </ul>
        </div>
      </div>
      <div class="col-xs-1">
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="ddlVarType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Domain
          <span class="caret"></span>
          </button>
          <ul id="dommenu" class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a>Domain</a></li>
            <li role="separator" class="divider"></li>
            <li><a>Integer</a></li>
            <li><a>Real</a></li>
            <li><a>Complex</a></li>
          </ul>
        </div>
      </div> -->
	  <div class="col-xs-2">
	  <label for="sel1">Domain:</label>
		<select class="form-control" id="sel1">
			<option>Integer</option>
			<option>Real</option>
		</select>
	  </div>
      <div class="col-xs-4">
        <!-- <div class="form-row">
          <div class="checkbox">
          <label><input type="checkbox" value="">Randomize Between:</label>
          </div>
        </div> 
        <div class="form-row"> -->
          <div class="col-xs-6">
		  <label for="lowBound">Min:</label>
		  <input class="form-control" id="lowBound" name="lowBound" type="text" value="">
          </div>
          <div class="col-xs-6">
		  <label for="upBound">Max:</label>
          <input class="form-control" id="upBound" name="upBound" type="text" value="">
          </div>
        <!-- </div> -->
      </div>
	  <br>
      <div class="form-row">
        <input onclick='addvar()' type='button' class="btn btn-primary" name="addVar" value="Add"
      </div>
    </div>
	<script>
	var str = "abcdefghijklmnopqrstuvwxyz";
	var i = 0;
	var y = -1;
	
	
	function addvar(){
		if (i == 26) {
			i = 0; y++;
		}
		if (i <= 25 && y < 0) {
			var name = str.charAt(i);
		} else {
			var name = str.charAt(y) + str.charAt(i);
		}
		
		var e = document.getElementById("sel1");
		var vartype = e.options[e.selectedIndex].text;
		
		var minv = document.getElementById("lowBound").value;
		var maxv = document.getElementById("upBound").value;
		if (minv == "") {
			minv = "0";
		}
		if (maxv == "") {
			maxv = "300";
		}
		
		if (vartype == "Real"){
			var qtype = "=random_real(";
		} else {
			var qtype = "=random_int(";
		}
		
		
		
		var text = " $" + name + qtype + minv + "," + maxv + ")";
		var oldtext = document.forms.form1.questionText.value;
		document.forms.form1.questionText.value = oldtext + text;
		
		var oldform = document.forms.form1.questionFormula.value;
		document.forms.form1.questionFormula.value = oldform + " $" + name;
		
		i++;
	}    
	</script>
	
	<br><br>
    <!-- Question Text -->
    <div class="form-row">
      <textarea id="questionText" name="questionText" class="form-control" rows="10" placeholder="Question Text" required></textarea>
      <input type="hidden" name="assignment_id" id="assignment_id" value="<?php if (isset($_POST['assignment_id'])){ echo $_POST['assignment_id']; } else { echo 1; } ?>" />
    </div>
    <!-- Question Formula -->
    <div class="form-row">
      <input id="questionFormula" name="questionFormula" type="text" class="form-control" placeholder="Question Formula">
    </div>
    <!-- Question Tags -->
    <div class="form-row">
      <input id="questionTags" name="questionTags" type="text" class="form-control" placeholder="Question Tag(s)">
    </div>
    <div class="form-row">
      <button type="button" class="btn btn-danger" onclick="history.back();"> Back </button>
      <button type="submit" class="btn btn-primary" name="submit" value="submit"> Create </button>
    </div>
  </form>

      
  <form action="SelectQuestionType.php" method="post">
		  <input type="submit" class="btn btn-default" value="Select Question Type">
  </form>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
