<?php
session_start();
error_reporting(0);
require_once('include/config.php');

if(strlen($_SESSION["uid"]) == 0) {   
    header('location:login.php');
} else {

if(isset($_POST['submit'])) {
    $uid = $_SESSION['uid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $address = $_POST['address'];

    $sql = "UPDATE tbluser SET fname=:fname, lname=:lname, mobile=:mobile, city=:city, state=:state, address=:Address WHERE id=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname',$fname,PDO::PARAM_STR);
    $query->bindParam(':lname',$lname,PDO::PARAM_STR);
    $query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
    $query->bindParam(':city',$city,PDO::PARAM_STR);
    $query->bindParam(':state',$state,PDO::PARAM_STR);
    $query->bindParam(':Address',$address,PDO::PARAM_STR);
    $query->bindParam(':uid',$uid,PDO::PARAM_STR);
    $query->execute();

    $success_msg = "Profile has been updated successfully!";
}

?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym Management System | User Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>

    <style>
        .profile-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .profile-card:hover {
            transform: translateY(-5px);
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0,123,255,0.2);
        }
        .site-btn {
            transition: all 0.3s;
        }
        .site-btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<?php include 'include/header.php'; ?>

<section class="page-top-section py-5 bg-primary text-white text-center">
    <div class="container">
        <h2>User Profile</h2>
    </div>
</section>

<section class="contact-page-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if(isset($success_msg)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $success_msg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="profile-card">
                    <h4 class="mb-4">Update Your Profile</h4>
                    <form method="post">
                        <div class="row g-3">
                            <?php 
                            $uid = $_SESSION['uid'];
                            $sql ="SELECT id, fname, lname, email, mobile, address, state, city FROM tbluser WHERE id=:uid";
                            $query= $dbh -> prepare($sql);
                            $query->bindParam(':uid',$uid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if($query->rowCount() > 0) {
                                foreach($results as $result) { ?>  

                            <div class="col-md-6">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control" value="<?= $result->fname ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control" value="<?= $result->lname ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?= $result->email ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" value="<?= $result->mobile ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" id="state" class="form-control" value="<?= $result->state ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control" value="<?= $result->city ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" value="<?= $result->address ?>" required>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" name="submit" class="btn btn-primary site-btn">Update Profile</button>
                            </div>

                            <?php } } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'include/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
