<?php include('partials/menu.php'); ?>

<div class = "main-content">

    <div class = "wrapper">
        <h1>Add Food</h1><br><br><br>

        <?php
        if(isset($_SESSION['upload'])) 
        {
            echo $_SESSION['upload']; // Displaying Session Message.
            unset($_SESSION['upload']); // Removing Session Message.
        }            
        ?> <br>

        <!-- Add Food Form Starts -->

        <form action = "" method = "POST" enctype = "multipart/form-data"> <!-- This enctype allows images. -->

        <table class = "tbl-30">

        <tr>
        <td>Title:</td>
        <td><input type = "text" name = "title" placeholder = "Title of the food..."></td>
        </tr>

        <tr>
        <td>Description:</td>
        <td><textarea name = "description" cols = "30" rows = "5" placeholder = "Description of the food..."></textarea></td>
        </tr>

        <tr>
        <td>Price:</td>
        <td><input type = "number" name = "price"></td>
        </tr>

        <tr>
        <td>Select Image:</td>
        <td><input type = "file" name = "image"></td>
        </tr>

        <tr>
        <td>Category:</td>
        <td><select name = "category">

        <?php
            // Display categories from database using php.
            // 1. Sql query to get all active categories from database.
            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

            // Execute the query.
            $res = mysqli_query($connect, $sql);

            // Count rows to check whether we have categories or not.
            $count = mysqli_num_rows($res);

            // If count is greater than zero, we have have categories, otherwise we do not.
            if($count > 0)
            {
                // We have categories.
                while($row = mysqli_fetch_assoc($res))
                {
                    // Get details of categories.
                    $id = $row['id'];
                    $title = $row['title'];

        ?>

                    <option value = "<?php echo $id; ?>"><?php echo $title; ?></option>

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
        <td><input type = "radio" name ="featured" value = "Yes"> Yes
            <input type = "radio" name ="featured" value = "No"> No
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
        <input type = "submit" name = "submit" value = "Add Food" class = "btn-secondary"></td>
        </tr>


        </table>

        </form>

        <!-- Add Food Form Ends -->

        <?php

        // Check whether the button is clicked or not.
        if(isset($_POST['submit']))
        {
            // Add the food to the database.
            //echo "Clicked";

            // 1. Get the data from the form.
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // Check whether radio button for featured and active are checked or not.
            $featured = $_POST['featured'] ?? 'No';
            $active =  $_POST['active'] ?? 'No';

            // 2. Upload the image if selected.
            // Check whether the selected image is clicked or not and upload the image only if the image is selected.
            if(isset($_FILES['image']['name'])) // Checks if an image is uploaded and if it has a name. 
            {
                // To upload an image, we need the image name, source path, and destination path. 
                // Upload the image.
                $image_name=$_FILES['image']['name'];

                if($image_name != "")
                {
                    // Auto rename our image.
                    // Get the extension of our image name, source path, and destination path.
                    $ext2 = end(explode('.', $image_name));

                    // Rename the image.
                    //$image_name = "Food_Name_".rand(000, 999).'.'.$ext2;
                    $image_name = "Food_Name_".time().'.'.$ext2;

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_dir = realpath(__DIR__.'/../images/food');
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
                        //$_SESSION['upload'] = "<div class = 'error'>Failed to upload image.</div>";
                        echo "something failed";
                        // Redirect to manage category page.
                        // header('location:'.SITEURL.'admin/add-food.php');
                        // Stop the process.
                        die();
                    }
                }

            }
            else
            {
                // Don't upload image and set the image_name value as blank.
                $image_name = "";
                echo "something failed";
            }

            // 3. Insert into database.

            $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = '$price',
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            ";

            //echo $sql2; die();

            // Execute the query.
            $res2 = mysqli_query($connect, $sql2);

            // 4. Redirect with message to manage food.
            // Check whether executed or not.
            if($res2 == true)
            {   
                // food updated.
                $_SESSION['add'] = "<div class = 'success'>Food updated successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                // Redirect to manage food page and provide a session message.
                $_SESSION['add'] = "<div class = 'error'>Failed to update food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

        }


        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>
