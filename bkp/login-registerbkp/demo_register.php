<?php

include("demo_conn.php");

if (isset($_POST['submit']) && $_POST['submit']=='Submit'){

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
        $target_dir = __DIR__ . '../../../login-register/admin/images/';
        print_r( $target_dir);
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
$inserts_query = $conn->prepare("INSERT INTO registration (".implode(', ', array_keys($data)).") VALUES (:".implode(', :', array_keys($data)).")");
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
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register Page</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
        <link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'>
        
        
        
    </head>
    <body>
        <div class="main">
            <div class="register">
                <h2>Registration Form</h2>
                <form id="register" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <label>First Name : </label>
                    <br>
                    <input type="text" name="fname" id="fname" placeholder="Enter your First Name">
                    <br><br>
                    <label>Last Name : </label>
                    <br>
                    <input type="text" name="lname" id="lname" placeholder="Enter your Last Name">
                    <br><br>
                    <label>Your Age : </label>
                    <br>
                    <input type="text" name="age" id="age" placeholder="How old are you ?">
                    <br><br>
                    <label>Date of Birth : </label>
                    <br>
                    <input type="text" name="date_of_birth" id="my_date_picker" placeholder="Enter your Date of Birth">
                    <br><br>
                    <label>Email : </label>
                    <br>
                    <input type="email" name="email" id="email" placeholder="Enter the valid Email" value="">
                    <br><br>
                    <label>Username : </label>
                    <br>
                    <input type="text" name="usersname" id="usersname" placeholder="Enter the Username" value="">
                    <br><br>
                    <label>Phone Number : </label>
                    <br>
                    <input type="text" name="phone_number" id="phone_number" placeholder="Enter Phone Number">
                    <br><br>
                    <label>Gender : </label>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="gender" value="male">
                    &nbsp;
                    <span id="male">Male</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="gender" value="female">
                    &nbsp;
                    <span id="female">Female</span>
                    <br><br>
                    <label>Password : </label>
                    <br>
                    <input type="password" name="password" id="password" placeholder="Enter Password"value="">
                    <br><br>
                    <label>Confirm Password : </label>
                    <br>
                    <input type="password" name="conf_password" id="conf_password" placeholder="Enter Confirm Number" value="">
                    <br><br>
                    <label>Upload Image: </label>
                    <br>
                    <input type="file" name="uploadfile[]" multiple id="uploadfile"  value="">
                    <br><br>
                    <input type="submit" value="Submit" name="submit" id="submit">
                    
                    <a href="demo_login.php">Login</a>
                </form>
            </div>
        </div>
        <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>
        
        <script>
            
            $(document).ready(function() {
                // Add custom method for strong password validation
                $.validator.addMethod("strongPassword", function(value, element) {
                    return this.optional(element) || /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*]).{8,}$/.test(value);
                }, "Password must contain at least one number, one letter, and one special character.");

                // Initialize form validation
                $("#register").validate({
                    rules: {
                        fname: {
                            required: true,
                            lettersonly: true,
                            nowhitespace: true,
                            //minlength: 10
                        },
                        lname: {
                            required: true,
                            lettersonly: true,
                            nowhitespace: true
                        },
                        age: {
                            required: true
                        },
                        date_of_birth: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        usersname: {
                            required: true
                        },
                        phone_number: {
                            required: true,
                            minlength: 10
                        },
                        gender: {
                            required: true
                        },
                        password: {
                            required: true,
                            strongPassword: true, // Custom rule for strong password
                            minlength: 8
                        },
                        conf_password: {
                            required: true,
                            //minlength: 8
                            equalTo: '#password'
                        }
                    },
                    messages :{
                        fname : {
                            required : '<br>Enter your frist name'
                        },
                        lname : {
                            required : '<br>Enter your last name'
                        },
                        age : {
                            required : '<br>Enter your age'
                        },
                        date_of_birth : {
                            required : '<br>Enter your date of birth'
                        },
                        email: {
                            required: "Enter your email",
                            email: "Enter valid email",
                        },
                        usersname: {
                            required: 'Enter your Username'
                        },
                        phone_number : {
                            required : '<br>Enter your phonenumber',
                            minlength: '<br>Enter valid phonenumber'
                        },
                        gender : {
                            required : '<br>Enter your gender'
                        },
                        password: {
                            required : 'Enter password',
                            strongPassword: 'Password must contain at least one number, one letter, and one special character.',
                            minlength: "Your password must be at least 8 characters long"
                            //minlength: '<br>Enter valid password'
                        },
                        conf_password : {
                            required: 'Enter Confirm Password',
                            //minlength: '<br>Enter valid password'
                            equalTo: 'Password and Confirm Password should be match.'
                        }
                    },
                        
                    submitHandler: function(form) {
                        // some other code
                        // maybe disabling submit button
                        // then:
                        form.submit();
                    }
                });
                // Datepicker initialization
                $("#my_date_picker").datepicker({
                        changeMonth: true, 
                        changeYear: true, 
                        dateFormat: "dd/mm/yy",
                        yearRange: "-90:+00"
                    });

                // Input mask for phone number
                $('#phone_number').inputmask("9999999999");

                // Restrict input to letters for first and last name fields
                $("#fname, #lname").on('input', function() {
                    var expression = /[^a-zA-Z]/g;
                    if ($(this).val().match(expression)) {
                            $(this).val($(this).val().replace(expression, ""));
                    }
                });

                $("#usersname").on('input', function() {
                    var expression = /[^a-zA-Z0-9]/g;
                    if ($(this).val().match(expression)) {
                            $(this).val($(this).val().replace(expression, ""));
                    }
                });

                // Restrict input to numbers for phone number field
                $("#phone_number").on('input', function() {
                    var expression = /[^0-9]/g;
                    if ($(this).val().match(expression)) {
                            $(this).val($(this).val().replace(expression, ""));
                    }
                });
            });
        </script>
    </body>
</html>
