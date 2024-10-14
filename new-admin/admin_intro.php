<?php
include("includes/demo_conn.php");
include("includes/header.php");  

?>


    <?php


    $userprofile = $_SESSION['user_name'];

    if($userprofile == true)
    {

    }
    else
    {
        header('location:index.php');
    }
    ?>
  <?php  

    echo '<h1>' ;
    echo "Welcome, ". $_SESSION['fname'] ;
    echo '</h1>' ;
   // echo "Welcome ".$_SESSION['pwd']; ?>
        <table class="table table-success table-bordered table-striped mt-4">
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
            $select_query = $conn->prepare("SELECT * FROM admin_registration WHERE email = :email OR username = :email");
            $select_query->execute(['email' => $email]);
            //$select_query->debugDumpParams();
            //$result=mysqli_query($conn,$select_query);
            //$num_rows=mysqli_num_rows($result);
            //$num_rows = $select_query->fetchColumn();
            $results = $select_query->fetchAll(PDO::FETCH_ASSOC);
            //echo '<pre>',print_r($results),'</pre>';
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
                                <img src="images/<?php echo trim($image_path); ?>" height="100px" width="100px" style="margin-right: 5px;">
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
                $sn++;
                }
            }
            else
            {
                echo "No Result";
            }
            ?> 
            </tbody>
        </table>

    
        
        
        <?php
include("includes/footer.php");