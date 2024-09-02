<?php
include("db_conn.php");
session_start();
echo "Welcome ".$_SESSION['user_name'];
echo "Welcome ".$_SESSION['pwd'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> Index </title>
    </head>
    <?php
    $userprofile = $_SESSION['user_name'];

    if($userprofile == true)
    {

    }
    else
    {
        header('location:login.php');
    }
    ?>
    <body>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>First Name</th>
                    <th>Second Name</th>
                    <th>Age</th>
                    <th>Date Of Birth</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Phone Number</th>
                    <th>Gender</th>
                    <th>Password</th>
                        
                </tr> 
            </thead> 
            <tbody>
            <?php
            
            $email=$_SESSION['user_name'];
            $select_query="SELECT * from registration WHERE email='$email' OR username='$email'";
            $result=mysqli_query($conn,$select_query);
            $num_rows=mysqli_num_rows($result);
            if($num_rows > 0)
            {
                $sn=1;
                while($row = mysqli_fetch_assoc($result))
                {
                    ?>
                    <tr>
                        <td><?php echo $sn; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><?php echo $row['date_of_birtd']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['phone_number']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['password']; ?></td>   
                        
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

        <h1> Welcome </h1>
        
        <a href="logout.php"><input type="submit" name="" value="LogOut" style="background: blue; color: white; height: 35px; width: 100px; margin-top: 20px; font-size: 18px; border: 0; border-radius: 5px; cursor: pointer;"></a>
    </body>
</html>

