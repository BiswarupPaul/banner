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
<html>
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
        <title>Edit Book</title>
    </head>
    <body>
        <div class="container">
            <div class="books">
                <header class="d-flex justify-content-between my-4">
                    <h1>Edit Book</h1>
                    <div>
                        <a href="select.php" class="btn btn-primary">Back</a>
                    </div><br>
                </header>
                <?php
                $id = $_GET['id'];
                $select_query = "SELECT * from books WHERE id=$id";
                $result=mysqli_query($conn, $select_query);
                $row=mysqli_fetch_assoc($result);
                ?>
                <form action="edit_process.php?id=<?php echo $row['id']; ?>" id="books" method="POST">
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="title" id="name" value="<?php echo $row['title']; ?>" placeholder="Book Title:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="author" id="name" value="<?php echo $row['author']; ?>" placeholder="Author Name:">
                    </div><br>
                    <div class="form-element my-4">
                        <select name="text" class="form-control" value="<?php echo $row['type']; ?>">
                            <option value="">Select Book Type</option>
                            <option value="Adventure" <?php if($row['type']=="Adventure"){ echo "selected"; } ?>>Adventure</option>
                            <option value="Fantasy" <?php if($row['type']=="Fantasy"){ echo "selected"; } ?>>Fantasy</option>
                            <option value="SciFi" <?php if($row['type']=="SciFi"){ echo "selected"; } ?>>SciFi</option>
                            <option value="Horror" <?php if($row['type']=="Horror"){ echo "selected"; } ?>>Horror</option>
                        </select>
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="description" id="name" value="<?php echo $row['description']; ?>" placeholder="Book Description:">
                    </div><br>
                    <div class="form-element">
                        <input type="submit" class="btn btn-success" name="edit" id="submit" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>