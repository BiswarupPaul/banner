
<?php
include ('includes/header.php');
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User Registration</h6>
                        </div>
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
                        <div class="card-body">
                            <div class="table-responsive datatable ">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Image</th>
                                            <th>FirstName</th>
                                            <th>LastName</th>
                                            <th>Email</th>
                                            <th>UserName</th>
                                            <th>Phone Number</th>
                                            <th colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <!--<tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Salary</th>
                                            
                                        </tr>
                                    </tfoot>-->
                                    <tbody>
                                        <?php
                                        include("includes/demo_conn.php");
                                        //$select_query="SELECT * from registration";
                                        $select_query = $conn->prepare("SELECT * FROM registration ");
                                        $select_query->execute();
                                        //$select_query->execute(['email' => $email]);
                                        //$result=mysqli_query($conn,$select_query);
                                        $result = $select_query->fetchAll(PDO::FETCH_ASSOC);
                                        $num_rows=count($result);
                                        if($num_rows > 0)
                                        {
                                            $sn=1;
                                            //while($row = mysqli_fetch_assoc($result))
                                            foreach ($result as $row)
                                            {
                                                ?>
                                                <tr>
                                                <th><?php echo $sn; ?></th>

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
                                                <th><?php echo $row['fname']; ?></th>
                                                <th><?php echo $row['lname']; ?></th>
                                                <th><?php echo $row['email']; ?></th>
                                                <th><?php echo $row['username']; ?></th>
                                                <th><?php echo $row['phone_number']; ?></th>
                                                
                                                <th>
                                                    <!--<a href="view.php?id=<?php echo $row['R_id']; ?>" class="btn btn-primary">Read More</a>-->
                                                    <a href="edit.php?id=<?php echo $row['R_id']; ?>" class="btn btn-primary">Edit</a>
                                                    <a href="delete.php?id=<?php echo $row['R_id']; ?>" class="btn btn-primary">Delete</a>
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
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

<?php include ('includes/footer.php');
?>