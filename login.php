<?php
session_start();
error_reporting(0);
require_once('include/config.php');

$msg = ""; 

if(isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password'])); // keep MD5 for your current DB

    if($email != "" && $password != "") {
        try {
            $query = "SELECT id, fname, lname, email, mobile, password, address, create_date 
                      FROM tbluser 
                      WHERE email = :email AND password = :password";

            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row) {
                // Login successful
                $_SESSION['uid'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['fname'];

                header("Location: index.php");
                exit();
            } else {
                $msg = "Invalid username and password!";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $msg = "Both fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
     <title>FIT-FORGE-GYM</title>
	<link rel="icon" href="img/icons/favicon.ico" type="image/png">
    <meta charset="UTF-8">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="css/nice-select.css"/>
    <link rel="stylesheet" href="css/magnific-popup.css"/>
    <link rel="stylesheet" href="css/slicknav.min.css"/>
    <link rel="stylesheet" href="css/animate.css"/>
    <link rel="stylesheet" href="css/style.css"/>

    <style>
        /* User image styling */
		.user-logo img {
			width: 120px;
			height: 120px;
			border-radius: 50%;
			object-fit: cover;
			border: 1px solid #1d1b19ff;
			margin-top: 70px; /* move image down by 20px */
		}

    </style>
</head>
<body>

    <!-- Header Section -->
    <?php include 'include/header.php';?>

    <!-- Page top Section -->
    <section class="page-top-section set-bg" data-setbg="img/page-top-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 m-auto text-white">
                    <h2>Login</h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Section -->
    <section class="pricing-section spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-sm-8">
                    <div class="pricing-item entermediate">
                        <div class="pi-top"></div>

                        <!-- User Logo Section -->
                        <div class="pi-price text-center d-flex flex-column align-items-center justify-content-center">
                            <div class="user-logo mb-3">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKOkVahRsBOnYjcZHJDkgix8VReyk8KksaUA&s" 
                                     alt="User Logo">
                            </div>
                            <h3 class="mb-1">User</h3>
                            <p>Login</p>
                        </div>

                        <?php if($msg){?>
                            <div class="succWrap" style="color:red; text-align:center; margin-bottom:10px;">
                                <strong>Error</strong>: <?php echo htmlentities($msg); ?> 
                            </div>
                        <?php }?>

                        <form class="singup-form contact-form" method="post">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input type="text" name="email" id="email" placeholder="Your Email" autocomplete="off" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-2">
                                    <input type="submit" id="submit" name="submit" value="Login" class="site-btn sb-gradient w-100" style="border: 1px solid #000;">


                                </div>
                                <div class="col-md-6">
                                    <a href="registration.php" class="site-btn sb-gradient w-100 text-center" style="border: 1px solid #000;">Registration</a>


                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'include/footer.php'; ?>

    <div class="back-to-top"><img src="img/icons/up-arrow.png" alt=""></div>

    <!-- JS Scripts -->
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
