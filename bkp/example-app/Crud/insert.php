<!DOCTYPE html>
<html>
<head>
    <title> </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" >

    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap-theme.min.css" >

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" ></script>
 </head>
<body>
    <div class ="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Insert using PHP</h1>
            </div>
            <div class="col-md-6">
                <form action="insert_procerss.php" method="POST">
                    <div class ="form-group">
                        <label>NAME</label>
                        <input type="text" class="form-control" name="name" required="">
                    </div>
                    <div class ="form-group">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" name="phone_number" required="">
                    </div>
                    <div class ="form-group">
                        <input type="submit" class="btn btn-primary" value="Insert">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>