<?php

$servername="localhost";
$username="root";
$password="";
$dbname="book_list";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn)
{
    // Connection Error
    die("Connection Error".mysqli_connect_error());
}
else
{
    // echo "Connection Successful";
}

$title = $_POST['title'];
$author = $_POST['author'];
$text = $_POST['text'];
$description = $_POST['description'];

$insert_query = "INSERT into books (title,author,type,description) VALUES ('$title','$author','$text','$description')";

$result = mysqli_query($conn, $insert_query);

if($result)
{
    //echo "Insert SuccessfulL";
    session_start();
    $_SESSION["create"] = "Book Added Successfully";
    header('location:select.php?insert=success');
}
else
{
    //echo "Insert UnsuccessfulL";
    $error = mysqli_error($conn);
    header('location:select.php?insert=fail&error='.$error);
}

mysqli_close($conn);
?>