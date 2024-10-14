<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beginner";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn)
{
    die("Connection Error".mysqli_connect_error());
}
else
{
    //echo "<b>Connection Successfull</b>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" >

    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap-theme.min.css" >

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" ></script>
 </head>
<body>
    <div class ="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Select Using PHP</h1>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
</body>
</html>