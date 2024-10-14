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

$id = $_GET['id'];

$title = $_POST['title'];
$author = $_POST['author'];
$text = $_POST['text'];
$description = $_POST['description'];

$update_query = "UPDATE books SET title = '$title', author = '$author', type = '$text', description = '$description' WHERE id=$id";

$result = mysqli_query($conn, $update_query);

if($result)
{
    session_start();
    $_SESSION["edit"] = "Book Updated Successfully";
    header('location:select.php?update=success?&id='.$id);
}
else
{
    
    header('location:select.php?update=fail?&id='.$id);
}

?>