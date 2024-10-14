<?php
session_start(); // Start the session at the top

include("../demo_conn.php");

$id = $_GET['id'] ?? null; // Add null coalescing to avoid undefined index notice

if ($id) {
    $delete_query = $conn->prepare("DELETE FROM registration WHERE R_id = :id");
    
    if ($delete_query->execute([':id' => $id])) {
        
        $_SESSION["delete"] = "Record Deleted Successfully";
        header('Location: tables.php?delete=success');
    } else {
        $_SESSION["delete"] = "Record Deletion Failed";
        header('Location: tables.php?delete=fail');
    }
} else {
    // Handle the case where id is not provided or is invalid
    $_SESSION["delete"] = "Invalid Record ID";
    header('Location: tables.php?delete=fail');
}

exit(); // Ensure no further code is executed
?>