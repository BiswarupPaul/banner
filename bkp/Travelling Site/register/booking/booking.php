<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tour_booking";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn)
{
    die("Connection Error".mysqli_connect_error());
}
else
{
    //echo "Connection Successfull";
}

$name = $_POST['name'];
$age = $_POST['age'];
$destination = $_POST['destination'];
$date = $_POST['date'];
$time = $_POST['time'];
$email = $_POST['email'];
$gender = $_POST['gender'];

$insert_query = "INSERT into tour_book (name, age, destination, date, time, email, gender) values ('$name', $age, '$destination', '$date', '$time', '$email', '$gender')";
//var_dump($insert_query);
$result = mysqli_query($conn, $insert_query);

if($result)
{
    //echo "Insert Successfull";
    header('location:../index.html?insert=success');
}
else
{
    $error = mysqli_error($conn);
    header('location:../index.html?insert=fail&error='.$error);
    //echo "Error".$insert_query."<br>".mysqli_error($conn);
}

mysqli_close($conn);

?>