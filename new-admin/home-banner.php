<?php
ob_start();
include('includes/header.php');
include("includes/demo_conn.php");

// Define target directory for images
$target_dir = __DIR__ . '/images/';

// Initialize $id
$id = $_GET['id'] ?? null;

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $title = $_POST['title'] ?? '';

    // Handle uploaded files
    $banner_uploaded_files = [];
    if (!empty($_FILES["banner_image"]["name"][0])) {
        foreach ($_FILES["banner_image"]["name"] as $key => $val) {
            if ($_FILES['banner_image']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . basename($val);
                $target_file = $target_dir . $file;

                if (move_uploaded_file($_FILES['banner_image']['tmp_name'][$key], $target_file)) {
                    $banner_uploaded_files[] = $file;
                } else {
                    echo "Error uploading file " . htmlspecialchars($val) . ".<br>";
                }
            } else {
                echo "Error code " . $_FILES['banner_image']['error'][$key] . " for file " . htmlspecialchars($val) . ".<br>";
            }
        }
    }

    $bannerimage_paths = implode(', ', $banner_uploaded_files);

    // Prepare to insert or update records
    if ($action == 'publish' || $action == 'update') {
        // Check if record exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM home_banner");
        $stmt->execute();
        $record_exists = $stmt->fetchColumn() > 0;
    
        $queries = [
            ['option_name' => 'title', 'option_value' => $title],
            ['option_name' => 'banner_image', 'option_value' => $bannerimage_paths]
        ];
    
        if (!$record_exists) {
            // Insert new records
            foreach ($queries as $data) {
                $query = $conn->prepare("INSERT INTO home_banner (option_name, option_value) VALUES (:option_name, :option_value)");
                $result = $query->execute($data);
            }
            echo $result ? "Insert Successful" : "Insert Unsuccessful";
        } else {
            // Update existing records
            foreach ($queries as $data) {
                $query = $conn->prepare("UPDATE home_banner SET option_value = :option_value WHERE option_name = :option_name");
                $result = $query->execute($data);
            }
            echo $result ? "Update Successful" : "Update Unsuccessful";
        }
    }
}    

// Fetch existing options for displaying in the form
$options = [];
$query = $conn->query("SELECT option_name, option_value FROM home_banner");
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $options[$row['option_name']] = $row['option_value'];
}

$title = htmlspecialchars($options['title'] ?? '');
$banner_image = !empty($options['banner_image']) ? explode(', ', $options['banner_image']) : [];
?>

<div class="row">
    <div class="main">
        <div class="home_banner">
            <h2>Banner</h2>
            <form id="banner" method="POST" enctype="multipart/form-data" autocomplete="off">
                <!-- Banner Title -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="title" class="form-label">Banner Title</label>
                        <input class="form-control" name="title" type="text" id="title" value="<?= htmlspecialchars($title) ?>">
                    </div>
                </div>

                <!-- Banner Images -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label>Banner Images</label>
                        <div id="banner-container">
                            <?php if (!empty($banner_image)): ?>
                                <?php foreach ($banner_image as $index => $val): ?>
                                    <div class="banner-item mb-3">
                                        <input type="file" name="banner_image[]" class="form-control">
                                        <?php if (file_exists($target_dir . $val)): ?>
                                            <img src="images/<?= htmlspecialchars($val) ?>" alt="Banner Image" style="width: 200px; height: auto; margin-right: 10px;">
                                            <form method="POST" action="delete-banner-image.php" style="display:inline;">
                                                <input type="hidden" name="delete_image" value="<?= htmlspecialchars($val) ?>">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>"> <!-- Include ID -->
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>
                                        <?php else: ?>
                                            <p>Image file not found: <?= htmlspecialchars($val) ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="banner-item mb-3">
                                    <input type="file" name="banner_image[]" class="form-control">
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm" id="add-banner">
                            <i class="fas fa-plus"></i> Add Banner Image
                        </button>
                    </div>
                </div>

                <!-- Form Actions -->
                <!-- <input type="hidden" name="action" value="publish"> -->
                <input type="hidden" name="action" value="<?= isset($options['id']) ? 'publish' : 'update' ?>">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const addBannerBtn = document.getElementById('add-banner');
    const bannerContainer = document.getElementById('banner-container');

    // Add banner image fields
    addBannerBtn.addEventListener('click', () => {
        const newItem = document.createElement('div');
        newItem.classList.add('banner-item', 'mb-3');
        newItem.innerHTML = `
            <input type="file" name="banner_image[]" class="form-control">
        `;
        bannerContainer.appendChild(newItem);
    });
});
</script>

<?php include('includes/footer.php'); ?>
