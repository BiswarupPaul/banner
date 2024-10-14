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
        $select_query = $conn->prepare("SELECT image, gallery_image FROM banner WHERE id = :id");
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
            // Delete gallery images
            $gallery_images = explode(', ', $row['gallery_image']);
            foreach ($gallery_images as $image) {
                $file_path = $target_dir . $image;
                if (file_exists($file_path)) {
                    unlink($file_path); // Delete the file
                }
            }
        }

        // Delete banner record
        $delete_query = $conn->prepare("DELETE FROM banner WHERE id = :id");
        $result = $delete_query->execute(['id' => $id]);

        header('Location: list-banner.php?delete=' . ($result ? 'success' : 'fail'));
        exit();
    } else {
        header('Location: list-banner.php?delete=fail');
        exit();
    }
}

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
    if ($id) {
        $select_query = $conn->prepare("SELECT image, gallery_image FROM banner WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $existing_images = $row['image'];
            $exist_images = $row['gallery_image'];
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
    //$gallery_image = isset($_POST['gallery_image']) ? serialize($_POST['gallery_image']) : '';

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
        //$galleryimage_paths = serialize($row['gallery_image']) ?? [];
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
                                    <div class="add-table mb-3 cloned-row" id="added<?= $index ?>">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><?= ($index + 1) ?>.</span>
                                            <input class="form-control form-control-sm" id="gallery_image[<?= $index ?>]" name="gallery_image[<?= $index ?>]" type="file">
                                            <a class="btn btn-outline-success btn-sm add-gallery" href="javascript:void(0);">
                                                <i class="fas fa-plus"></i> Add New
                                            </a>
                                            <?php if ($index != 0): ?>
                                                <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm remove-gallery">
                                                    <i class="fa-solid fa-minus"></i> Remove
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="add-table mb-3 cloned-row" id="added0">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">1.</span>
                                        <input class="form-control form-control-sm" id="gallery_image[0]" name="gallery_image[0]" type="file">
                                        <a class="btn btn-outline-success btn-sm add-gallery" href="javascript:void(0);">
                                            <i class="fa-solid fa-plus"></i> Add New
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($galleryimage_paths)): ?>
                            <div class="mt-3">
                                <h4>Existing Gallery Images:</h4>
                                <?php foreach ($galleryimage_paths as $image): ?>
                                    <?php if (file_exists($target_dir . $image)): ?>
                                        <img src="images/<?= htmlspecialchars($image) ?>" alt="Gallery Image" style="width: 100px; height: auto; margin-right: 10px;">
                                    <?php else: ?>
                                        <p>Gallery image file not found: <?= htmlspecialchars($image) ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>

                <!-- Banner Content -->
                <div class="mb-3">
                    <label for="content" class="form-label">Banner Content</label>
                    <textarea class="form-control" name="content" id="mySummernote" rows="10"><?= htmlspecialchars($content ?? '') ?></textarea>
                </div>

                <!-- Status -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Status:</label><br>
                        <input type="radio" name="status" value="1" <?= isset($status) && $status == '1' ? 'checked' : '' ?>> ON
                        <input type="radio" name="status" value="0" <?= isset($status) && $status == '0' ? 'checked' : '' ?>> OFF
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="hidden" name="action" value="<?= $id ? 'update' : 'publish' ?>">
                        <?= $id ? '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">' : '' ?>
                        <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary">
                    </div>
                </div>
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


<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize phone number fields
    let phoneNoCount = <?= !empty($phone_no) ? count($phone_no) : 0 ?>;

    // Add new phone number field
    $('#add-phone').on('click', function() {
        phoneNoCount++;
        const phoneHtml = `
            <div class="add-table mb-3 cloned-row">
                <div class="input-group mb-2">
                    <span class="input-group-text">${phoneNoCount}.</span>
                    <input type="text" class="form-control" name="phone_no[]">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>
                </div>
            </div>
        `;
        $('#contact-container').append(phoneHtml);
    });

    // Remove phone number field
    $(document).on('click', '.remove-phone', function() {
        $(this).closest('.cloned-row').remove();
        reindexPhoneNoFields();
    });

    // Reindex phone number fields
    function reindexPhoneNoFields() {
        $('.cloned-row').each(function(index) {
            $(this).find('.input-group-text').text((index + 1) + '.');
        });
    }

    // Add new gallery image field
    $(document).on('click', '.add-gallery', function() {
        const count = $('#gallery-container .cloned-row').length;
        const $clone = $('#gallery-container .cloned-row:eq(0)').clone();
        $clone.find('.add-gallery')
            .after("<a href='javascript:void(0);' class='btn btn-outline-danger btn-sm remove-gallery'><i class='fa-solid fa-minus'></i> Remove</a>")
            .end()
            .attr('id', `added${count}`)
            .find('span.input-group-text').text((count + 1) + '.')
            .end()
            .find('input[type="file"]').val('')
            .end()
            .find('input[type="file"]').attr('name', `gallery_image[${count}]`)
            .attr('id', `gallery_image[${count}]`);

        $(this).closest('.add-table').after($clone);
    });

    // Remove gallery image field
    $(document).on('click', '.remove-gallery', function() {
        if ($('.cloned-row').length > 1) {
            $(this).closest('.cloned-row').remove();
            reindexGalleryFields();
        }
    });

    // Reindex gallery image fields
    function reindexGalleryFields() {
        $('.cloned-row').each(function(index) {
            $(this).find('.input-group-text').text((index + 1) + '.');
            $(this).find('input[type="file"]').attr('name', `gallery_image[${index}]`)
                .attr('id', `gallery_image[${index}]`);
        });
    }

    // Form validation
    $("#banner").validate({
        rules: {
            title: {
                required: true,
                lettersonly: true
            },
            content: {
                required: true
            },
            status: {
                required: true
            }
        },
        messages: {
            title: {
                required: '<br>Enter the Title'
            },
            content: {
                required: '<br>Enter Content'
            },
            status: {
                required: '<br>Enter the Status'
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    // Restrict title input to letters and spaces
    $("#title").on('input', function() {
        const expression = /[^a-zA-Z\s]/g;
        if ($(this).val().match(expression)) {
            $(this).val($(this).val().replace(expression, ""));
        }
    });

    // Restrict content input to letters, numbers, and spaces
    $("#content").on('input', function() {
        const expression = /[^a-zA-Z0-9\s]/g;
        if ($(this).val().match(expression)) {
            $(this).val($(this).val().replace(expression, ""));
        }
    });
});
</script>


<?php include('includes/footer.php'); ?>