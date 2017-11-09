<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <?php echo "<p>Hello World</p>"; ?>

    <br>
    <br>
    <img src="https://hackdesign.imgix.net/lessons/week0.png?ixlib=rails-2.1.4&dpr=2&w=280&fm=jpeg&fit=max&auto=format&alt=A%20hot%20air%20balloon%20on%20a%20sunny%20day&s=5f23059913f937be1a71003c993cf4d1" style="width:245px; height:193px;">
    <br>
    <br>

    <form action="AccountLogin.php" method="post">
      <input type="submit" value ="Log In">
    </form>

    <form action="CreateAccount.php" method="post">
      <input type="submit" value ="Create Account">
    </form>

    <form action="NewAssignmentPage.php" method="post">
      <input type="submit" value ="Create a New Assignment">
    </form>

    <form action="CreateQuestion.php" method="post">
      <input type="submit" value ="Create a New Question">
    </form>

    <form action="AssignmentOverview.php" method="post">
      <input type="submit" value ="Assignment Overview">
    </form>

    <form action="WriteAssignment.php" method="post">
      <input type="text" name="assignment_id" id="assignment_id" placeholder="Assignment #">
      <input type="submit" value ="Write Assignment">
>>>>>>> merge-test
    </form>

  </body>
</html>
