<?php
//error_reporting(0);
try
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "booking";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    //echo "Caught";
    //die('Sorry, datbase problem.');
    echo "Error : ".$e->getMessage();
    die();
}

//echo "The rest of the page.";

    /*if (!$conn)
    {
        echo("Connection Error".mysqli_connect_error());
    }
    else
    {
        //echo("Connection Successfull");
    }
*/
?>