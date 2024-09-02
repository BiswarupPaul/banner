<?php
error_reporting(0);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "booking";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn)
    {
        echo("Connection Error".mysqli_connect_error());
    }
    else
    {
        //echo("Connection Successfull");
    }

?>