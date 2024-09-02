<?php
session_start();
?>

<?php
    $usernameError = "";
    $passwordError = "";

    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username))
        {
            $usernameError = "Username is Required";
        }
        else
        {
            $username = trim($username);
            $username = htmlspecialchars($username);
            if(!preg_match("/^[a-zA-Z]+$/", $username))
            {
                $usernameError = "Name should contain only char and space";
            }
        }

        if(empty($password))
        {
            $passwordError = "Password is Required";
        }
        else
        {
            if(strlen($password) < 3 )
            {
                $passwordError = "Atleast 3 digits.";
            }
            elseif(!preg_match("#[0-9]+#", $password))
            {
                $passwordError = "Atleast one digits.";
            }
            /*elseif(!preg_match("#[a-z]+#", $password))
            {
                $passwordError = "Atleast one small char.";
            }*/
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="login-style.css">
        <title>Login New User</title>
    </head>
    <body>
        <div class="center">
            <h1>Login</h1>

            <form action="#" method="POST" autocomplete="off">

            <div class="form">
                <input type="text" name="username" class="textfiled" placeholder="Username or Email">
                <span style="color: red;"><?php echo $usernameError ?></span>
                <input type="text" name="password" class="textfiled" placeholder="Password">
                <span style="color: red;"><?php echo $passwordError ?></span>
            
                <div class="forgetpass"><a href="#" class="link" onclick="message()">Forget Password ?</a></div>

                <input type="submit" name="login" value="Login" class="btn">
                <div class="signup">New Member ? <a href="register.php" class="link">SignUp Here</a></div>
            </div>
        </div>
        </form>
        <script>
            function message()
            {
                alert("Remember Password");
            }
        </script>

    </body>
</html>

<?php
    include("db_conn.php");

    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $pwd = $_POST['password'];

        //$query = "SELECT * FROM registration WHERE email='$username' && password='$pwd'";
        $query = "SELECT * FROM registration WHERE email='$username' OR username='$username'";
        $data=mysqli_query($conn, $query);

        $total= mysqli_num_rows($data);
        //echo "$total";

        if($total == 1)
        {
            $row = mysqli_fetch_assoc($data);

            $hashedPassword = $row['password'];

            if(password_verify($pwd, $hashedPassword))
            {
                
                
                //echo "Login Ok";
                //session_start();
                $_SESSION['user_name'] = $username;
                $_SESSION['pwd'] = $pwd;
                header('location:demo_intro.php');
            }
            else
            {
                echo "Login Failed";
            }   
        }
        else
        {
            echo "//Login Failed";
        }
    }

?>
