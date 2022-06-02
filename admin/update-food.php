<!-- Menu Section Starts -->
<?php include("partials/menu.php"); ?>
<!-- Menu Section Ends -->

<!-- Main Content Section Starts -->

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1><br><br><br>

<?php 

// Check whether id is set or not.

if(isset($_GET['id']))
{

//echo "Is set.";

// 1. Get the id other details.
$id=(int)$_GET['id'];

// 2. Create sql query to get the details.
$sql="SELECT * FROM tbl_food WHERE id = $id LIMIT 1";

//echo $sql;

// 3. Execute the query.
$res = mysqli_query($connect, $sql);

// Check whether query is executed or not.
if($res==true)
{
    // Check whether the data is available or not.
    $count = mysqli_num_rows($res);
    // Check whether the id is valid or not.
    if($count==1)
    {   
        //echo "Available";
        // Get the details.
        $row=mysqli_fetch_assoc($res);

        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $category = $row['category'];
        $featured = $row['featured'];
        $active = $row['active'];
    }
    else
    {
    // Redirect to manage category page and provide a session message.
    $_SESSION['no-food-found'] = "<div class='error'>Food not found.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
    }
}

}
else
{
    // Redirect to manage food page.
    header('location:'.SITEURL.'admin/manage-food.php');
}

?> <br><br>


        <form action = "" method = "POST" enctype = "multipart/form-data">
            <table class ="tbl-30">

                <tr>
                <td>Title:</td>
                <td><input type = "text" name = "title" value = "<?php echo $title; ?>"></td>
                </tr>

                <tr>
                <td>Description:</td>
                <td><textarea name = "description" cols = "30" rows = "5"> <?php echo $description; ?></textarea></td>
                </tr>

                <tr>
                <td>Price:</td>
                <td><input type = "number" name = "price" value = "<?php echo $price; ?>">
                </td>
                </tr>

                <tr>
                <td>Current Image:</td>
                <td>
                <?php
                if($current_image != "")
                {
                    // Display the image.
                    ?>
                    <img src = "<?php echo SITEURL; ?>images/food/<?php echo $current_image ?>" width = "150px">
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
                <td>Category:</td>
                <td><select name = "category">

                <?php
                    // Display categories from database using php.
                    // 1. Sql query to get all active categories from database.
                    $sql2 = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                    // Execute the query.
                    $res2 = mysqli_query($connect, $sql2);

                    // Count rows to check whether we have categories or not.
                    $count = mysqli_num_rows($res2);

                    // If count is greater than zero, we have have categories, otherwise we do not.
                    if($count>0)
                    {
                        // We have categories.
                        while($row2=mysqli_fetch_assoc($res2))
                        {
                            // Get details of categories.
                            $category_id = $row2['id'];
                            $title = $row2['title'];

                            ?>

                            <option value = "<?php echo $category_id; ?>"><?php echo $title; ?></option>

                            <?php
                        }
                    }
                    else
                    {
                        // We do not have categories.
                        ?>
                        <option value = "0">No Category Found</option> 
                        <?php
                    }

                    // 2. Display on dropdown.

                ?>

                    </select>
                </td>
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
                <input type = "submit" name = "submit" value = "Update Food" class = "btn-secondary"></td>
                </tr>

            </table>
        </form>

    </div>
</div>

<?php
    
    if(isset($_POST['submit']))
    {
        //echo "Clicked";   
        // 1. Get all the values from the form.
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $current_image = $_POST['current_image'];
        $category = $_POST['category'];
        $featured = $_POST['featured'] ?? 'No';
        $active = $_POST['active'] ?? 'No';

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
                    $image_name = "Food_Name_".time().'.'.$ext;

                    $source_path=$_FILES['image']['tmp_name'];
                    $destination_dir = realpath(__DIR__.'/../images/food');
                    $destination_path = $destination_dir.'/'.$image_name;

                    // Finally upload the image.
                    $upload=move_uploaded_file($source_path, $destination_path);
                    // These are to debug why move_uploaded_file was not working.
                    // var_dump([$upload,$source_path, $destination_path]);
                    // die;

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
                                $remove_dir = realpath(__DIR__.'/../images/food'); 
                                $remove_path = $destination_dir.'/'.$current_image; 
                                //$remove_path = "../images/category/".$current_image;
                                @unlink($remove_path); 
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

        $sql3 = "UPDATE tbl_food SET
        title = '$title',
        description = '$description',
        price = $price,
        image_name = '$image_name',
        category_id = '$category',
        featured = '$featured',
        active = '$active'
        WHERE id = '$id'
        "; 

        //echo $sql3; //die();

        // Execute the query.
        $res3 = mysqli_query($connect, $sql3);

        // 4. Redirect to manage category.
        if($res3 == true)
        {   
            // Food updated.
            $_SESSION['update'] = "<div class = 'success'>Food updated successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // Redirect to manage food page and provide a session message.
            $_SESSION['update'] = "<div class = 'error'>Failed to update food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

    }

?>

<!-- Main Content Section Ends -->

<!-- Footer Section Starts -->
<?php include("partials/footer.php"); ?> 
<!-- Footer Section Ends -->