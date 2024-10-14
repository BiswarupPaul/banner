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

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <title>Book Details</title>
        <style>
            .book-details
            {
                background:#f5f5f5;
                padding: 50px;
            }
        </style>
    </head>
<body>
    <div class="container">
        <header class="d-flex justify-content-between my-4">
            <h1>Book Details</h1>
            <div>
                <a href="select.php" class="btn btn-primary">Back</a>
            </div><br>
        </header>
        <div class="book-details my-4">
            <?php
            $id = $_GET['id'];
            $select_query = "SELECT * from books WHERE id=$id";
            $result=mysqli_query($conn, $select_query);
            $row=mysqli_fetch_assoc($result);
            ?>

            <h2>Title</h2>
            <p><?php echo $row['title']; ?></p>
            <h2>Author</h2>
            <p><?php echo $row['author']; ?></p>
            <h2>Type</h2>
            <p><?php echo $row['type']; ?></p>
            <h2>Description</h2>
            <p><?php echo $row['description']; ?></p>
        </div>
    </div>
</body>
</html>