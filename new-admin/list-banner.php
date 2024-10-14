<?php
include ('includes/header.php');
?>
<?php
    
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


<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Banner List</h1>
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row mb-3">
                                <div class=" col-md-10">
                                    <h6 class="m-0 font-weight-bold text-primary">List</h6>
                                </div>
                                <div class=" col-md-2">
                                    <a href="banner1.php" class="btn btn-primary">Add Banner</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
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
                                        $select_query = $conn->prepare("SELECT * FROM banner ");
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
                                                <th><?php echo $row['title']; ?></th>
                                                <th><?php echo $row['content']; ?></th>
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
                                                <th><?php echo ($row['status']==1)? '<span class="badge bg-warning ">Active</span>':'<span class="badge bg-danger">Deactive</span>'; ?></th>
                                                <th><?php echo $row['created_at']; ?></th>
                                                <th><?php echo $row['updated_at']; ?></th>
                                                <th>
                                                    <!--<a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>-->
                                                    <a href="banner1.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                                    <a href="banner1.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Delete</a>
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


<?php include ('includes/footer.php');
?>