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
        $select_query = $conn->prepare("SELECT logo FROM setting WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $images = explode(', ', $row['logo']);
            foreach ($images as $image) {
                $file_path = $target_dir . $image;
                // Check if it's a file and then delete
                if (file_exists($file_path) && !is_dir($file_path)) {
                    unlink($file_path); // Delete the file
                }
            }
        }
        if ($row) {
            $images = explode(', ', $row['favicon']);
            foreach ($images as $image) {
                $file_path = $target_dir . $image;
                // Check if it's a file and then delete
                if (file_exists($file_path) && !is_dir($file_path)) {
                    unlink($file_path); // Delete the file
                }
            }
        }

        // Delete setting record
        $delete_query = $conn->prepare("DELETE FROM setting WHERE id = :id");
        $result = $delete_query->execute(['id' => $id]);

        
        if($result)
        {
            session_start();
            $_SESSION["create"] = "Website Deleted Successfully";
            header('location:all-settings.php?delete=success');
            exit();
        }
        else
        {
            $error = $conn->errorInfo();
            header('location:all-settings.php?delete=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $website_name = $_POST['website_name'] ?? '';
    $website_url = $_POST['website_url'] ?? '';
    //$phone_no = $_POST['phone_no'] ?? [];
    //$whatsapp_no = $_POST['whatsapp_no'] ?? [];
    //$email_id = $_POST['email'] ?? [];
    $id = $_POST['id'] ?? null;

    //$whatsapp_no = $_POST['whatsapp_no'] ?? []; // Initialize to avoid undefined variable warning
    //$email_id = $_POST['email_id'] ?? []; // Initialize to avoid undefined variable warning

    $new_logo_images = []; // Initialize this to store multiple images
    $existing_logo_images = ''; // Initialize this to avoid undefined variable warning
    $new_logo_image_list = '';
    $new_fav_images = [];
    $existing_fav_images = ''; // Initialize this to avoid undefined variable warning
    $new_fav_image_list = '';

    //$uploaded_files = [];
    if (!empty($_FILES["logo_upload"]["name"][0])) {
        foreach ($_FILES["logo_upload"]["name"] as $key => $val) {
            if ($_FILES['logo_upload']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . basename($val);
                $target_file = $target_dir . $file;
                
                if (move_uploaded_file($_FILES['logo_upload']['tmp_name'][$key], $target_file)) {
                    $new_logo_images[] = $file;
                } else {
                    echo "Error uploading logo file " . htmlspecialchars($val) . ".<br>";
                }
            } else {
                echo "Error code " . $_FILES['logo_upload']['error'][$key] . " for logo file " . htmlspecialchars($val) . ".<br>";
            }
        }
        $new_logo_image_list = implode(', ', $new_logo_images); // Save as comma-separated string
    }

    $new_fav_images = []; // Initialize this to store multiple images
    $existing_fav_images = ''; // Initialize this to avoid undefined variable warning
    $new_fav_image_list = '';
    //$uploaded_files = [];
    if (!empty($_FILES["favicon_upload"]["name"][0])) {
        foreach ($_FILES["favicon_upload"]["name"] as $key => $val) {
            if ($_FILES['favicon_upload']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . basename($val);
                $target_file = $target_dir . $file;
                
                if (move_uploaded_file($_FILES['favicon_upload']['tmp_name'][$key], $target_file)) {
                    $new_fav_images[] = $file;
                } else {
                    echo "Error uploading file " . htmlspecialchars($val) . ".<br>";
                }
            } else {
                echo "Error code " . $_FILES['favicon_upload']['error'][$key] . " for file " . htmlspecialchars($val) . ".<br>";
            }
        }
        $new_fav_image_list = implode(', ', $new_fav_images); // Save as comma-separated string
    }

    // Fetch existing images if updating
    //$existing_images = '';

    // Combine existing images with newly uploaded ones
    //$all_images = array_filter(array_merge(explode(', ', $existing_images), $uploaded_files));
    //$image_paths = implode(', ', $all_images);

    

    $phone_no = isset($_POST['phone_no']) ? serialize($_POST['phone_no']) : '';
    $whatsapp_no = isset($_POST['whatsapp_no']) ? serialize($_POST['whatsapp_no']) : '';
    $email_id = isset($_POST['email']) ? serialize($_POST['email']) : ''; // Serialize the email array
    //$email_id = isset($_POST['email']) ? serialize($_POST['email']) : '';

    if ($action == 'publish') {
        $data = [
            'website_name' => $website_name,
            'website_url' => $website_url,
            'phone_no' => $phone_no,
            'whatsapp_no' => $whatsapp_no,
            'email' => $email_id,
            'logo' => $new_logo_image_list,
            'favicon' => $new_fav_image_list
        ];
        $inserts_query = $conn->prepare("INSERT INTO setting (website_name, website_url, phone_no, whatsapp_no, email, logo, favicon) VALUES (:website_name, :website_url, :phone_no, :whatsapp_no, :email, :logo, :favicon)");
        $result = $inserts_query->execute($data);

        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Website Added Successfully";
            header('location:all-settings.php?insert=success');
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            //$error = mysqli_error($conn);
            $error = $conn->errorInfo();
            header('location:all-settings.php?insert=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
        //echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {

        // Fetch existing logo if any
        if (!$new_logo_images) {
            $select_query = $conn->prepare("SELECT logo FROM setting WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_logo_images = $row['logo']; // Get existing images
            }
        } else {
            // Remove existing logo if new images are uploaded
            $select_query = $conn->prepare("SELECT logo FROM setting WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_logo_images = $row['logo'];
                $logo_image_files = explode(', ', $existing_logo_images);
                foreach ($logo_image_files as $logo_image_file) {
                    $existing_logo_image_path = $target_dir . $logo_image_file;
                    // Check if it's a file and then delete
                    if (file_exists($existing_logo_image_path) && !is_dir($existing_logo_image_path)) {
                        unlink($existing_logo_image_path); // Delete the old logo file
                    }
                }
            }
        }

        // Fetch existing favicon if any
        if (!$new_fav_images) {
            $select_query = $conn->prepare("SELECT favicon FROM setting WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_fav_images = $row['favicon']; // Get existing images
            }
        } else {
            // Remove existing favicon if new images are uploaded
            $select_query = $conn->prepare("SELECT favicon FROM setting WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_fav_images = $row['favicon'];
                $fav_image_files = explode(', ', $existing_fav_images);
                foreach ($fav_image_files as $fav_image_file) {
                    $existing_fav_image_path = $target_dir . $fav_image_file;
                    // Check if it's a file and then delete
                    if (file_exists($existing_fav_image_path) && !is_dir($existing_fav_image_path)) {
                        unlink($existing_fav_image_path); // Delete the old favicon file
                    }
                }
            }
        }

        $data = [
            'website_name' => $website_name,
            'website_url' => $website_url,
            'phone_no' => $phone_no,
            'whatsapp_no' => $whatsapp_no,
            'email' => $email_id,
            'logo' => $new_logo_image_list ?: $existing_logo_images, // Use the new logo if uploaded, otherwise keep existing
            'favicon' => $new_fav_image_list ?: $existing_fav_images, // Use the new favicon if uploaded, otherwise keep existing
            'id' => $id
        ];
        $update_query = $conn->prepare("UPDATE setting SET website_name = :website_name, website_url = :website_url, phone_no = :phone_no, whatsapp_no = :whatsapp_no, email = :email, logo = :logo, favicon = :favicon WHERE id = :id");
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
                $error = $conn->errorInfo();
                echo("Update Unsuccessful: " . htmlspecialchars($error[2]));
            }
            ?>
        </div>
        <?php
    }
}

$id = $_GET['id'] ?? null;
$logo_image_paths = '';
$fav_image_paths = '';

if ($id) {
    $select_query = $conn->prepare("SELECT * FROM setting WHERE id = :id");
    $select_query->execute(['id' => $id]);
    $row = $select_query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $website_name = htmlspecialchars($row['website_name']);
        $website_url = htmlspecialchars($row['website_url']);
        $phone_no = unserialize($row['phone_no']) ?? [];
        $whatsapp_no = unserialize($row['whatsapp_no']) ?? [];
        $email_id = unserialize($row['email']);
        $logo_image_paths = htmlspecialchars($row['logo']);
        $fav_image_paths = htmlspecialchars($row['favicon']);
    } else {
        echo "<p>Banner not found.</p>";
        exit();
    }
}

