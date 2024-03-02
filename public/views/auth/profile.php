<?php
session_start();
include '../../models/database.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';
include '../partials/validator.class.php';
$_SESSION['error'] = [];
$_SESSION['success'] = [];
if (isset($_REQUEST['submit'])) {

  //check isset or not 
  $validator = new Validator();
  $isset_name = $validator->validatisset('edit_name', 'name');
  $isset_mobile = $validator->validatisset('edit_mobile', 'mobile number');

  if (isset($_FILES['edit_avatar'])) {

    if ($isset_name && $isset_mobile) {

      //check empty or not 
      $ept_name = $validator->validatempty('edit_name', 'name');
      $ept_mobile = $validator->validatempty('edit_mobile', 'mobile number');


      if ($ept_name && $ept_mobile) {

        $ename = htmlspecialchars($_REQUEST['edit_name'], ENT_QUOTES, 'UTF-8');
        $emobile = $_REQUEST['edit_mobile'];
        $eimage = $_FILES["edit_avatar"];
        $tablename = "users";

        //check mobile number must be 10 digits and only have digits
        if (strlen($emobile) == 10 && ctype_digit($emobile)) {

          $targetDir = "../../image/";
          $targetFile = $targetDir . basename(time() . '_' . $_FILES["edit_avatar"]["name"]);

          // Check if a new image is selected
          if (!empty($_FILES["edit_avatar"]["tmp_name"]) && is_uploaded_file($_FILES["edit_avatar"]["tmp_name"])) {

            // Check the file type extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $allowedExtensions)) {

              // Move the new image to the target directory
              move_uploaded_file($_FILES["edit_avatar"]["tmp_name"], $targetFile);

              // Delete the old image 
              if (!empty($img) && file_exists($img) && $img !== '../../image/avatar.jpg') {
                unlink($img);
              }

              $avatarimg = $targetFile; // Use the new image path
            } else {
              $_SESSION['error'][] = "Invalid file type. Allowed types: " . implode(', ', $allowedExtensions);
            }
          } else {
            // No new image selected, retain the old image path
            $avatarimg = $img;
          }
          if (isset($avatarimg)) {
            //if new image is not seleted then old insert
            $data = ['name' => $ename, 'mobile' => $emobile, 'avatarimg' => $avatarimg];
            $condition = ['id' => $id];
            $obj = new database();
            $update_result = $obj->updatedata($tablename, $data, $condition);
            //$img=$avatarimg;
            
            if ($update_result) {
              header("Location: " . $_SERVER['PHP_SELF']);
              $_SESSION['success'][] = "profile update successfully...";
              header("Location:profile.php");
            } else {
              $_SESSION['error'][] = "Error updating user..";
              header("Location:profile.php");
            }
          }
        } else {
          $_SESSION['error'][] = "Mobile number must be 10 digits and enter only digits";
        }
      }
    }
  } else {
    $_SESSION['error'][] = "image not set";
  }
}
?>
<html>

<head>
  <?php include '../partials/head.html'; ?>
</head>

<body>
  <?php include '../partials/general.php'; ?>
  <div class="row">
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 ">
      <?php include '../partials/sidemenu.php'; ?>
    </div>
    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
      <div class="container pt-5">
        <form method="post" action="profile.php" enctype="multipart/form-data">
          <table class="table caption-top">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile No.</th>
                <th scope="col">Profilepicture</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $id; ?></td>
                <td class="name"><?php echo $name; ?></td>
                <td><?php echo $email; ?></td>
                <td class="mobile"><?php echo $mobile; ?></td>
                <td> <img src="<?php echo ($img) ? $img : '../../image/avatar.jpg'; ?>" id="avatar" height="50px" width="50px"><br>
                  <span id="avatarError" class="error"></span>
                </td>

                <td><button type="button" onclick="editRow()" class="btn btn-info edit" name="edit">Edit</button>
                  <input type="submit" value="submit" class="save btn btn-info" name="submit" style="display: none;">
                  <input type="file" name="edit_avatar" id="edit_avatar" style="display: none;" onchange="validateImageExtension()">
                </td>
              </tr>
            </tbody>
          </table>


          <div class="d-flex align-items-center">
            <?php  // Display error and success messages 
            display_msg('error');
            display_msg('success') ?>
          </div>
        </form>
      </div>
      <script>
        function editRow() {
          var name = $('.name').text();
          var mobile = $('.mobile').text();
          $('.name').html('<input type="text" id="edit_name" name="edit_name" required>');
          $('#edit_name').val(name); // Set the value separately to avoid script execution
          $('.mobile').html('<input type="text" id="edit_mobile" name="edit_mobile" onblur="validateMobile()" required><br><br><span id="mobileError" class="error"></span>');
          $('#edit_mobile').val(mobile); // Set the value separately to avoid script execution
          $('.edit').hide();
          $('.save').show();

          //when click #avatar image then click on edit_avatar and open filecontrol
          $('#avatar').on('click', function() {
            $('#edit_avatar').click();
          });

          // Handle file selection
          $('#edit_avatar').on('change', function() {
            var file = this.files[0];
            if (file) {
              // Display the selected image
              var reader = new FileReader();
              reader.onload = function(e) {
                $('#avatar').attr('src', e.target.result);
              };
              reader.readAsDataURL(file);
            }
          });
        }

        //validate mobile number
        function validateMobile() {
          var mobile = document.getElementById('edit_mobile').value;
          var mobileError = document.getElementById('mobileError');

          // Reset previous errors
          mobileError.innerHTML = "";

          // Validate mobile number
          if (mobile.trim() === "" || !(/^\d{10}$/.test(mobile))) {
            mobileError.innerHTML = "Mobile number must be 10 digits and enter only digits";
            mobileError.style.color = "red";

            //if error in mobile number then submit button is disabled otherwise enable
            $('.save').prop('disabled', true);
          } else {
            // Enable the save button if the validation passes
            $('.save').prop('disabled', false);
          }
        }

        //validate image extension
        function validateImageExtension() {
          var avatarInput = document.getElementById('edit_avatar');
          var avatarError = document.getElementById('avatarError');

          // Reset previous errors
          avatarError.innerHTML = "";

          // Validate image file extension
          if (avatarInput.value.trim() !== "") {
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            var fileExtension = avatarInput.value.split('.').pop().toLowerCase();

            if (allowedExtensions.indexOf(fileExtension) === -1) {
              avatarError.innerHTML = "Invalid file type. Allowed types: " + allowedExtensions.join(', ');
              avatarError.style.color = "red"; // Set error message color to red

              //if error in file extension then submit button is disabled 
              $('.save').prop('disabled', true);
            } else {
              // Enable the save button if the validation passes
              $('.save').prop('disabled', false);
            }
          }
        }
      </script>
    </div>
  </div>
</body>

</html>