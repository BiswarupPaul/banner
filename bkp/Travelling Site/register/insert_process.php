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

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$age = $_POST['age'];
$date_of_birth = $_POST['date_of_birth'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$gender = $_POST['gender'];

$insert_query = "INSERT into register (first_name, last_name, age, date_birth, email, phone_number, gender) values ('$fname', '$lname', $age, '$date_of_birth', '$email', '$phone_number', '$gender')";
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