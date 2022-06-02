<?php include('partials/menu.php'); ?>

<div class="main-content">

    <div class="wrapper">
        <h1>Add Category</h1><br><br><br>

        <?php
            if(isset($_SESSION['add'])) 
            {
                echo $_SESSION['add']; // Displaying Session Message.
                unset($_SESSION['add']); // Removing Session Message.
            }     
            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload']; // Displaying Session Message.
                unset($_SESSION['upload']); // Removing Session Message.
            }                             
        ?> <br>

        <!-- Add Category Form Starts -->

        <form action = "" method = "POST" enctype = "multipart/form-data"> <!-- This enctype allows images. -->

        <table class="tbl-30">

        <tr>
        <td>Title:</td>
        <td><input type = "text" name = "title" placeholder = "Category Title..."></td>
        </tr>

        <tr>
        <td>Select Image:</td>
        <td><input type = "file" name = "image"></td>
        </tr>

        <tr>
        <td>Featured:</td>
        <td><input type = "radio" name = "featured" value = "Yes"> Yes
            <input type = "radio" name = "featured" value = "No"> No
        </td>
        </tr>

        <tr>
        <td>Active:</td>
        <td><input type = "radio" name = "active" value = "Yes"> Yes
            <input type = "radio" name = "active" value = "No"> No
        </td>
        </tr>

        <tr>
        <td colspan = "2">
        <input type = "submit" name = "submit" value = "Add Category" class = "btn-secondary"></td>
        </tr>


        </table>

        </form>

        <!-- Add Category Form Ends -->

        <?php

        // Check whether the submit button is clicked or not.
        if(isset($_POST['submit']))
        {
            // echo "Clicked";

            // 1. Get the value from the category form.
            $title = $_POST['title'];

            // For radio input, we need to check whether the button is selected or not.
            if(isset($_POST['featured']))
            {
                // Get the value form the form.
                $featured = $_POST['featured'];
            }
            else
            {
                // Set the default value.
                $featured = "No";
            }
            if(isset($_POST['active']))
            {
                // Get the value form the form.
                $active= $_POST['active'];
            }
            else
            {
                // Set the default value.
                $active = "No";
            }
            
            //print_r($_FILES['image']); // Check whether the image is selected or not.
            //die(); // Break the code here.

            if(isset($_FILES['image']['name'])) // Checks if an image is uploaded and if it has a name. 
            {
                // To upload an image, we need the image name, source path, and destination path. 
                // Upload the image.
                $image_name=$_FILES['image']['name'];

                if($image_name != "")
                {
                    // Auto rename our image.
                    // Get the extension of our image name, source path, and destination path.
                    $ext = end(explode('.', $image_name));

                    // Rename the image.
                    //$image_name = "Food_Category_".rand(000, 999).'.'.$ext;
                    $image_name = "Food_Category_".time().'.'.$ext;

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_dir = realpath(__DIR__.'/../images/category');
                    $destination_path = $destination_dir.'/'.$image_name;

                    // Finally upload the image.
                    $upload = move_uploaded_file($source_path, $destination_path);
                    
                    // These are to debug why move_uploaded_file was not working.
                    // var_dump([$upload,$source_path, $destination_path]);
                    // die;

                    // Check whether the image is uploaded or not.
                    // And if the image is not uploaded, then we will stop the process and redirect page and give an error message.
                    if($upload == false)
                    {
                        // Query executed and category added.
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        // Redirect to manage category page.
                        header('location:'.SITEURL.'admin/add-category.php');
                        // Stop the process.
                        die();
                    }
                }

            }
            else
            {
                // Don't upload image and set the image_name value as blank.
                $image_name = "";
            }

            // 2. Create SQL Query to insert category into database.
            $sql = "INSERT INTO tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            ";

            echo $sql2;
            
            // 3. Execute the query and save the database
            $res = mysqli_query($connect, $sql);

            // 4. Check whether the query executed or not and data added or not.
            if($res==TRUE)
            {
                // Query executed and category added.
                $_SESSION['add'] = "<div class = 'success'>Category added successfully.</div>";
                // Redirect to manage category page.
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                // Failed to add category.
                $_SESSION['add'] = "<div class = 'error'>Failed to add category.</div>";
                // Redirect to same page.
                header('location:'.SITEURL.'admin/add-category.php');
            }    
                                                                                                                                                                
        }

        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>
