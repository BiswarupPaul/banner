<?php
include('includes/demo_conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_image']) && isset($_POST['id'])) {
    $delete_image = $_POST['delete_image'];
    $id = $_POST['id'];
    
    $target_dir = __DIR__ . '/images/';

    // Fetch the existing banner images
    $select_query = $conn->prepare("SELECT banner_image FROM home_banner WHERE id = :id");
    $select_query->execute(['id' => $id]);
    $row = $select_query->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        $banner_images = explode(', ', $row['banner_image']);
        
        if (($key = array_search($delete_image, $banner_images)) !== false) {
            unset($banner_images[$key]);
            $banner_images = array_filter($banner_images); // Remove any empty values
            $bannerimage_paths = implode(', ', $banner_images);

            // Delete the file from the server
            $file_to_delete = $target_dir . $delete_image;
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }

            // Update the database
            $update_query = $conn->prepare("UPDATE home_banner SET banner_image = :banner_image WHERE id = :id");
            $update_query->execute(['banner_image' => $bannerimage_paths, 'id' => $id]);

            echo "Image deleted successfully.";
            header('Location: banner1.php?');
            //echo header('list-banner.php');
        } else {
            echo "Image not found in banner.";
        }
    } else {
        echo "Banner not found.";
    }
} else {
    echo "Invalid request.";
}
?>
