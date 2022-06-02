<?php

    // Include constants.php file here.
    include('../config/constants.php');

    // Check whether id and image value is set or not.
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the physical image file if available.
        if($image_name != "")
        {
            // Image is available. So remove it.
            $path = "../images/category/".$image_name;
            // Remove the image.
            $remove = unlink($path);

            // If failed to remove image then add error message.
            if($remove==false)
            {
                // Set the session message.
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove category.</div>";
                // Redirect to manage category.
                header('location:'.SITEURL.'admin/manage-category.php');
                // Stop the proccess.
                die();
            }
        }

        // Delete data from database.
        // SQL Query to delete data from database.
        $sql = "DELETE FROM tbl_category WHERE id = $id";

        // Execute the query 
        $res = mysqli_query($connect, $sql);

        // Check whether the data is deleted from the database or not.
        if($res == true)
        {
            // Query executed successfully, and category deleted.
            // Create Sesssion variable to display message.
            $_SESSION['delete'] = "<div class = 'success'>Category deleted successfully.</div>";
            // Redirect to manage category page.
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Query failed to execute successfully, and admin not deleted.
            $_SESSION['delete'] = "<div class = 'error'>Failed to delete category.</div>";
            // Redirect to manage category page.
            header('location:'.SITEURL.'admin/manage-category.php');
        }

    }
    else
    {
        // Redirect to manage category page.
        header('location:'.SITEURL.'admin/manage-category.php');

    }

?>