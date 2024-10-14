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
        $select_query = $conn->prepare("SELECT image FROM blog WHERE id = :id");
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
        $delete_query = $conn->prepare("DELETE FROM blog WHERE id = :id");
        $result = $delete_query->execute(['id' => $id]);

        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Blog Deleted Successfully";
            header('location:list-blogs.php?delete=success');
            exit();
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            $error = $conn->errorInfo();
            header('location:list-blogs.php?delete=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? '';
    $id = $_POST['id'] ?? null;

    $new_images = []; // Initialize this to store multiple images
    $existing_images = ''; // Initialize this to avoid undefined variable warning
    $new_image_list = '';

    // Handle file uploads
    if (!empty($_FILES["uploadfile"]["name"][0])) {
        foreach ($_FILES['uploadfile']['name'] as $key => $name) {
            if ($_FILES['uploadfile']['error'][$key] === UPLOAD_ERR_OK) {
                $random = rand(11111, 99999);
                $file = $random . '_' . basename($name);
                $target_file = $target_dir . $file;

                if (move_uploaded_file($_FILES['uploadfile']['tmp_name'][$key], $target_file)) {
                    $new_images[] = $file; // Collect all new images
                } else {
                    echo "Error uploading file " . htmlspecialchars($name) . ".<br>";
                }
            } else {
                echo "Error code " . $_FILES['uploadfile']['error'][$key] . " for file " . htmlspecialchars($name) . ".<br>";
            }
        }
        $new_image_list = implode(', ', $new_images); // Save as comma-separated string
    }

    if ($action == 'publish') {
        $data = [
            'title' => $title,
            'category' => $category,
            'image' => $new_image_list,
            'content' => $content,
            'status' => $status
        ];
        $inserts_query = $conn->prepare("INSERT INTO blog (title, image, category, content, status) VALUES (:title, :image, :category, :content, :status)");
        $result = $inserts_query->execute($data);
        
        if($result)
        {
            //echo "Insert SuccessfulL";
            session_start();
            $_SESSION["create"] = "Blog Added Successfully";
            header('location:list-blogs.php?insert=success');
        }
        else
        {
            //echo "Insert UnsuccessfulL";
            //$error = mysqli_error($conn);
            $error = $conn->errorInfo();
            header('location:list-blogs.php?insert=fail&error='. urlencode($error[2])); // Use urlencode for error message
        }
        //echo $result ? "Insert Successful" : "Insert Unsuccessful";
    }

    if ($action == 'update' && $id) {
        // Fetch existing image if any
        if (!$new_images) {
            $select_query = $conn->prepare("SELECT image FROM blog WHERE id = :id");
            $select_query->execute(['id' => $id]);
            $row = $select_query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $existing_images = $row['image']; // Get existing images
            }
        } else {
            // Remove existing images if new images are uploaded
            $select_query = $conn->prepare("SELECT image FROM blog WHERE id = :id");
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
            'category' => $category,
            'image' => $new_image_list ?: $existing_images, // Use the new images if uploaded, otherwise keep existing
            'content' => $content,
            'status' => $status,
            'id' => $id
        ];

        $update_query = $conn->prepare("UPDATE blog SET title = :title, image = :image, category = :category, content = :content, status = :status WHERE id = :id");
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
    }
}

$id = $_GET['id'] ?? null;
$image_paths = '';

if ($id) {
    $select_query = $conn->prepare("SELECT * FROM blog WHERE id = :id");
    $select_query->execute(['id' => $id]);
    $row = $select_query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $title = htmlspecialchars($row['title']);
        $content = htmlspecialchars($row['content']);
        $category = htmlspecialchars($row['category']);
        $status = htmlspecialchars($row['status']);
        $image_paths = htmlspecialchars($row['image']);
    } else {
        echo "<p>Blog not found.</p>";
        exit();
    }
}
?>

