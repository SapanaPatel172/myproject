<?php
session_start();
include '../partials/validator.class.php';
include '../../models/database.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';


//fatch record from the table module and display 
$tablename = "module";
$obj = new database();
$module_data = $obj->selectdata($tablename);
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
                    <!-- add new permissions -->
                    <button type="button" class="btn btn-info ms-5" onclick="openAddModuleModal()">add New module</button>
                </div><br><br>
                <table class="table caption-top w-50 text-center">
                    <thead>
                        <tr>
                            <th scope="col">module Name</th>
                            <!-- <th scope="col">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- display permissions -->
                        <?php while ($row = $module_data->fetch_assoc()) {
                            $per_name = $row['module']; ?>
                            <tr>
                                <td><?php echo $per_name; ?></td>
                                <!-- <td>
                                     edit permissions when click edit button 
                                     <button type="button" class="btn btn-info edit" onclick="openEditModal('<?php echo $per_name; ?>','<?php echo $row['id']; ?>')" name="edit">Edit</button>
                                     delete permissions when click delete button 
                                    <button type="button" class="btn btn-danger delete" onclick="opendeleteModal('<?php echo $per_name; ?>','<?php echo $row['id']; ?>')" name="delete">delete</button> 
                                </td> -->
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

    <!-- Bootstrap Modal for Add new Permissions-->
    <div class="modal" id="addNewModuleModal">
        <form action="create" method="post">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModel()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h6>Module Name</h6>
                            <input type="text" id="modulename" class="form-control" name="modulename" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModel()">Close</button>
                        <button type="submit" class="btn btn-info" name="submit"> save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Bootstrap Modal for edit Permissions-->
    <div class="modal" id="editPermissionsModal">
        <form action="" method="post">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModel()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h6>Permission Name</h6>
                            <input type="text" id="editpermissionname" class="form-control" name="permissionname" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModel()">Close</button>
                        <button type="submit" class="btn btn-info" name="submit"> save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap Modal for delete permissions -->
    <div class="modal" id="deletepermissionModal">
        <form action="" method="post">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModel()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="msg"></h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModel()">Close</button>
                        <button type="submit" class="btn btn-info" name="submit">Delete</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Function to open the Add New module
        function openAddModuleModal() {
            $('#addNewModuleModal').modal('show');
        }

        function opendeleteModal(per_name, per_Id) {
            $('#deletepermissionModal').modal('show');
            $('.msg').text("Are you sure you want to delete " + per_name + "?");
            // Set the role ID in the form action
             // when click submit button then redirect delete_permission.php with per_id
            $('#deletepermissionModal form').attr('action', 'delete_permission.php?id=' + per_Id);
        }

        function openEditModal(per_name, per_Id) {
            $('#editPermissionsModal').modal('show');
            $('#editpermissionname').val(per_name);
            // Set the role ID in the form action
            // when click submit button then redirect edit_permission.php with per_id
            $('#editPermissionsModal form').attr('action', 'edit_permission.php?id=' + per_Id);
        }

        // Function to close all modal(add,edit,delete)
        function closeModel() {
            $('.modal').modal('hide');
        }
    </script>
</body>

</html>