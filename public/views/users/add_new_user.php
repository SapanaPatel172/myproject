<div class="modal" id="addUserModal">
        <form action="create" method="post">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" onclick="closeModel()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-4">
                           
                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <div class=" flex-fill mb-0">
                                    <input type="text" id="name" class="form-control" name="name" placeholder="Enter Name" value="<?php echo isset($_REQUEST['name']) ? htmlspecialchars($_REQUEST['name']) : ''; ?>" />
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                <div class=" flex-fill mb-0">
                                    <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email" value="<?php echo (isset($_REQUEST['email'])) ? htmlspecialchars($_REQUEST['email']) : ''; ?>" />
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="bi bi-person-workspace  fa-lg me-3 fa-fw"></i>
                                <div class=" flex-fill mb-0">
                                    <select class="form-select" id="roleDropdown1" name="role" aria-label="Select role">
                                     <!-- display rolename list into the roleDropdown1 from table roles -->
                                        <?php while ($role_row = $rolenamecopy->fetch_assoc()) {
                                            $role_name_row = $role_row['role_name'];
                                            $role_id_row = $role_row['role_id']; ?>
                                            <option value="<?php echo $role_id_row; ?>" placeholder="Select a Role"><?php echo $role_name_row; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModel()">Close</button>
                        <button type="submit" class="btn btn-info" name="submit">Add</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
