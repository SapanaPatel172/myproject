<?php
session_start();
include '../../models/database.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';
include '../partials/sidemenu.php';

$tablename = "users";
$obj = new database();
$users_result = $obj->selectdata($tablename);
$get_rolename = $obj->selectdata("roles");
$rolenamecopy = $obj->selectdata("roles");
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
                <div class=" d-flex justify-content-end">
             
                    <!-- Add user when click add button -->
                    <?php if (in_array('users_create', $per_name)) { ?>
                    <button type="button" class="btn btn-info me-5" onclick="openAddUserModal()" name="add">Add New User</button>
                   <?php } ?>
                </div>
                <table class="table w-100 caption-top  text-center">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- display permissions -->
                        <?php while ($row = $users_result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <?php
                                // Fetch role information
                                $user_id = $row['id'];

                                // Join user_roles and roles tables
                                $get_roledata = $obj->selectDataWithJoin('user_roles', 'roles', 'user_roles.role_id = roles.role_id', ['user_roles.user_id' => $user_id]);

                                // Fetch the result of the join
                                $role_result = $get_roledata->fetch_assoc();

                                // Check if the role_name exists
                                $role_name1 = $role_result['role_name'];
                            
                                // Display the role_name
                                echo "<td>{$role_name1}</td>";
                                $get_roles_data = $obj->selectdata("roles", ['role_name' => $role_name1]);
                                $roles_row = $get_roles_data->fetch_assoc();
                                $rol_id = $roles_row['role_id']; ?>
                                <td>
                                    <?php if (in_array('users_view', $per_name)) { ?>
                                        <!-- view user detail when click view button -->
                                        <button type="button" class="btn btn-success" onclick="openViewModal('<?= $row['id']; ?>','<?php echo $role_name1; ?>')" name="view">View</button>
                                    <?php }  if (in_array('users_update', $per_name)) { ?>
                                        <!-- edit user when click update button -->
                                        <button type="button" class="btn btn-info" onclick="openUpdateUserModal('<?= $row['id']; ?>','<?= $row['name']; ?>','<?=$rol_id; ?>')" name="update">Update</button>
                                    <?php }  if (in_array('users_delete', $per_name)) { ?>
                                        <!-- delete user when click delete button -->
                                        <button type="button" class="btn btn-danger" onclick="openDeleteUserModal('<?= $row['id']; ?>','<?= $row['name']; ?>')" name="delete">delete</button>
                                <?php } 
                                } ?>
                                </td>
                            </tr>

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
     <!-- Bootstrap Modal for delete user -->
     <?php include 'update_user_modal.php'; ?>
 
    <!-- Bootstrap Modal for delete user -->
    <?php include 'delete_user_modal.php'; ?>
      
    <!-- Bootstrap Modal for Add New user -->
    <?php include 'add_new_user.php'; ?>
    
    <!-- Bootstrap Modal for view user -->
    <?php include 'view_user.php'; ?>
    
    

    <script>
           // Function to open the Add New Role modal
           function openUpdateUserModal(id, name, role_id) {
            console.log('Function called');
            $('#updateUserModal').modal('show');
            $('#name').val(name);
            $('#roleDropdown').val(role_id).prop('selected', true);
            $('#updateUserModal form').attr('action', 'update?id=' + id);
        }

        // Function to close all modal(add,edit,delete)
        function closeModel() {
            $('.modal').modal('hide');
        }

        // Function to open the Add New Role modal
        function openAddUserModal() {
            $('#addUserModal').modal('show');
        }

      

        // Function to open Delete Role modal
        function openDeleteUserModal(id, name) {
            $('#deleteUserModal').modal('show');
            $('.msg').text("Are you sure you want to delete " + name + "?");
             $('#deleteUserModal form').attr('action', 'delete?&id=' + id);
            console.log($('#deleteUserModal form').attr('action'));
        }

        // Function to open the View Role modal
        function openViewModal(id, role_name) {
            $('#viewUserModal').modal('show');

            // Send AJAX request to fetch user data
            $.ajax({
                url: 'get_user_data.php', // Replace with the actual URL to your server-side script
                type: 'GET',
                data: {
                    id:id
                },
                success: function(data) {
                    var avatarImg = data.avatarimg ? data.avatarimg : '../../image/avatar.jpg';
                     // show perticular user detail into the modal
                    $('#userDetails').html(`
                    <div style="text-align: center;">
                    <img src="${avatarImg}" alt="User Profile Image" style="max-width: 100%; width:40%; height: auto;">
                    </div>
                    <p><strong>User Name:</strong> ${data.name}</p>
                    <p><strong>User Email:</strong> ${data.email}</p>
                    <p><strong>User mobile:</strong> ${data.mobile}</p>
                    <p><strong>User Role:</strong> ${role_name}</p>
                   
                    `);
                },
                error: function(error) {
                    console.error('Error fetching user data:', error);
                }
            });
        }
    </script>