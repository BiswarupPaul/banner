<?php
include("demo_conn.php");
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
        header('location:demo_login.php');
    }
    ?>
    <body>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Image</th>
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
            //$select_query = $conn->prepare("SELECT * from registration WHERE email='$email' OR username='$email'");
            $select_query = $conn->prepare("SELECT * FROM registration WHERE email = :email OR username = :email");
            $select_query->execute(['email' => $email]);
            //$select_query->debugDumpParams();
            //$result=mysqli_query($conn,$select_query);
            //$num_rows=mysqli_num_rows($result);
            //$num_rows = $select_query->fetchColumn();
            $results = $select_query->fetchAll(PDO::FETCH_ASSOC);
            echo '<pre>',print_r($results),'</pre>';
            $num_rows = count($results);
            if($num_rows > 0)   
            {
                $sn=1;
                //while($row = mysqli_fetch_assoc($result))
                //while($row = $select_query->fetch())
                foreach ($results as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $sn; ?></td>
                        <!--<th><img src= "images/<?php echo $row['image']; ?>" height='100px' width='100px'></th>-->
                        <?php
                        // Assuming $row['image'] contains a comma-separated string of image filenames
                        $image_paths = explode(',', $row['image']);
                        ?>
                        <th>
                            <?php foreach ($image_paths as $image_path): ?>
                                <img src="../../../banner/login-register/admin/images/<?php echo trim($image_path); ?>" height="100px" width="100px" style="margin-right: 5px;">
                            <?php endforeach; ?>
                        </th>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><?php echo $row['date_of_birth']; ?></td>
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
        
        <a href="demo_logout.php"><input type="submit" name="" value="LogOut" style="background: blue; color: white; height: 35px; width: 100px; margin-top: 20px; font-size: 18px; border: 0; border-radius: 5px; cursor: pointer;"></a>
    </body>
</html>

