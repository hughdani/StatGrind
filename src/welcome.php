<html>
<body>

    <link rel="stylesheet" href="css/main.css" />
Welcome <?php echo $_POST["name"]; ?>
<br>
Your email address is: <?php echo $_POST["email"]; ?>

<br>
<br>
The post variable: 

<?php
echo $_POST;

echo '<br><br>';

// print values in array
foreach ($_POST as $k => $v) {
   echo 'The key is <b>' . $k . '</b> and the value is <b>' . $v . '</b><br>';
}


echo '<br>';

// Declare function to print array
function printArray($array){
     foreach ($array as $key => $value){
        echo "$key => $value";
	echo "<br>";
        if (is_array($value)){  //If $value is an array, print it as well!
            printArray($value);
        }  
    } 
}

printArray($_POST);

?>

<br>
<br>
Example while loop:
<br>

<?php
$b = 0;

while ($b < 10) {
   echo '$b = ' . $b;
   $b++;
   echo '<br>';
}
?>

<br>
<br>
Example for loop:
<br>

<?php
for ($v = 1; $v <= 10; $v++) {
   echo '$v = ' . $v . '<br>';
}

?>


</body>
</html> 
