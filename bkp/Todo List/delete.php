<?php

$servername="localhost";
$username="root";
$password="";
$dbname="book_list";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn)
{
    // Connection Error
    die("Connection Error".mysqli_connect_error());
}
else
{
    // echo "Connection Successful";
}

$id = $_GET['id'];
$delete_query="DELETE from books WHERE id=$id";
$result = mysqli_query($conn,$delete_query);

if($result)
{
    session_start();
    $_SESSION["delete"] = "Book Deleted Successfully";
    header('location:select.php?delete=success');
}
else
{
    header('location:select.php?delete=fail');
}

?>