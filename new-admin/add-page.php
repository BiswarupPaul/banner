<?php
ob_start();
include('includes/header.php');
include('includes/demo_conn.php');

// Define target directory
$target_dir = __DIR__ . '/images/';

// Slug generation function
function generateSlug($conn,$title, $id = null) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    
    // If there's an ID, append it to the slug
    // if ($id) {
    //     $slug .= '-' . $id;
    // }
    $res = $conn->prepare("SELECT slug FROM add_page WHERE slug = :slug");
    $res->execute(['slug' => $slug]);
    $row = $res->fetch(PDO::FETCH_ASSOC);
    if($row)
    {
        $res = $conn->prepare("SELECT max(id) as id FROM add_page");
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        $id++;
        $slug=$slug.'-'.$id;
    }
    return $slug;
}

// Handle delete requests
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        $select_query = $conn->prepare("SELECT image FROM add_page WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $images = explode(', ', $row['image']);
            foreach ($images as $image) {
                $file_path = $target_dir . $image;
                if (file_exists($file_path)) {
                    unlink($file_path); // Delete the file
                }
            }
        }

        $delete_query = $conn->prepare("DELETE FROM add_page WHERE id = :id");
        $result = $delete_query->execute(['id' => $id]);

        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Page Deleted Successfully";
            header('location:all-page.php?delete=success');
            exit();
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            $error = $conn->errorInfo();
            header('location:all-page.php?delete=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $id = $_POST['id'] ?? null;

    // Generate the slug
    //$a=$conn->$prepare("SELECT slug FROM add_page WHERE id = :id");
    $slug = generateSlug($conn, $title);
    $new_images = []; // Initialize this to store multiple images
    $existing_images = ''; // Initialize this to avoid undefined variable warning
    $new_image_list = '';

    //$uploaded_files = [];
    if (!empty($_FILES["uploadfile"]["name"][0])) {
        foreach ($_FILES["uploadfile"]["name"] as $key => $val) {
            if ($_FILES['uploadfile']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . basename($val);
                $target_file = $target_dir . $file;
                
                if (move_uploaded_file($_FILES['uploadfile']['tmp_name'][$key], $target_file)) {
                    $new_images[] = $file;
                } else {
                    echo "Error uploading file " . htmlspecialchars($val) . ".<br>";
                }
            } else {
                echo "Error code " . $_FILES['uploadfile']['error'][$key] . " for file " . htmlspecialchars($val) . ".<br>";
            }
        }
        $new_image_list = implode(', ', $new_images); // Save as comma-separated string
    }

    // Determine the image path
    //$image_path = $uploaded_files[0] ?? '';

    if ($action == 'publish') {
        $data = [
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'image' => $new_image_list
        ];
        $inserts_query = $conn->prepare("INSERT INTO add_page (title, content, slug, image) VALUES (:title, :content, :slug, :image)");
        $result = $inserts_query->execute($data);

        if($result)
        {
            //echo "Insert Successfull";
            session_start();
            $_SESSION["create"] = "Page Added Successfully";
            header('location:all-page.php?insert=success');
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            //$error = mysqli_error($conn);
            $error = $conn->errorInfo();
            header('location:all-page.php?insert=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }

        //echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {

        //$slug = generateSlug($title, $id);

        // Fetch existing image if any
        if (!$new_images) {
            $select_query = $conn->prepare("SELECT image FROM add_page WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_images = $row['image']; // Get existing images
            }
        } else {
            // Remove existing images if new images are uploaded
            $select_query = $conn->prepare("SELECT image FROM add_page WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_images = $row['image'];
                $image_files = explode(', ', $existing_images);
                foreach ($image_files as $image_file) {
                    $existing_image_path = $target_dir . $image_file;
                    // Check if it's a file and then delete
                    if (file_exists($existing_image_path) && !is_dir($existing_image_path)) {
                        unlink($existing_image_path); // Delete the old image file
                    }
                }
            }
        }

        $data = [
            'title' => $title,
            'image' => $new_image_list ?: $existing_images, // Use the new images if uploaded, otherwise keep existing
            'content' => $content,
            'slug' => $slug,
            'id' => $id
        ];
        $update_query = $conn->prepare("UPDATE add_page SET title = :title, image = :image, content = :content, slug = :slug WHERE id = :id");
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
$image_paths = '';

if ($id) {
    $select_query = $conn->prepare("SELECT * FROM add_page WHERE id = :id");
    $select_query->execute(['id' => $id]);
    $row = $select_query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $title = htmlspecialchars($row['title']);
        $content = htmlspecialchars($row['content']);
        $image_paths = htmlspecialchars($row['image']);
        $slug = htmlspecialchars($row['slug']);
    } else {
        echo "<p>Banner not found.</p>";
        exit();
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Page</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Page</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="main">
                <div class="page">
                    <form id="add-page" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <!-- Banner Title -->
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="title" class="form-label">Title</label>
                                <input class="form-control" name="title" type="text" id="title" value="<?= htmlspecialchars($title ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="title" class="form-label">Slug</label>
                                <input class="form-control" name="slug" type="text" id="slug" value="<?= htmlspecialchars($slug ?? '') ?>">
                            </div>
                        </div>
                        <!-- Banner Image Upload -->
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="uploadfile" class="form-label">Image</label>
                                <input class="form-control" type="file" name="uploadfile[]">
                                <?php if ($image_paths): ?>
                                    <div class="mt-3">
                                        <h4>Existing Images:</h4>
                                        <?php 
                                        $image_files = explode(', ', $image_paths); 
                                        foreach ($image_files as $image_file): ?>
                                            <?php if (file_exists($target_dir . $image_file)): ?>
                                                <img src="images/<?= htmlspecialchars($image_file) ?>" alt="Page Image" style="width: 100px; height: auto; margin-right: 10px;">
                                            <?php else: ?>
                                                <p>Image file not found: <?= htmlspecialchars($image_file) ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Banner Content -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="content" class="form-label">Banner Content</label>
                                <textarea class="form-control" name="content" id="mySummernote" rows="5"><?= htmlspecialchars($content ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <input type="hidden" name="action" value="<?= $id ? 'update' : 'publish' ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                        <?php endif; ?>
                        <button type="submit" id="btn" class="btn btn-primary">Save</button>
                    </form>
                    <!-- Delete Banner Button -->
                    <?php if ($id): ?>
                        <div class="mt-3">
                            <a href="?action=delete&id=<?= urlencode($id) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this banner?');">
                                Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>

<?php
include('includes/footer.php');
?>
