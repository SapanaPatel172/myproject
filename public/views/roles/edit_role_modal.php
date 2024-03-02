<div class="modal" id="editRoleModal">
    <form action="" method="post">
        <div class="modal-dialog w-75 mw-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModel()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h6>Role Name</h6>
                        <input type="text" id="editrolename" class="form-control" name="rolename" />
                    </div>
                    <div class="row mt-4">
                        <table class="table caption-top w-100 ">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Module Name</th>
                                    <th scope="col" colspan="5">Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php // Reset the internal pointer of the $permissions result set
                                mysqli_data_seek($module, 0);
                                //display module from module table 
                                while ($row1 = $module->fetch_assoc()) {
                                    $emod_name = $row1['module'];
                                    $emod_id = $row1['id'];
                                ?>
                                    <tr>
                                        <td>
                                            <!-- module names -->
                                            <?= $emod_name; ?>
                                        <td>
                                            <?php
                                            // permission show from permission table
                                            $eselect_per = ['mod_id' => $emod_id];
                                            $epermissions = $obj->selectdata("permissions", $eselect_per);
                                            while ($eper_result = $epermissions->fetch_assoc()) {
                                                $eper_name = $eper_result['permission_name'];
                                                $eper_id = $eper_result['permission_id']; ?>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input1" type="checkbox" value="<?= $eper_id; ?>" name="crud_per1[]" id="<?= $eper_id; ?>">
                                                <label class="form-check-label" for="<?= $eper_id; ?>">
                                                    <?= $eper_name; ?>
                                                </label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModel()">Close</button>
                        <button type="submit" class="btn btn-info" name="submit">Save</button>
                    </div>
                </div>
            </div>
    </form>
</div>