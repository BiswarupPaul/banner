<?php
ob_start();
include('includes/header.php');
include("includes/demo_conn.php");

// Define target directory
$target_dir = __DIR__ . '/images/';

// Handle delete requests
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        // Fetch existing images before deleting
        $select_query = $conn->prepare("SELECT image FROM banner WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $images = explode(', ', $row['image']);
            foreach ($images as $image) {
                $file_path = $target_dir . $image;
                // Check if it's a file and then delete
                if (file_exists($file_path) && !is_dir($file_path)) {
                    unlink($file_path); // Delete the file
                }
            }
        }

        // Delete blog record
        $delete_query = $conn->prepare("DELETE FROM banner WHERE id = :id");
        $result = $delete_query->execute(['id' => $id]);

        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Banner Deleted Successfully";
            header('location:list-banner.php?delete=success');
            exit();
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            $error = $conn->errorInfo();
            header('location:list-banner.php?delete=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? '';
    $id = $_POST['id'] ?? null;

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

    // Fetch existing images if updating
    //$existing_images = '';
    $exist_images = ''; // Initialize $exist_images to avoid undefined variable issue
    if ($id) {
        $select_query = $conn->prepare("SELECT gallery_image FROM banner WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            //$existing_images = $row['image'];
            $exist_images = $row['gallery_image']; // Set $exist_images to fetched gallery images
        }
    }

    // Combine existing images with newly uploaded ones
    //$all_images = array_filter(array_merge(explode(', ', $existing_images), $uploaded_files));
    //$image_paths = implode(', ', $all_images);

    $gallery_uploaded_files = [];
    if (!empty($_FILES["gallery_image"]["name"][0])) {
        foreach ($_FILES["gallery_image"]["name"] as $key => $val) {
            if ($_FILES['gallery_image']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . basename($val);
                $target_file = $target_dir . $file;
    
                if (move_uploaded_file($_FILES['gallery_image']['tmp_name'][$key], $target_file)) {
                    $gallery_uploaded_files[] = $file;
                } else {
                    echo "Error uploading file " . htmlspecialchars($val) . ".<br>";
                }
            } //else {
                //echo "Error code " . $_FILES['gallery_image']['error'][$key] . " for file " . htmlspecialchars($val) . ".<br>";
            //}
        }
    }

    // Combine existing gallery images with newly uploaded ones
    $gallery_all_images = array_filter(array_merge(explode(', ', $exist_images), $gallery_uploaded_files));
    $galleryimage_paths = implode(', ', $gallery_all_images);

    $phone_no = isset($_POST['phone_no']) ? serialize($_POST['phone_no']) : '';

    if ($action == 'publish') {
        $data = [
            'title' => $title,
            'image' => $new_image_list,
            'gallery_image' => $galleryimage_paths,
            'content' => $content,
            'phone_no' => $phone_no,
            'status' => $status
        ];
        $inserts_query = $conn->prepare("INSERT INTO banner (title, image, gallery_image, content, phone_no, status) VALUES (:title, :image, :gallery_image, :content, :phone_no, :status)");
        $result = $inserts_query->execute($data);

        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Banner Added Successfully";
            header('location:list-banner.php?insert=success');
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            //$error = mysqli_error($conn);
            $error = $conn->errorInfo();
            header('location:list-banner.php?insert=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
        //echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {

        // Fetch existing image if any
        if (!$new_images) {
            $select_query = $conn->prepare("SELECT image FROM banner WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_images = $row['image']; // Get existing images
            }
        } else {
            // Remove existing images if new images are uploaded
            $select_query = $conn->prepare("SELECT image FROM banner WHERE id = :id");
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
            'gallery_image' => $galleryimage_paths,
            'content' => $content,
            'phone_no' => $phone_no,
            'status' => $status,
            'id' => $id
        ];
        $update_query = $conn->prepare("UPDATE banner SET title = :title, image = :image, gallery_image = :gallery_image, content = :content, phone_no = :phone_no, status = :status WHERE id = :id");
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
        //echo $result ? "Update Successful" : "Update Unsuccessful";
        <?php
    }
}

$id = $_GET['id'] ?? null;
$image_paths = '';
$galleryimage_paths = [];

if ($id) {
    $select_query = $conn->prepare("SELECT * FROM banner WHERE id = :id");
    $select_query->execute(['id' => $id]);
    $row = $select_query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $title = htmlspecialchars($row['title']);
        $content = htmlspecialchars($row['content']);
        $phone_no = unserialize($row['phone_no']) ?? [];
        $gallery_image = $row['gallery_image'] ? explode(', ', $row['gallery_image']) : [];
        $status = htmlspecialchars($row['status']);
        $image_paths = htmlspecialchars($row['image']);
        $galleryimage_paths = $gallery_image;
    } else {
        echo "<p>Banner not found.</p>";
        exit();
    }
}

?>

