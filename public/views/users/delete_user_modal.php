<div class="modal" id="deleteUserModal">
    <form action="../../index.php?action=delete" method="post">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
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