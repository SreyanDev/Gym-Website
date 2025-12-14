<?php 
session_start();
error_reporting(0);
require_once('include/config.php');

if(strlen($_SESSION["uid"]) == 0) {   
    header('location:login.php');
} else {
    $uid = $_SESSION['uid'];
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>User | Booking History</title>
    <meta charset="UTF-8">
    <meta name="description" content="Ahana Yoga HTML Template">
    <meta name="keywords" content="yoga, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="css/nice-select.css"/>
    <link rel="stylesheet" href="css/slicknav.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

    <!-- Header Section -->
    <?php include 'include/header.php';?>

    <!-- Page top Section -->
    <section class="page-top-section set-bg" data-setbg="img/page-top-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 m-auto text-white">
                    <h2>Booking History</h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking History Table Section -->
    <section class="contact-page-section spad overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th hidden>bookingid</th>
                                <th hidden>Name</th>
                                <th hidden>Email</th>
                                <th>Booking Date</th>
                                <th>Title</th>
                                <th>Package Duration</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Category Name</th>
                                <th>Package Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT t1.id AS bookingid,
                                           t3.fname AS Name, 
                                           t3.email AS email,
                                           t1.booking_date AS bookingdate,
                                           t2.titlename AS title,
                                           t2.PackageDuration AS PackageDuration,
                                           t2.Price AS Price,
                                           t2.Description AS Description,
                                           t4.category_name AS category_name,
                                           t5.PackageName AS PackageName
                                    FROM tblbooking AS t1
                                    JOIN tbladdpackage AS t2 ON t1.package_id = t2.id
                                    JOIN tbluser AS t3 ON t1.userid = t3.id
                                    JOIN tblcategory AS t4 ON t2.category = t4.id
                                    JOIN tblpackage AS t5 ON t2.PackageType = t5.id
                                    WHERE t1.userid = :uid";

                            $query = $dbh->prepare($sql);
                            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;

                            if($query->rowCount() > 0){
                                foreach($results as $result) { ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td hidden><?php echo htmlentities($result->bookingid);?></td>
                                        <td hidden><?php echo htmlentities($result->Name);?></td>
                                        <td hidden><?php echo htmlentities($result->email);?></td>
                                        <td><?php echo htmlentities($result->bookingdate);?></td>
                                        <td><?php echo htmlentities($result->title);?></td>
                                        <td><?php echo htmlentities($result->PackageDuration);?></td>
                                        <td><?php echo htmlentities($result->Price);?></td>
                                        <td><?php echo htmlentities($result->Description);?></td>
                                        <td><?php echo htmlentities($result->category_name);?></td>
                                        <td><?php echo htmlentities($result->PackageName);?></td>
                                        <td>
                                            <a href="booking-details.php?bookingid=<?php echo htmlentities($result->bookingid);?>">
                                                <button class="btn btn-primary" type="button">View</button>
                                            </a>
                                        </td>
                                    </tr>
                            <?php $cnt++; } 
                            } else { ?>
                                <tr>
                                    <td colspan="12" class="text-center">No bookings found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include 'include/footer.php'; ?>

    <div class="back-to-top"><img src="img/icons/up-arrow.png" alt=""></div>

    <!-- Scripts -->
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
<?php } ?>
