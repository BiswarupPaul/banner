<?php
ob_start();
include('includes/header.php');
include('includes/demo_conn.php');

// Define target directory
$target_dir = __DIR__ . '/images/';

// Slug generation function
function generateSlug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    
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

        header('Location: all-page.php?delete=' . ($result ? 'success' : 'fail'));
        exit();
    } else {
        header('Location: all-page.php?delete=fail');
        exit();
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $id = $_POST['id'] ?? null;

    // Generate the slug
    $slug = generateSlug($title);

    $uploaded_files = [];
    if (!empty($_FILES["uploadfile"]["name"][0])) {
        foreach ($_FILES["uploadfile"]["name"] as $key => $val) {
            if ($_FILES['uploadfile']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . basename($val);
                $target_file = $target_dir . $file;
                
                if (move_uploaded_file($_FILES['uploadfile']['tmp_name'][$key], $target_file)) {
                    $uploaded_files[] = $file;
                } else {
                    echo "Error uploading file " . htmlspecialchars($val) . ".<br>";
                }
            } else {
                echo "Error code " . $_FILES['uploadfile']['error'][$key] . " for file " . htmlspecialchars($val) . ".<br>";
            }
        }
    }

    // Determine the image path
    $image_path = $uploaded_files[0] ?? '';

    if ($action == 'publish') {
        $data = [
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'image' => $image_path
        ];
        $inserts_query = $conn->prepare("INSERT INTO add_page (title, content, slug, image) VALUES (:title, :content, :slug, :image)");
        $result = $inserts_query->execute($data);
        echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {
        // Fetch existing image if updating
        $select_query = $conn->prepare("SELECT image FROM add_page WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);

        // Delete old image
        if ($row && $row['image']) {
            $old_image_path = $target_dir . $row['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        $data = [
            'title' => $title,
            'image' => $image_path,
            'content' => $content,
            'slug' => $slug,
            'id' => $id
        ];
        $update_query = $conn->prepare("UPDATE add_page SET title = :title, image = :image, content = :content, slug = :slug WHERE id = :id");
        $result = $update_query->execute($data);
        echo $result ? "Update Successful" : "Update Unsuccessful";
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
                                        <?php if (file_exists($target_dir . $image_paths)): ?>
                                            <img src="images/<?= htmlspecialchars($image_paths) ?>" alt="Banner Image" style="width: 100px; height: auto; margin-right: 10px;">
                                        <?php else: ?>
                                            <p>Image file not found: <?= htmlspecialchars($image_paths) ?></p>
                                        <?php endif; ?>
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
