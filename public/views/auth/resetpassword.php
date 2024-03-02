<?php
session_start();
include '../../models/database.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '../partials/head.html'; ?>

</head>

<body>
  <div class="row">
    <?php include '../partials/general.php'; ?>
  </div>
  <div class="row d-flex justify-content-center">
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
      <?php include '../partials/sidemenu.php'; ?>
    </div>
    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
      <section class="vh-80">
        <form method="POST" action="resetpassword">
          <div class="container pt-5 h-80">
            <div class="row d-flex justify-content-center align-items-start h-80">
              <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card border mt-5" style="border-radius: 1rem;">
                  <div class="card-body p-5 pb-0  text-start">
                    <?php display_msg('error'); // Display error messages 
                    display_msg('success'); ?>
                    <div class="mb-md-5 mt-md-4 pb-5">
                      <div class=" form-white mb-4">
                        <label class="form-label" for="typePasswordX">Old Password</label>
                        <input type="password" id="typeoldPasswordX" name="oldpwd" class="form-control form-control-lg">
                      </div>

                      <div class=" form-white mb-4">
                        <label class="form-label" for="typePasswordX">New Password</label>
                        <input type="password" id="typePasswordX" name="newpwd" class="form-control form-control-lg">
                      </div>

                      <div class=" form-white mb-4">
                        <label class="form-label" for="typePasswordX">Confirm Password</label>
                        <input type="password" id="typeconPasswordX" name="conpwd" class="form-control form-control-lg">
                      </div>
                      <div class="d-flex justify-content-center mx-4 pt-5 mb-lg-4">
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">Save</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
</body>

</html>