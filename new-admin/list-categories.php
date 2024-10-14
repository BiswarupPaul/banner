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
                    <h1 class="h3 mb-2 text-gray-800">Categories List</h1>
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row mb-3">
                                <div class=" col-md-10">
                                    <h6 class="m-0 font-weight-bold text-primary">List</h6>
                                </div>
                                <div class=" col-md-2">
                                    <a href="add-categories.php" class="btn btn-primary">Add Category</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Category Name</th>
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
                                        $select_query = $conn->prepare("SELECT * FROM categories ");
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
                                                <th><?php echo $row['cat_name']; ?></th>
                                                <th>
                                                    <!--<a href="view.php?id=<?php echo $row['cat_id']; ?>" class="btn btn-primary">Read More</a>-->
                                                    <a href="add-categories.php?id=<?php echo $row['cat_id']; ?>" class="btn btn-primary">Edit</a>
                                                    <a href="add-categories.php?id=<?php echo $row['cat_id']; ?>" class="btn btn-primary">Delete</a>
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