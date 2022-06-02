<!-- Menu Section Starts -->
<?php include("partials/menu.php"); ?>
<!-- Menu Section Ends -->

<!-- Main Content Section Starts -->

<div class = "main-content">
    <div class = "wrapper">
        <h1>Update Category</h1><br><br><br>

<?php 

// Check whether id is set or not.

if(isset($_GET['id']))
{

//echo "Is set.";

// 1. Get the id other details.
$id = $_GET['id'];

// 2. Create sql query to get the details.
$sql = "SELECT * FROM tbl_category WHERE id = $id";

//echo $sql;

// 3. Execute the query.
$res = mysqli_query($connect, $sql);

// Check whether query is executed or not.
if($res == true)
{
    // Check whether the data is available or not.
    $count = mysqli_num_rows($res);
    // Check whether the id is valid or not.
    if($count == 1)
    {   
        // echo "Available";
        // Get the details.
        $row = mysqli_fetch_assoc($res);

        $title = $row['title'];
        $current_image = $row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];
    }
    else
    {
        // Redirect to manage category page and provide a session message.
        $_SESSION['no-category-found'] = "<div class = 'error'>Category not found.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
}

}
else
{
    // Redirect to Manage Category Page.
    header('location:'.SITEURL.'admin/manage-category.php');
}

?> </br></br>

        <form action = "" method = "POST" enctype = "multipart/form-data">
            <table class = "tbl-30">

                <tr>
                <td>Title:</td>
                <td><input type = "text" name = "title" value = "<?php echo $title; ?>"></td>
                </tr>

                <tr>
                <td>Current Image:</td>
                <td>
                <?php
                if($current_image != "")
                {
                    // Display the image.
                ?>
                    <img src = "<?php echo SITEURL; ?>images/category/<?php echo $current_image ?>" width = "150px">
                    <?php
                }
                else
                {
                    // Display a message.
                    echo "<div class = 'error'>Image not added.</div>";
                }
                    ?>
                </td>
                </tr>

                <tr>
                <td>New Image:</td>
                <td><input type = "file" name = "image"></td>
                </tr>

                <tr>
                <td>Featured:</td>
                <td><input <?php if($featured == "Yes"){echo "checked";} ?> type = "radio" name = "featured" value = "Yes"> Yes
                    <input <?php if($featured == "No"){echo "checked";} ?> type = "radio" name = "featured" value = "No"> No
                </td>
                </tr>

                <tr>
                <td>Active:</td>
                <td><input <?php if($active == "Yes"){echo "checked";} ?> type = "radio" name = "active" value = "Yes"> Yes      
                    <input <?php if($active == "No"){echo "checked";} ?>type = "radio" name = "active" value = "No"> No
                </td>
                </tr>

                <tr>
                <td>
                <input type = "hidden" name = "current_image" value = "<?php echo $current_image; ?>">
                <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                <input type = "submit" name = "submit" value = "Update Category" class = "btn-secondary"></td>
                </tr>

            </table>
        </form>

<?php
    
    if(isset($_POST['submit']))
    {
        //echo "Clicked";   
        // 1. Get all the values from the form.
        $id = $_POST['id'];
        $title = $_POST['title'];
        $current_image = $_POST['image_name'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        // 2. Updating the new image if selected.
        // Check whether the image is selected or not.
        if(isset($_FILES['image']['name']))
        {
            // Get the image details.
            $image_name = $_FILES['image']['name'];

            // Check whether the image is available or not.
            if($image_name != "")
            {
                // Image available.
                // A. Upload the new image.
                // Auto rename our image.
                // Get the extension of our image name, source path, and destination path.
                $ext = end(explode('.', $image_name));

                // Rename the image.
                // $image_name = "Food_Category_".rand(000, 999).'.'.$ext;
                $image_name = "Food_Category_".time().'.'.$ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_dir = realpath(__DIR__.'/../images/category');
                $destination_path = $destination_dir.'/'.$image_name;

                // Finally upload the image.
                $upload = move_uploaded_file($source_path, $destination_path);
                
                // These are to debug why move_uploaded_file was not working.
                // var_dump([$upload,$source_path, $destination_path]); // die;

                // Check whether the image is uploaded or not.
                // And if the image is not uploaded, then we will stop the process and redirect page and give an error message.
                if($upload == false)
                {
                    // Query executed and category added.
                    $_SESSION['upload'] = "<div class = 'error'>Failed to upload image.</div>";
                    // Redirect to manage category page.
                    header('location:'.SITEURL.'admin/manage-category.php');
                    // Stop the process.
                    die();
                }

                        // B. Remove the current image.
                        if($current_image != "")
                        {
                        
                            $remove_dir = realpath(__DIR__.'/../images/category');
                            $remove_path = $destination_dir.'/'.$image_name;
                            //$remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                                // Check whether the image is removed or not.
                                // If failed to remove, then display message and stop the process.
                                if($remove == false)
                                {
                                    // Failed to remove image.
                                    $_SESSION['failed-remove'] = "<div class = 'error'>Failed to remove current image.</div>";
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                    die(); // Stop the process.
                                }
                        }
            }
            else
            {
                $image_name = $current_image;
            }
        }
        else
        {
            $image_name = $current_image;
        }

        // 3. Update the database.
        $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id = '$id'
                "; 

                echo $sql2;

        // Execute the query.
        $res2 = mysqli_query($connect, $sql2);

        // 4. Redirect to manage category.
        if($res2 == true)
        {   
            // Category updated.
            $_SESSION['update'] = "<div class = 'success'>Category updated successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Redirect to manage category page and provide a session message.
            $_SESSION['update'] = "<div class = 'error'>Failed to update category.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

    }

?>

    </div>
</div>

<!-- Main Content Section Ends -->

<!-- Footer Section Starts -->
<?php include("partials/footer.php"); ?> 
<!-- Footer Section Ends -->