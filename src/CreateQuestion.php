<html>
<head>
  <title>Question Creator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="jumbotron text-center">
  <p>Question Creator</p> 
</div>
  
<div class="container">
  <form method="post" action="EditAssignmentPage.php">
    <!-- Question Variables -->
    <div class="form-row">
      <h4>Question Variables</h4>
      <div class="form-row">
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
      <div class="col-xs-4">
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="ddlVarTyoe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Domain
          <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a>Domain</a></li>
            <li role="separator" class="divider"></li>
            <li><a>Integer</a></li>
            <li><a>Real</a></li>
            <li><a>Complex</a></li>
          </ul>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="form-row">
          <div class="checkbox">
          <label><input type="checkbox" value="">Randomize Between:</label>
          </div>
        </div>
        <div class="form-row">
          <div class="col-xs-6">
          <input class="form-control" id="lowBound" type="text" value="">
          </div>
          <div class="col-xs-6">
          <input class="form-control" id="upBound" type="text" value="">
          </div>
        </div>
      </div>
      <div class="form-row">
        <button type="button" class="btn btn-primary" name="addVar" value="addVar">Add</button>
      </div>
    </div>
    <!-- Question Text -->
    <div class="form-row">
      <textarea id="questionText" name="questionText" class="form-control" rows="10" placeholder="Question Text" required></textarea>
      <input type="hidden" name="assignment_id" id="assignment_id" value="<?php if (isset($_POST['assignment_id'])){ echo $_POST['assignment_id']; } else { echo 1; } ?>" />
    </div>
    <!-- Question Formula -->
    <div class="form-row">
      <input type="text" class="form-control" placeholder="Question Formula">
    </div>

    <div class="form-row">
      <button type="button" class="btn btn-danger"> Back </button>
      <button type="submit" class="btn btn-primary" name="submit" value="submit"> Create </button>
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