?>


<div class="container">
    <h2><b>General Setting</b></h2>
    <div class="row">
        <div class="main">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary mt-2">Website Details</h5>
                </div>
                <div class="card-body"> 
                    <form id="setting" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <!-- Website Name -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="wbsite_name" class="form-label">Website Name</label>
                                <input class="form-control" name="website_name" type="website_name" id="website_name" placeholder="Name" value="<?= htmlspecialchars($website_name ?? '') ?>">
                            </div>
                        </div>

                        <!-- Website URL -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="website_url" class="form-label">Website Url</label>
                                <input class="form-control" name="website_url" type="text" id="website_url" placeholder="URL" value="<?= htmlspecialchars($website_url ?? '') ?>">
                            </div>
                        </div>

                        <!-- Phone Numbers -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Phone No.</label>
                                <div id="phone-container">
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

                            <!-- Whatsapp Numbers -->
                            <div class="col-md-6">
                                <label>Whatsapp No.</label>
                                <div id="whatsapp-container">
                                    <?php
                                    if (!empty($whatsapp_no)) {
                                        foreach ($whatsapp_no as $index => $whatsapp) {
                                            echo '<div class="add-table mb-3 cloned-row">';
                                            echo '<div class="input-group mb-2">';
                                            echo '<span class="input-group-text">' . ($index + 1) . '.</span>';
                                            echo '<input type="text" class="form-control" name="whatsapp_no[]" value="' . htmlspecialchars($whatsapp) . '">';
                                            echo '<button type="button" class="btn btn-outline-danger btn-sm remove-whatsapp">Remove</button>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo '<div class="add-table mb-3 cloned-row">';
                                        echo '<div class="input-group mb-2">';
                                        echo '<span class="input-group-text">1.</span>';
                                        echo '<input type="text" class="form-control" name="whatsapp_no[]">';
                                        echo '<button type="button" class="btn btn-outline-danger btn-sm remove-whatsapp">Remove</button>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" id="add-whatsapp">
                                    <i class="fas fa-plus"></i> Add Whatsapp No
                                </button>
                            </div>
                        </div>

                        <!-- Emails -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Email Id </label>
                                <div id="email-container">
                                    <?php
                                    if (!empty($email_id)) {
                                        foreach ($email_id as $index => $emails) {
                                            echo '<div class="add-table mb-3 cloned-row">';
                                            echo '<div class="input-group mb-2">';
                                            echo '<span class="input-group-text">' . ($index + 1) . '.</span>';
                                            echo '<input type="text" class="form-control" name="email[]" value="' . htmlspecialchars($emails) . '">';
                                            echo '<button type="button" class="btn btn-outline-danger btn-sm remove-email">Remove</button>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo '<div class="add-table mb-3 cloned-row">';
                                        echo '<div class="input-group mb-2">';
                                        echo '<span class="input-group-text">1.</span>';
                                        echo '<input type="text" class="form-control" name="email[]">';
                                        echo '<button type="button" class="btn btn-outline-danger btn-sm remove-email">Remove</button>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" id="add-email">
                                    <i class="fas fa-plus"></i> Add Email Id
                                </button>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="uploadfile" class="form-label">Logo</label>
                                <input class="form-control" type="file" name="logo_upload[]">
                                <?php if ($logo_image_paths): ?>
                                    <div class="mt-3">
                                        <h4>Existing Logo:</h4>
                                        <?php 
                                        $logo_image_files = explode(', ', $logo_image_paths); 
                                        foreach ($logo_image_files as $logo_image_file): ?>
                                            <?php if (file_exists($target_dir . $logo_image_file)): ?>
                                                <img src="images/<?= htmlspecialchars($logo_image_file) ?>" alt="Logo Image" style="width: 250px; height: auto; margin-right: 10px;">
                                            <?php else: ?>
                                                <p>Image file not found: <?= htmlspecialchars($logo_image_file) ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Favicon Upload -->
                            <div class="col-md-6">
                                <label for="uploadfile" class="form-label">Favicon</label>
                                <input class="form-control" type="file" name="favicon_upload[]">
                                <?php if ($fav_image_paths): ?>
                                    <div class="mt-3">
                                        <h4>Existing Favicon:</h4>
                                        <?php 
                                        $fav_image_files = explode(', ', $fav_image_paths); 
                                        foreach ($fav_image_files as $fav_image_file): ?>
                                            <?php if (file_exists($target_dir . $fav_image_file)): ?>
                                                <img src="images/<?= htmlspecialchars($fav_image_file) ?>" alt="Favicon Image" style="width: 100px; height: auto; margin-right: 10px;">
                                            <?php else: ?>
                                                <p>Image file not found: <?= htmlspecialchars($fav_image_file) ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <input type="hidden" name="action" value="<?= $id ? 'update' : 'publish' ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    
                    <!-- Delete Setting Button -->
                    <?php if ($id): ?>
                        <div class="mt-3">
                            <a href="?action=delete&id=<?= urlencode($id) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this setting?');">
                                Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', () => {
    const addPhoneBtn = document.getElementById('add-phone');
    const addWhatsappBtn = document.getElementById('add-whatsapp');
    const addEmailBtn = document.getElementById('add-email');
    const phoneContainer = document.getElementById('phone-container');
    const whatsappContainer = document.getElementById('whatsapp-container');
    const emailContainer = document.getElementById('email-container');
    
    // Add phone number fields
    addPhoneBtn.addEventListener('click', () => {
        const index = phoneContainer.children.length + 1;
        const newRow = document.createElement('div');
        newRow.classList.add('add-table', 'mb-3', 'cloned-row');
        newRow.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">${index}.</span>
                <input type="text" class="form-control" name="phone_no[]">
                <button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>
            </div>
        `;
        phoneContainer.appendChild(newRow);
    });

    // Remove phone number fields
    phoneContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-phone')) {
            e.target.closest('.cloned-row').remove();
        }
    });

    // Add whatsapp number fields
    addWhatsappBtn.addEventListener('click', () => {
        const index = whatsappContainer.children.length + 1;
        const newRow = document.createElement('div');
        newRow.classList.add('add-table', 'mb-3', 'cloned-row');
        newRow.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">${index}.</span>
                <input type="text" class="form-control" name="whatsapp_no[]">
                <button type="button" class="btn btn-outline-danger btn-sm remove-whatsapp">Remove</button>
            </div>
        `;
        whatsappContainer.appendChild(newRow);
    });

    // Remove whatsapp number fields
    whatsappContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-whatsapp')) {
            e.target.closest('.cloned-row').remove();
        }
    });

    // Add email fields
    addEmailBtn.addEventListener('click', () => {
        const index = emailContainer.children.length + 1;
        const newRow = document.createElement('div');
        newRow.classList.add('add-table', 'mb-3', 'cloned-row');
        newRow.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">${index}.</span>
                <input type="text" class="form-control" name="email[]">
                <button type="button" class="btn btn-outline-danger btn-sm remove-email">Remove</button>
            </div>
        `;
        emailContainer.appendChild(newRow);
    });

    // Remove email fields
    emailContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-email')) {
            e.target.closest('.cloned-row').remove();
        }
    });
});
</script>

<?php include('includes/footer.php'); ?>
