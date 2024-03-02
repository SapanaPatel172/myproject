<?php

if (isset($_SESSION['id'])) {
  //get current user id from session variable 
  $id = $_SESSION['id'];

  //get all require data (permission_name,module_name) using groupby
  $mod_per_role_data = $obj->selectdatawithgroupby($id);
  // print_r($mod_per_role_data->fetch_assoc());exit;
  if ($mod_per_role_data) {
    $row = $mod_per_role_data->fetch_assoc();
    // Extract permission names and module names from the concatenated strings
    $per_name = explode(',', $row['permission_names']);
    $moduleNames = explode(',', $row['module_names']);
    $role_name=explode(',', $row['module_names']);
  }
}

?>
<section>
  <div class="sidebar text-center pt-3">
    <!-- Display modules according permissions -->
    <?php foreach ($moduleNames as $module_name) : ?>
      <?php if ($module_name == "home") { ?>
        <a href="../auth/dashbord.php"><?php echo $module_name; ?></a>
      <?php } else if ($module_name == "users") { ?>
        <a href="../users/users.php"><?php echo $module_name; ?></a>
      <?php } else if ($module_name == "rollmanagement") { ?>
        <a href="../roles/role_management.php"><?php echo $module_name; ?></a>
      <?php } else if ($module_name == "news") { ?>
        <a href="#"><?php echo $module_name; ?></a>
      <?php } ?>
    <?php endforeach; ?>
  </div>
</section>
