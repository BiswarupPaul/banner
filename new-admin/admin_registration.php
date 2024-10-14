
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Register Page</title>
        <link rel="stylesheet" href="css/admin_regis.css" type="text/css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
        <link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'>
        
        
        
    </head>
    <body>
        <div class="main">
            <div class="register">
                <h2>Admin Registration Form</h2>
                <form id="admin_register" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                    <input type="hidden" name="action" value="admin-regis">
                    <input type="submit" value="Submit" name="submit" id="submit">
                    
                    <a href="index.php">Login</a>
                </form>
            </div>
        </div>
        <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>
        
     

        





    <script>

        jQuery(document).ready(function () {
            
  // Add custom method for strong password validation
            $.validator.addMethod("strongPassword", function(value, element) {
                return this.optional(element) || /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*]).{8,}$/.test(value);
            }, "Password must contain at least one number, one letter, and one special character.");

            //CUSTOM FORM
            jQuery("#admin_register").validate({
                ignore: [],
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
                    errorClass: 'text-danger font-italic text-left small',
                    errorElement: 'p',
                    highlight: function (element) {
                        jQuery(element).closest('.form-control').addClass('is-invalid');
                    },
                    unhighlight: function (element) {
                        jQuery(element).closest('.form-control').removeClass('is-invalid');
                    },
                    errorPlacement: function (error, element) {
                        element.after(error);
                    },
                    submitHandler: function (form) {
                 
                    var form = jQuery('#admin_register')[0];
                    var formData = new FormData(form);//store the all datas of forms
                    jQuery.ajax({
                        url: 'form-submit.php',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (response) {
                            //console.log(response);
                            window.location.href = "thank-you.php";
                        },
                        error: function() {
                            alert('An error occurred. Please try again.');
                        }
                        
                    });
                    return false;
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