<div class="container">
    <h2>Blogs</h2>
    <div class="row">
        <div class="main">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary mt-2">Publish blog/article</h5>
                </div>
                <div class="card-body"> 
                    <form id="blog" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <!-- Blog Title -->
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="title" class="form-label">Blog Title</label>
                                <input class="form-control" name="title" type="text" id="title" placeholder="Title" value="<?= htmlspecialchars($title ?? '') ?>">
                            </div>

                            <div class="col-md-5">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" name="category">
                                    <option value="">Select Category</option>
                                    <?php 
                                    $select_query = $conn->prepare("SELECT * FROM categories");
                                    $select_query->execute();
                                    while ($cat = $select_query->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($cat['cat_id'] == ($category ?? '')) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($cat['cat_id']) . '" ' . $selected . '>' . htmlspecialchars($cat['cat_name']) . '</option>'; 
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Blog Image Upload -->
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="uploadfile" class="form-label">Feature Images</label>
                                <input class="form-control" type="file" name="uploadfile[]" >
                                <?php if ($image_paths): ?>
                                    <div class="mt-3">
                                        <h4>Existing Images:</h4>
                                        <?php 
                                        $image_files = explode(', ', $image_paths); 
                                        foreach ($image_files as $image_file): ?>
                                            <?php if (file_exists($target_dir . $image_file)): ?>
                                                <img src="images/<?= htmlspecialchars($image_file) ?>" alt="Blog Image" style="width: 100px; height: auto; margin-right: 10px;">
                                            <?php else: ?>
                                                <p>Image file not found: <?= htmlspecialchars($image_file) ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Blog Content -->
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="content" class="form-label">Blog/Description</label>
                                <textarea class="form-control" name="content" id="blog_content" rows="5"><?= htmlspecialchars($content ?? '') ?></textarea>
                                
                                <div id="wordCount">Words: 0/200</div> <!-- Initial count display -->
                                <div id="warning" style="color: red; display: none;">Word limit exceeded!</div> <!-- Warning message -->
                            </div>
                        </div>


                        
                        <!-- Status -->
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" <?= (isset($status) && $status == '1') ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= (isset($status) && $status == '0') ? 'selected' : '' ?>>Inactive</option>
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
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<!-- <script>
    CKEDITOR.replace('blog_content', {
        extraPlugins: 'wordcount',
        wordcount: {
            showWordCount: true,
            showCharCount: false,
            countSpacesAsChars: true,
            countHTML: false,
            maxWordCount: 200,
            maxCharCount: 2000
        }
    });

    CKEDITOR.instances.blog_content.on('contentDom', function() {
        this.document.on('keyup', function() {
            var text = CKEDITOR.instances.blog_content.getData();
            var wordCount = text.split(/\s+/).filter(Boolean).length;
            $('#display_count').text(wordCount);
            $('#word_left').text(200 - wordCount);

            if (wordCount > 200) {
                var trimmedText = text.split(/\s+/, 200).join(' ');
                CKEDITOR.instances.blog_content.setData(trimmedText);
            }
        });
    });
</script> -->


<!-- <script>
  $(document).ready(function () {
    ClassicEditor
      .create(document.querySelector('#blog_content'))
      .then(editor => {
        editor.model.document.on('change:data', () => {
          const data = editor.getData();
          const wordCount = data.match(/\b\w+\b/g) ? data.match(/\b\w+\b/g).length : 0;

          $('#wordCount').text('Words: ' + wordCount + '/20');

          if (wordCount > 20) {
            // Limit the content to the first 20 words
            const trimmedData = data.match(/\b\w+\b/g).slice(0, 20).join(' ');
            editor.setData(trimmedData);
          }
        });
      })
      .catch(error => {
        console.error(error);
      });
  });
</script> -->

<script>
  $(document).ready(function () {
    ClassicEditor
      .create(document.querySelector('#blog_content'))
      .then(editor => {
        const maxWords = 200; // Set your word limit here
        const $wordCountDisplay = $('#wordCount');
        const $warningDisplay = $('#warning');

        // Function to update the word count
        const updateWordCount = () => {
          const data = editor.getData();
          const wordCount = data.match(/\b\w+\b/g) ? data.match(/\b\w+\b/g).length : 0;

          // Display word count or initial message based on input
          if (wordCount === 0) {
            $wordCountDisplay.text('Words: 0/200'); // Display this only when textarea is empty
          } else {
            $wordCountDisplay.text('Words: ' + wordCount + '/' + maxWords); // Update word count
          }

          // Show warning if word count exceeds limit
          if (wordCount > maxWords) {
            const trimmedData = data.match(/\b\w+\b/g).slice(0, maxWords).join(' ');
            editor.setData(trimmedData); // Trim the data in the editor
            $warningDisplay.text('Word limit exceeded!').show(); // Show warning
          } else {
            $warningDisplay.hide(); // Hide warning if within limit
          }
        };

        // Attach the update function to the change event
        editor.model.document.on('change:data', updateWordCount);
        
        // Initialize word count display
        $wordCountDisplay.text('Words: 0/200'); // Set initial display
      })
      .catch(error => {
        console.error(error);
      });
  });
</script>








<?php include('includes/footer.php'); ?>