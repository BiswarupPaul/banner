<?php
session_start();
include("includes/demo_conn.php");

$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $age = $_POST['age'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $gender = $_POST['gender'] ?? '';

    $update_query = $conn->prepare("
        UPDATE registration 
        SET fname = :fname, 
            lname = :lname, 
            age = :age, 
            date_of_birth = :date_of_birth, 
            email = :email, 
            username = :username, 
            phone_number = :phone_number, 
            gender = :gender 
        WHERE R_id = :id
    ");

    $result = $update_query->execute([
        ':fname' => $fname,
        ':lname' => $lname,
        ':age' => $age,
        ':date_of_birth' => $date_of_birth,
        ':email' => $email,
        ':username' => $username,
        ':phone_number' => $phone_number,
        ':gender' => $gender,
        ':id' => $id
    ]);

    if ($result) {
        $_SESSION["edit"] = "User Updated Successfully";
        header('Location: tables.php?update=success');
        exit();
    } else {
        $_SESSION["edit"] = "User Update Failed";
        header('Location: tables.php?update=fail');
        exit();
    }
}

// Display form
$select_query = $conn->prepare("SELECT * FROM registration WHERE R_id = :id");
$select_query->execute(['id' => $id]);
$row = $select_query->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "<p>User not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <title>Edit User Registration</title>
    </head>
    <body>
        <div class="container">
            <div class="books">
                <header class="d-flex justify-content-between my-4">
                    <h1>Edit User Registration</h1>
                    <div style="margin-bottom:4px;">
                        <a href="tables.php" class="btn btn-primary">Back</a>
                    </div>
                </header>
                <form action="edit.php?id=<?php echo $row['R_id']; ?>" id="registration" method="POST">
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="fname" id="fname" value="<?php echo htmlspecialchars($row['fname']); ?>" placeholder="First Name:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="lname" id="lname" value="<?php echo htmlspecialchars($row['lname']); ?>" placeholder="Last Name:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="age" id="age" value="<?php echo htmlspecialchars($row['age']); ?>" placeholder="Age:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" placeholder="Date Of Birth:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($row['email']); ?>" placeholder="Email:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($row['username']); ?>" placeholder="Username:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>" placeholder="Phone Number:">
                    </div><br>
                    <div class="form-element my-4">
                        <input type="text" class="form-control" name="gender" id="gender" value="<?php echo htmlspecialchars($row['gender']); ?>" placeholder="Gender:">
                    </div><br>
                    <div class="form-element">
                        <input type="submit" class="btn btn-success" name="edit" id="submit" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
