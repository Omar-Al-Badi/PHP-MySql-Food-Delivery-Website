<?php

    // Include constants.php file here.
    include('../config/constants.php');

    // Check whether id and image value is set or not.
    if(isset($_GET['id']) AND isset($_GET['image_name2']))
    {
        // Get the value and delete
        $id = $_GET['id'];
        $image_name2 = $_GET['image_name2'];

        // Remove the physical image file if available.
        if($image_name2 != "")
        {
            // Image is available. So remove it.
            $path = "../images/food/".$image_name2;
            // Remove the image.
            $remove = unlink($path);

            // If failed to remove image then add error message.
            if($remove==false)
            {
                // Set the session message.
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove food.</div>";
                // Redirect to manage food.
                header('location:'.SITEURL.'admin/manage-food.php');
                // Stop the proccess.
                die();
            }
        }

        // Delete data from database.
        // SQL Query to delete data from database.
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        // Execute the query 
        $res = mysqli_query($connect, $sql);

        // Check whether the data is deleted from the database or not.
        if($res == true)
        {
            // Query executed successfully, and food deleted.
            // Create Sesssion variable to display message.
            $_SESSION['delete'] = "<div class='success'>food deleted successfully.</div>";
            // Redirect to manage food page.
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // Query failed to execute successfully, and food not deleted.
            $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
            // Redirect to manage food page.
            header('location:'.SITEURL.'admin/manage-food.php');
        }

    }
    else
    {
        // Redirect to manage food page.
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');

    }

?>