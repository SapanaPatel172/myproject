<div class="modal" id="updateUserModal">
    <form action="../../index.php?action=update" method="post">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">update User</h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" onclick="closeModel()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-4">
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                            <div class=" flex-fill mb-0">
                                <input type="text" id="name" class="form-control" name="name" placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="bi bi-person-workspace  fa-lg me-3 fa-fw"></i>
                            <div class=" flex-fill mb-0">
                                <select class="form-select" id="roleDropdown" name="role1" aria-label="Select role">

                                    <?php while ($get_row = $get_rolename->fetch_assoc()) {
                                        //display role name fome the table roles
                                        $g_role_name = $get_row['role_name'];
                                        $role_id1 = $get_row['role_id'];
                                        $selected = ($g_role_name == $selectedRole) ? 'selected' : ''; 
                                    ?>
                                        <option value="<?php echo $role_id1; ?>" <?php echo $selected; ?>><?php echo $g_role_name; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModel()">Close</button>
                    <button type="submit" class="btn btn-info" name="submit">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>