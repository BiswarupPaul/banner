<?php

include("includes/demo_conn.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['action']) && $_POST['action']='admin-regis'){

        unset($_POST['conf_password']);
        unset($_POST['submit']);

        //echo '<pre>',print_r($_POST),'</pre>'; die;


    
        // File upload handling
        //$filename = $_FILES["uploadfile"]["name"];
        //$target_dir = __DIR__ . '/startbootstrap-sb-admin-2-master/images/';
        //$target_file = $target_dir . basename($filename);
        //$file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        //$valid_extension = array("png", "jpeg", "jpg");

        //if (in_array($file_extension, $valid_extension)) {
            //if ($_FILES['uploadfile']['error'] === UPLOAD_ERR_OK) {
                // Move the uploaded file to the target directory
                    //(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $target_file)) ;
                // Array to store paths of uploaded images
                
                $target_dir = __DIR__ . '/images/';
                $uploaded_files = [];

                foreach ($_FILES["uploadfile"]["name"] as $key => $val) {
                    if ($_FILES['uploadfile']['error'][$key] === UPLOAD_ERR_OK) {
                        $random = rand(11111, 99999);
                        $file = $random . '_' . $val;
                        $target_file = $target_dir . $file;
            
                        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'][$key], $target_file)) {
                            $uploaded_files[] = $file; // Collect uploaded file names
                        } else {
                            echo "Error uploading file " . htmlspecialchars($val) . ".<br>";
                        }
                    } else {
                        echo "Error code " . $_FILES['uploadfile']['error'][$key] . " for file " . htmlspecialchars($val) . ".<br>";
                    }
                }
        
            // Convert uploaded files array to a comma-separated string
            $image_paths = implode(', ', $uploaded_files);



        $data = [
        //'image' => $filename, 
        'image' => $image_paths,  
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'age' => $_POST['age'],
        //$date_of_birth = $_POST['date_of_birth'];
        'date_of_birth' => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date_of_birth']))),
        'email' => $_POST['email'],
        'username' => $_POST['usersname'],
        'phone_number' => $_POST['phone_number'],
        'gender' => $_POST['gender'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        //$inserts_query = "INSERT into registration (fname, lname, age, date_of_birth, email, username, phone_number, gender, password) values ('$fname', '$lname', '$age', '$date_of_birth', '$email', '$usersname', '$phone_number', '$gender', '$hashed_password')";
        $inserts_query = $conn->prepare("INSERT INTO admin_registration (".implode(', ', array_keys($data)).") VALUES (:".implode(', :', array_keys($data)).")");
        $inserts_query->execute($data);

        /*$inserts_query = $conn->prepare("
            INSERT INTO 
                registration 
                    (fname, lname, age, date_of_birth, email, username, phone_number, gender, password) 
                VALUES 
                    (:fname, :lname, :age, :date_of_birth, :email, :usersname, :phone_number, :gender, :hashed_password)");
        $inserts_query->execute([
            ':fname' => $fname,
            ':lname' => $lname,
            ':age' => $age,
            ':date_of_birth' => $date_of_birth,
            ':email' => $email,
            ':usersname' => $username,
            ':phone_number' => $phone_number,
            ':gender' => $gender,
            ':hashed_password' => $hashed_password
        ]);*/
        //echo $inserts_query;
        //$inserts_query->debugDumpParams();
        //die();
        //echo '<pre>',print_r($inserts_query),'</pre>';
        //$result = mysqli_query($conn, $inserts_query);

        //if($result)
        //if($conn->exec($inserts_query))
        if($inserts_query == TRUE)
        {
            //$_SESSION['fname'] = $fname;
            echo "Insert Successfull";
            //header('location:./demo_register.php?insert=success');
        }
        else
        {
            echo "Insert Unsuccessfull";
            //$error = mysqli_error($conn);
            //header('location:./demo_register.php?insert=fail&error='.$error);
            error_log("Database error: " . $e->getMessage(), 3, 'error_log.txt');
        }

        //mysqli_close($conn);
        //$conn->close();
    } 
    

    
    if (isset($_POST['action']) && $_POST['action'] == 'banner-form') {

        //unset($_POST['conf_password']);
        //unset($_POST['submit']);

        // File upload handling
        $uploaded_files = [];
        $target_dir = __DIR__ . '/images/';
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

        $image_paths = implode(', ', $uploaded_files);
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? '';
        $id = $_POST['id'] ?? null;

        $data = [
            'title' => $title,
            'image' => $image_paths,
            'content' => $content,
            'status' => $status
        ];

        
        if ($action === 'publish') {
            $inserts_query = $conn->prepare("INSERT INTO banner (title, image, content, status) VALUES (:title, :image, :content, :status)");
            $result = $inserts_query->execute($data);
            echo $result ? "Insert Successful" : "Insert Unsuccessful";
        } elseif ($action === 'update' && $id) {
            $data['id'] = $id;
            $update_query = $conn->prepare("UPDATE banner SET title = :title, image = :image, content = :content, status = :status WHERE id = :id");
            $result = $update_query->execute($data);
            echo $result ? "Update Successful" : "Update Unsuccessful";
        }
    


        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $id = $_GET['id'] ?? null;
        
            if ($id) {
                try {
                    $delete_query = $conn->prepare("DELETE FROM banner WHERE id = :id");
                    $result = $delete_query->execute(['id' => $id]);
        
                    if ($result) {
                        header('Location: list-banner.php?delete=success');
                        exit();
                    } else {
                        header('Location: list-banner.php?delete=fail');
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                    error_log("Database error: " . $e->getMessage(), 3, 'error_log.txt');
                }
            } else {
                header('Location: list-banner.php?delete=fail');
                exit();
            }
        }
        else {
        $id = $_GET['id'] ?? null;
        if ($id) {
            try {
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
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                error_log("Database error: " . $e->getMessage(), 3, 'error_log.txt');
            }
        }
        }


    }


}

?>