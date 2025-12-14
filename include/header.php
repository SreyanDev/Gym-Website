<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Safely get user id from session
$uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';

// Get current page filename
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="header-section">
    <div class="header-top">
        <div class="row m-0">
            <div class="col-md-6 d-none d-md-block p-0">
                <!-- Optional top info -->
            </div>
            <div class="col-md-6 text-left text-md-right p-0">
                <?php if(strlen($uid) == 0): ?>
                    <div class="header-info d-none d-md-inline-flex">
                        <i class="material-icons">account_circle</i>
                        <a href="login.php"><p>Login</p></a>
                    </div>
                <?php else: ?>
                    <div class="header-info d-none d-md-inline-flex">
                        <i class="material-icons">account_circle</i>
                        <a href="profile.php"><p>My Profile</p></a>
                    </div>
                    <div class="header-info d-none d-md-inline-flex">
                        <i class="material-icons">brightness_7</i>
                        <a href="changepassword.php"><p>Change Password</p></a>
                    </div>
                    <div class="header-info d-none d-md-inline-flex">
                        <i class="material-icons">logout</i>
                        <a href="logout.php"><p>Logout</p></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <a href="index.php" class="site-logo" style="display:flex; align-items:center; font-weight:bold; font-size:26px; color:#fff;">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKOkVahRsBOnYjcZHJDkgix8VReyk8KksaUA&s" 
         alt="Logo" style="height:50px; margin-right:10px; border-radius:5px;">
    FIT-FORGE
    <small style="margin-top:10%; display:block; font-size:14px;">BE-STRONG💪</small>
</a>


        <div class="container">
            <ul class="main-menu">
                <li><a href="index.php" class="<?= ($currentPage == 'index.php') ? 'active' : '' ?>">Home</a></li>
                <li><a href="about.php" class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>">About</a></li>
                <li><a href="contact.php" class="<?= ($currentPage == 'contact.php') ? 'active' : '' ?>">Contact</a></li>

                <?php if(strlen($uid) == 0): ?>
                    <li><a href="admin/" class="<?= ($currentPage == 'admin/index.php') ? 'active' : '' ?>">Admin</a></li>
                <?php else: ?>
                    <li><a href="booking-history.php" class="<?= ($currentPage == 'booking-history.php') ? 'active' : '' ?>">Booking History</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>
