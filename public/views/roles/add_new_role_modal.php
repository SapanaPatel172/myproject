<div class="modal" id="addRoleModal">
    <form action="create" method="post">
        <div class="modal-dialog w-75 mw-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModel()" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div>
                        <h6>Role Name</h6>
                        <input type="text" id="rolename" class="form-control" name="rolename" placeholder="Enter Role Name" />
                    </div>

                    <div class=" mt-4">

                        <table class="table caption-top w-100 ">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Module Name</th>
                                    <th scope="col" colspan="5">Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- display list of modules from table modules -->
                                <?php while ($row = $module->fetch_assoc()) {
                                    $mod_name = $row['module'];
                                    $mod_id = $row['id'];
                                ?>
                                    <tr>
                                        <td>
                                            <!-- display module name -->
                                            <?= $mod_name; ?>
                                        <td>
                                            <?php
                                            //get permission_name and permission_id from the table permissions usind module id
                                            $select_per = ['mod_id' => $mod_id];
                                            $permissions = $obj->selectdata("permissions", $select_per);
                                            while ($per_result = $permissions->fetch_assoc()) {
                                                $per_name = $per_result['permission_name'];
                                                $per_id = $per_result['permission_id']; ?>
                                        <td>
                                            <!-- display permission list -->
                                            <div class="form-check">
                                                <input class="form-check-inputview" type="checkbox" value="<?= $per_id; ?>" name="crud_per[]" id="<?= $per_id; ?>">
                                                <label class="form-check-label" for="<?= $per_id; ?>">
                                                    <?= $per_name; ?>
                                                </label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModel()">Close</button>
                    <button type="submit" class="btn btn-info" name="submit">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>