<?php
ob_start();
include('includes/header.php');
include('includes/demo_conn.php');

// Handle delete requests
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['cat_id'] ?? null;

    if ($id) {
        $delete_query = $conn->prepare("DELETE FROM categories WHERE cat_id = :id");
        $result = $delete_query->execute(['id' => $id]);
        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Category Deleted Successfully";
            header('location:list-categories.php?delete=success');
            exit();
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            $error = $conn->errorInfo();
            header('location:list-categories.php?delete=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $cat_name = $_POST['cat_name'] ?? '';
    $id = $_POST['cat_id'] ?? null;

    if ($action == 'publish') {
        $data = [
            'cat_name' => $cat_name
        ];
        $inserts_query = $conn->prepare("INSERT INTO categories (cat_name) VALUES (:cat_name)");
        $result = $inserts_query->execute($data);
        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Category Added Successfully";
            header('location:list-categories.php?insert=success');
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            //$error = mysqli_error($conn);
            $error = $conn->errorInfo();
            header('location:list-categories.php?insert=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
        //echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {
        $data = [
            'cat_name' => $cat_name,
            'cat_id' => $id
        ];
        $update_query = $conn->prepare("UPDATE categories SET cat_name = :cat_name WHERE cat_id = :cat_id");
        $result = $update_query->execute($data);
        ?>
        <div class="alert alert-success">
            <?php
            if($result)
            {
                echo("Update Successfully");
            }
            else
            {
                echo("Update Unsuccessfully");
            }
            ?>
        </div>
        <?php
        //echo $result ? "Update Successful" : "Update Unsuccessful";
    }
}

$id = $_GET['id'] ?? null;

if ($id) {
    $select_query = $conn->prepare("SELECT * FROM categories WHERE cat_id = :id");
    $select_query->execute(['id' => $id]);
    $row = $select_query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $cat_name = htmlspecialchars($row['cat_name']);
    } else {
        echo "<p>Category not found.</p>";
        exit();
    }
}
?>

<!-- Begin Category Content -->
<div class="container-fluid">

<!-- Category Heading -->
<h1 class="h3 mb-2 text-gray-800">Categories</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Category</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="main">
                <div class="category">
                    <form id="add-category" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <!-- Category Name -->
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="category" class="form-label">Category</label>
                                <input class="form-control" name="cat_name" type="text" id="category" placeholder="Category Name" value="<?= htmlspecialchars($cat_name ?? '') ?>">
                            </div>

                            <!-- Form Actions -->
                            <input type="hidden" name="action" value="<?= $id ? 'update' : 'publish' ?>">
                            <?php if ($id): ?>
                                <input type="hidden" name="cat_id" value="<?= htmlspecialchars($id) ?>">
                            <?php endif; ?>
                            <div class="mt-3">
                                <button type="submit" id="btn" class="btn btn-primary">Save</button>
                            </div>
                    </form>
                    <!-- Delete Category Button -->
                    <?php if ($id): ?>
                        <div class="mt-3">
                            <a href="?action=delete&cat_id=<?= urlencode($id) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">
                                Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>


<script>
    $(document).ready(function() {
        // Initialize form validation
        $("#add-category").validate({
            rules: {
                cat_name: {
                    required: true,
                    lettersonly: true,
                    nowhitespace: true,
                    //minlength: 10
                }
            },
            messages :{
                cat_name : {
                    required : '<br>Enter the Category Name'
                }
            },
            submitHandler: function(form) {
                // some other code
                // maybe disabling submit button
                // then:
                form.submit();
            }
        });
        // Restrict input to letters for category field
        $("#category").on('input', function() {
            var expression = /[^a-zA-Z]/g;
            if ($(this).val().match(expression)) {
                $(this).val($(this).val().replace(expression, ""));
            }
        });
    });
</script>

<?php
include('includes/footer.php');
?>
