<?php
ob_start();
include('includes/header.php');
include("includes/demo_conn.php");

// Define target directory
$target_dir = __DIR__ . '/images/';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? '';
    $id = $_POST['id'] ?? null;


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

    // Fetch existing images if updating
    $existing_images = '';
    $exist_images = ''; // Initialize $exist_images to avoid undefined variable issue
    if ($id) {
        $select_query = $conn->prepare("SELECT image, gallery_image FROM banner WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $existing_images = $row['image'];
            $exist_images = $row['gallery_image']; // Set $exist_images to fetched gallery images
        }
    }

    // Combine existing images with newly uploaded ones
    $all_images = array_filter(array_merge(explode(', ', $existing_images), $uploaded_files));
    $image_paths = implode(', ', $all_images);

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
            } else {
                echo "Error code " . $_FILES['gallery_image']['error'][$key] . " for file " . htmlspecialchars($val) . ".<br>";
            }
        }
    }

    // Combine existing gallery images with newly uploaded ones
    $gallery_all_images = array_filter(array_merge(explode(', ', $exist_images), $gallery_uploaded_files));
    $galleryimage_paths = implode(', ', $gallery_all_images);

    $phone_no = isset($_POST['phone_no']) ? serialize($_POST['phone_no']) : '';

    if ($action == 'publish') {
        $data = [
            'title' => $title,
            'image' => $image_paths,
            'gallery_image' => $galleryimage_paths,
            'content' => $content,
            'phone_no' => $phone_no,
            'status' => $status
        ];
        $inserts_query = $conn->prepare("INSERT INTO banner (title, image, gallery_image, content, phone_no, status) VALUES (:title, :image, :gallery_image, :content, :phone_no, :status)");
        $result = $inserts_query->execute($data);

        echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {
        $data = [
            'title' => $title,
            'image' => $image_paths,
            'gallery_image' => $galleryimage_paths,
            'content' => $content,
            'phone_no' => $phone_no,
            'status' => $status,
            'id' => $id
        ];
        $update_query = $conn->prepare("UPDATE banner SET title = :title, image = :image, gallery_image = :gallery_image, content = :content, phone_no = :phone_no, status = :status WHERE id = :id");
        $result = $update_query->execute($data);

        echo $result ? "Update Successful" : "Update Unsuccessful";
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
                                <?php foreach (explode(', ', $image_paths) as $image): ?>
                                    <?php if (file_exists($target_dir . $image)): ?>
                                        <img src="images/<?= htmlspecialchars($image) ?>" alt="Banner Image" style="width: 100px; height: auto; margin-right: 10px;">
                                    <?php else: ?>
                                        <p>Image file not found: <?= htmlspecialchars($image) ?></p>
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
        <label>Gallery Images</label>
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
            <i class="fas fa-plus"></i> Add Gallery Image
        </button>
    </div>
</div>


                <!-- Banner Content -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="content" class="form-label">Banner Content</label>
                        <textarea class="form-control" name="content" id="content" rows="5"><?= htmlspecialchars($content ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Status -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= isset($status) && $status == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= isset($status) && $status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
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
