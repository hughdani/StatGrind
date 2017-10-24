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
  <form method="post" action="PreviewQuestion.php">
    <div class="form-row">

      <div class="col-sm-12">
        <h5>Question Variables</h5>
        <div class="form-group">
          <div class="form-row">
            <button type="button" class="btn btn-sm btn-primary">New Integer</button>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <button type="button" class="btn btn-sm btn-primary">New Matrix</button> 
            <input type="text"> x <input type="text">
          </div>
        </div>
        <ul class="list-group" id="varList">
          <li class="list-group-item"> 
            x = 5
            <div class="form-group pull-right" role="group" aria-label="Basic example">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="">
                Randomize
              </label>
              <button type="button" class="btn btn-xs btn-warning">Change</button>
              <button type="button" class="btn btn-xs btn-danger">Remove</button>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="form-row">
      <div class="col-sm-6">
        <h5>Question Formula</h5>
        <input class="form-control" type="text" placeholder="Question Formula"</input>
        <ol id="varList">
        </ol>
      </div>

      <div class="col-sm-6">
        <h5>Question Text</h5>
        <textarea id="questionText" name="questionText" class="form-control" rows="10" placeholder="Question Text" required></textarea>
      </div>
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
 <?php
 function saveString($questionInput){ // function that takes in a string and store into a file
  $file_name = "question.txt";
  file_put_contents($file_name, $questionInput);
 }
 if(isset($_POST["create"])){
  saveString($_POST["questionText"]); // saves the string in the textarea into the file
 }
  
   ?> 