<div class="row">
    <div class="main">
        <div class="register">
            <h2>Banner</h2>
            <form id="banner" method="POST" enctype="multipart/form-data" autocomplete="off">
                <!-- Banner Title -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="title" class="form-label">Banner Title</label>
                        <input class="form-control" name="title" type="text" id="title" value="<?= htmlspecialchars($title ?? '') ?>">
                    </div>

                <!-- Banner Image Upload -->
                    <div class="col-md-7">
                        <label for="uploadfile" class="form-label">Banner Image</label>
                        <input class="form-control" type="file" name="uploadfile[]">
                        <?php if ($image_paths): ?>
                            <div class="mt-3">
                                <h4>Existing Images:</h4>
                                <?php 
                                $image_files = explode(', ', $image_paths); 
                                foreach ($image_files as $image_file): ?>
                                    <?php if (file_exists($target_dir . $image_file)): ?>
                                        <img src="images/<?= htmlspecialchars($image_file) ?>" alt="Banner Image" style="width: 100px; height: auto; margin-right: 10px;">
                                    <?php else: ?>
                                        <p>Image file not found: <?= htmlspecialchars($image_file) ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Phone Numbers -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Phone No.</label>
                        <div id="contact-container">
                            <?php
                            if (!empty($phone_no)) {
                                foreach ($phone_no as $index => $phone) {
                                    echo '<div class="add-table mb-3 cloned-row">';
                                    echo '<div class="input-group mb-2">';
                                    echo '<span class="input-group-text">' . ($index + 1) . '.</span>';
                                    echo '<input type="text" class="form-control" name="phone_no[]" value="' . htmlspecialchars($phone) . '">';
                                    echo '<button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="add-table mb-3 cloned-row">';
                                echo '<div class="input-group mb-2">';
                                echo '<span class="input-group-text">1.</span>';
                                echo '<input type="text" class="form-control" name="phone_no[]">';
                                echo '<button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm" id="add-phone">
                            <i class="fas fa-plus"></i> Add Phone No
                        </button>
                    </div>
                </div>

                <!-- Gallery Images -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label>Banner Images</label>
                        <div id="gallery-container">
                            <?php if (!empty($gallery_image)): ?>
                                <?php foreach ($gallery_image as $index => $val): ?>
                                    <div class="gallery-item mb-3">
                                        <input type="file" name="gallery_image[]" class="form-control">
                                        <?php if (file_exists($target_dir . $val)): ?>
                                            <img src="images/<?= htmlspecialchars($val) ?>" alt="Gallery Image" style="width: 100px; height: auto; margin-right: 10px;">
                                            <form method="POST" action="delete-gallery-image.php" style="display:inline;">
                                                <input type="hidden" name="delete_image" value="<?= htmlspecialchars($val) ?>">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>

                                            <?php else: ?>
                                                <p>Image file not found: <?= htmlspecialchars($val) ?></p>
                                            <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="gallery-item mb-3">
                                    <input type="file" name="gallery_image[]" class="form-control">
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm" id="add-gallery">
                            <i class="fas fa-plus"></i> Add Banner Image
                        </button>
                    </div>
                </div>


                <!-- Banner Content -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="content" class="form-label">Banner Content</label>
                        <textarea class="form-control" name="content" id="mySummernote" rows="5"><?= htmlspecialchars($content ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Status -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" <?= isset($status) && $status == '1' ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= isset($status) && $status == '0' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <input type="hidden" name="action" value="<?= $id ? 'update' : 'publish' ?>">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <?php var_dump($_POST); ?>
            <!-- Delete Blog Button -->
            <?php if ($id): ?>
                <div class="mt-3">
                    <a href="?action=delete&id=<?= urlencode($id) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog?');">
                        Delete
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', () => {
    const addPhoneBtn = document.getElementById('add-phone');
    const contactContainer = document.getElementById('contact-container');
    const addGalleryBtn = document.getElementById('add-gallery');
    const galleryContainer = document.getElementById('gallery-container');

    // Add phone number fields
    addPhoneBtn.addEventListener('click', () => {
        const index = contactContainer.children.length + 1;
        const newRow = document.createElement('div');
        newRow.classList.add('add-table', 'mb-3', 'cloned-row');
        newRow.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">${index}.</span>
                <input type="text" class="form-control" name="phone_no[]">
                <button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>
            </div>
        `;
        contactContainer.appendChild(newRow);
    });

    // Add gallery image fields
    addGalleryBtn.addEventListener('click', () => {
        const newItem = document.createElement('div');
        newItem.classList.add('gallery-item', 'mb-3');
        newItem.innerHTML = `
            <input type="file" name="gallery_image[]" class="form-control">
        `;
        galleryContainer.appendChild(newItem);
    });

    // Remove phone number fields
    contactContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-phone')) {
            e.target.closest('.cloned-row').remove();
        }
    });
});
</script>

<?php include('includes/footer.php'); ?>
