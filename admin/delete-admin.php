<?php

// Include constants.php file here.
include('../config/constants.php');

// 1. Get the ID of admin to be deleted.
$id = $_GET['id'];

// 2. Create SQL query to delete admin.
$sql = "DELETE FROM tbl_admin where id=$id";

// Execute the query.
$res = mysqli_query($connect, $sql);

// Check whether the query executed successfully or not.
if($res == true)
{
    // Query executed successfully, and admin deleted.
    //echo "Admin deleted.";
    // Create Sesssion variable to display message.
    $_SESSION['delete'] = "Admin deleted successfully.";
    // Redirect to manage admin page.
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    // Query failed to execute successfully, and admin not deleted.
    // echo "Failed to delete Admin.";
    $_SESSION['delete'] = "Failed to delete Admin.";
    // Redirect to manage admin page.
    header('location:'.SITEURL.'admin/manage-admin.php');
}

// 3. Redirect to manage admin page with message (success/error).

?>