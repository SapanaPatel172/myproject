<?php
session_start();
include '../partials/generalfunctions.php';
$get_token=$_REQUEST['token'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '../partials/head.html'; ?>
</head>

<body>
  <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Enter New Password</p>

                  <form class="mx-1 mx-md-4" method="post" action="cdpassword?token=<?php echo $get_token ?>">
                    <?php display_msg('error'); // Display error messages 
                    ?>
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class=" flex-fill mb-0">
                        <input type="password" id="form3Example4c" class="form-control" name="newpwd" placeholder="Enter Password" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                      <div class=" flex-fill mb-0">
                        <input type="password" id="form3Example4cd" class="form-control" name="conpwd" placeholder="Enter Confirm Pasword" />
                      </div>
                    </div>


                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button type="submit" class="btn btn-primary btn-lg" name="submit">save</button>
                    </div>

                </div>
                </form>

                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                  <img src="../../image/bg.webp" class="img-fluid" alt="Sample image">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>