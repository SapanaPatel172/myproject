
<section class="sticky-top">
  <div class="container-fluid">
    <div class="d-flex align-items-center p-1 ">
      <div class="icon flex-grow-1 ms-2">
        <img src="../../image/logo.webp" class="ms-5">
      </div>

      <div class="pe-3">
        <?php
        if (isset($_SESSION["email"])) {
          echo "<h5 class='uname'>Welcome, $name</h5>"; //if user login successfully then display name from the database
        } else {
          header("Location:login.php");
          exit();
        }
        ?>
      </div>

      <div class="dropdown pe-5">
        <!-- bydefult avatar image is set -->
        <span><img src="<?php echo ($img) ? $img : '../../image/avatar.jpg'; ?>" class="pe-5" id="dropdown-icon" height="50" width="100"></i></span>
        <div class="dropdown-content">
          <a href="../auth/profile.php">Profile</a><br>
          <a href="../auth/resetpassword.php">Reset Password</a><br>
          <a href="../auth/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'sidemenu.php';?>
