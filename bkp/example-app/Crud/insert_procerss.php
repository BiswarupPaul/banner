<?php
#First we will connect database

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
$name=$_POST['name'];
$phone_number = $_POST['phone_number'];

$insert_query = "INSERT into member (name,phonenumber) values ('$name','$phone_number')";

$result = mysqli_query ($conn,$insert_query);

if($result)
{
    //echo "Insert Success";
    header('location:insert.php?insert=success');
}
else{
    $error=mysqli_error($conn);
    header('location:insert.php?insert=fail&error='.$error);
    //echo "ERROR".$insert_query."<br>".mysqli_error($conn);
}

mysqli_close($conn);


?>