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
        <title>Book List</title>
    </head>
    <body>
        <div class="container">
            <header class="d-flex justify-content-between my-4">
                <h1>Book List</h1>
                <div>
                    <a href="index.html" class="btn btn-primary">Add new Book</a>
                </div><br>
            </header>
            <?php
            session_start();
            if(isset($_SESSION["create"]))
            {
                ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION["create"];
                    unset($_SESSION["create"]);
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if(isset($_SESSION["edit"]))
            {
                ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION["edit"];
                    unset($_SESSION["edit"]);
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if(isset($_SESSION["delete"]))
            {
                ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION["delete"];
                    unset($_SESSION["delete"]);
                    ?>
                </div>
                <?php
            }
            ?>
            <table class="table table-bordered">
                <thread>
                    <tr>
                        <th>SN</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Type</th>
                        
                        <th colspan="3">Action</th>
                    </tr> 
                </thread> 
                <tbody>
                <?php

                $select_query="SELECT * from books";
                $result=mysqli_query($conn,$select_query);
                $num_rows=mysqli_num_rows($result);
                if($num_rows > 0)
                {
                    $sn=1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                        ?>
                        <tr>
                            <th><?php echo $sn ?></th>
                            <th><?php echo $row['title']; ?></th>
                            <th><?php echo $row['author']; ?></th>
                            <th><?php echo $row['type']; ?></th>
                            
                            <th>
                                <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Delete</a>
                            </th>
                        </tr>
                    <?php
                    $sn=$sn+1;
                    }
                }
                else
                {
                    echo "No Result";
                }
                ?> 
                </tbody>
            </table>
        </div>        
    </body>
</html>