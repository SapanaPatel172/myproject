<?php
session_start();
include '../partials/validator.class.php';
include '../../models/database.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';

//select data from table roles and modules for show roles and modules
$obj = new database();
$roles_result = $obj->selectdata("roles");
$module = $obj->selectdata("module");
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
        <div>
          <!-- frist check permissions if create permissions then displays the buttons -->
          <?php if (in_array('rollmanagement_create', $per_name)) { ?>
            <!-- open add role modal -->
            <button type="button" class="btn btn-info" onclick="openAddRoleModal()">Add New Role</button>
            <button type="button" class="btn btn-info ms-5" onclick="window.location.href = '../modules/show_modules.php';">Show modules</button>
          <?php } ?>
        </div><br><br>
        <table class="table caption-top w-50 text-center">
          <thead>
            <tr>
              <!-- check permissions only view then Action not displays -->
              <th scope="col">RoleName</th>
              <?php if (in_array('rollmanagement_update', $per_name) || in_array('rollmanagement_delete', $per_name)) { ?>
                <th scope="col">Action</th>
              <?php } ?>

            </tr>
          </thead>
          <tbody>
            <?php while ($row = $roles_result->fetch_assoc()) {
              $rolename = $row['role_name'];
              $id = $row['role_id']; ?>
              <tr>
                <td><?php echo $rolename; ?></td>
                <!-- displays buttons according roles permissions -->
                <?php if (in_array('rollmanagement_update', $per_name)) { ?>
                  <td> <!-- edit role modal -->
                    <button type="button" class="btn btn-info edit" data-role-id="<?php echo $id; ?>" onclick="openEditModal('<?php echo $rolename; ?>','<?php echo $id; ?>')" name="edit">Edit</button>
                  <?php }
                if (in_array('rollmanagement_delete', $per_name)) { ?>
                    <!-- delete role modal -->
                    <button type="button" class="btn btn-danger delete" data-role-id="<?php echo $id; ?>" onclick="opendeleteModal('<?php echo $rolename; ?>','<?php echo $id; ?>')" name="delete">delete</button>
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="d-flex align-items-center">
          <?php  // Display error and success messages 
          msg();
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap Modal for delete Role -->
  <?php include 'delete_role_modal.php'; ?>

  <!-- Bootstrap Modal for Add New Role -->
  <?php include 'add_new_role_modal.php'; ?>

  <!-- Bootstrap Modal for Edit Role -->
  <?php include 'edit_role_modal.php'; ?>



  <script>
    // Function to close all modal(add,edit,delete)
    function closeModel() {
      $('#addRoleModal, #editRoleModal, #deleteroleModal').modal('hide');
    }

    // Function to open the Add New Role modal
    function openAddRoleModal() {
      $('#addRoleModal').modal('show');
    }

    function opendeleteModal(rolename, roleId) {
      $('#deleteroleModal').modal('show');
      $('.msg').text("Are you sure you want to delete " + rolename + "?");
      // Set the role ID in the form action
      // when click submit button then redirect delete_permission.php with per_id
      $('#deleteroleModal form').attr('action', 'delete?id=' + roleId);
    }

    // Function to open the Edit Role modal
    function openEditModal(rolename, roleId) {
      $('#editRoleModal').modal('show');
      $('#editrolename').val(rolename);

      // Fetch permissions associated with the specific role from the role_permissions table
      $.ajax({
        type: 'POST',
        url: 'get_permission.php',
        data: {
          role_id: roleId
        },
        success: function(data) {
          var permissions = JSON.parse(data) || [];
          console.log(permissions);
          // Uncheck all checkboxes first
          $('.form-check-input1').prop('checked', false);

          // Loop through each permission and check the corresponding checkbox
          permissions.forEach(function(permission) {
            var mod_id = permission.permission_id;
            console.log(mod_id);

            // Check the checkbox corresponding to the permission
            $('.form-check-input1[value="' + mod_id + '"]').prop('checked', true);
          });
        },
        error: function() {
          console.error('Error fetching permissions');
        }
      });

      $('#getid').val(roleId);
      //when submit modal then redirect on the edit_role.php with selected role_id
      $('#editRoleModal form').attr('action', 'update?id=' + roleId);
    }
  </script>
</body>

</html>