<?php
session_start();
require_once('include/config.php');

$msg = ""; 

if(isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password'])); // Use md5 only if DB stores hashed passwords

    if($email != "" && $password != "") {
        try {
            $query = "SELECT id, name, email, mobile, password, create_date FROM tbladmin WHERE email=:email AND password=:password";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['adminid'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name']; // fixed session
                header("Location: index.php");
                exit;
            } else {
                $msg = "Invalid email or password!";
            }
        } catch (PDOException $e) {
            $msg = "Error: ".$e->getMessage();
        }
    } else {
        $msg = "Both fields are required!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GYM MS | Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="logo">
            <h1>GYM MS | Admin Login</h1>
        </div>
        <div class="login-box">
            <form class="login-form" method="post">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
                
                <?php if($msg){ ?>
                    <div style="color:red; margin-bottom:10px;"><strong>Error:</strong> <?php echo htmlentities($msg); ?></div>
                <?php } ?>

                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input class="form-control" name="email" type="text" placeholder="Email" autofocus>
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input class="form-control" name="password" type="password" placeholder="Password">
                </div>
                <div class="form-group btn-container">
                    <input type="submit" name="submit" value="SIGN IN" class="btn btn-primary btn-block">
                </div>
                <hr />
                <a href="../index.php">Back to Home Page</a>
            </form>
        </div>
    </section>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
