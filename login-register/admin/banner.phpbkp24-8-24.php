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
                if (file_exists($file_path)) {
                    unlink($file_path); // Delete the file
                }
            }
        }

        // Delete banner record
        $delete_query = $conn->prepare("DELETE FROM banner WHERE id = :id");
        $result = $delete_query->execute(['id' => $id]);

        if ($result) {
            header('Location: list-banner.php?delete=success');
            exit();
        } else {
            header('Location: list-banner.php?delete=fail');
            exit();
        }
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

    // Fetch existing images if updating
    $existing_images = '';
    if ($id) {
        $select_query = $conn->prepare("SELECT image FROM banner WHERE id = :id");
        $select_query->execute(['id' => $id]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $existing_images = $row['image'];
        }
    }

    $uploaded_files = [];
    if (!empty($_FILES["uploadfile"]["name"][0])) {
        foreach ($_FILES["uploadfile"]["name"] as $key => $val) {
            if ($_FILES['uploadfile']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . $val;
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

    // Combine existing images with newly uploaded ones
    $all_images = array_filter(array_merge(explode(', ', $existing_images), $uploaded_files));
    $image_paths = implode(', ', $all_images);

    if ($action == 'publish') {
        $data = [
            'title' => $title,
            'image' => $image_paths,
            'content' => $content,
            'status' => $status
        ];
        $inserts_query = $conn->prepare("INSERT INTO banner (title, image, content, status) VALUES (:title, :image, :content, :status)");
        $result = $inserts_query->execute($data);

        echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {
        $data = [
            'title' => $title,
            'image' => $image_paths,
            'content' => $content,
            'status' => $status,
            'id' => $id
        ];
        $update_query = $conn->prepare("UPDATE banner SET title = :title, image = :image, content = :content, status = :status WHERE id = :id");
        $result = $update_query->execute($data);

        echo $result ? "Update Successful" : "Update Unsuccessful";
    }
}

$id = $_GET['id'] ?? null;
$image_paths = '';

if ($id) {
    $select_query = $conn->prepare("SELECT * FROM banner WHERE id = :id");
    $select_query->execute(['id' => $id]);
    $row = $select_query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $title = htmlspecialchars($row['title']);
        $content = htmlspecialchars($row['content']);
        $status = htmlspecialchars($row['status']);
        $image_paths = htmlspecialchars($row['image']);
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
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="title" class="form-label">Banner Title</label>
                        <input class="form-control" name="title" type="text" id="title" value="<?= $title ?? '' ?>">
                    </div>
                    <div class="col-md-7">
                        <label for="uploadfile" class="form-label">Banner Image</label>
                        <input class="form-control" type="file" name="uploadfile[]" multiple id="uploadfile">

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
                    <div class="mb-3">
                        <label for="content" class="form-label">Banner Content</label>
                        <textarea class="form-control" name="content" id="mySummernote" rows="10"><?= $content ?? '' ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Status:</label><br>
                        <input type="radio" name="status" value="1" <?= isset($status) && $status == '1' ? 'checked' : '' ?>> ON
                        <input type="radio" name="status" value="0" <?= isset($status) && $status == '0' ? 'checked' : '' ?>> OFF
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" name="action" value="<?= $id ? 'update' : 'publish' ?>">
                        <?= $id ? '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">' : '' ?>
                        <input type="submit" value="Submit" name="submit" id="submit">
                    </div>
                </div>
            </form>
            <?php if ($id): ?>
                <div class="mt-3">
                    <a href="?action=delete&id=<?= urlencode($id) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this banner?');">Delete</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
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

    $("#title").on('input', function() {
        var expression = /[^a-zA-Z\s]/g;
        if ($(this).val().match(expression)) {
            $(this).val($(this).val().replace(expression, ""));
        }
    });

    $("#content").on('input', function() {
        var expression = /[^a-zA-Z0-9\s]/g;
        if ($(this).val().match(expression)) {
            $(this).val($(this).val().replace(expression, ""));
        }
    });

</script>

<?php include('includes/footer.php'); ?>
