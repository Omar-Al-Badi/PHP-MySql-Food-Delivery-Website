<?php include('partials/menu.php'); ?>

<div class = "main-content"> 
    <div class = "wrapper"> 
    <h1>Manage Food</h1> <br><br><br>

<!-- Button to Add Food-->
<a href = "<?php echo SITEURL; ?>admin/add-food.php" class = "btn-primary">Add Food</a> <br><br>

<?php
    if(isset($_SESSION['add'])) 
    {
        echo $_SESSION['add']; // Displaying Session Message.
        unset($_SESSION['add']); // Removing Session Message.
    }     
    if(isset($_SESSION['delete'])) 
    {
        echo $_SESSION['delete']; // Displaying Session Message.
        unset($_SESSION['delete']); // Removing Session Message.
    }    
    if(isset($_SESSION['unauthorized'])) 
    {
        echo $_SESSION['unauthorized']; // Displaying Session Message.
        unset($_SESSION['unauthorized']); // Removing Session Message.
    }  
    if(isset($_SESSION['update'])) 
    {
        echo $_SESSION['update']; // Displaying Session Message.
        unset($_SESSION['update']); // Removing Session Message.
    }  
    if(isset($_SESSION['upload'])) 
    {
        echo $_SESSION['upload']; // Displaying Session Message.
        unset($_SESSION['upload']); // Removing Session Message.
    }  
    if(isset($_SESSION['remove'])) 
    {
        echo $_SESSION['remove']; // Displaying Session Message.
        unset($_SESSION['remove']); // Removing Session Message.
    }  
?> <br>

    <table class = "tbl-full">
        <tr>
            <th>S.N.</th>
            <th>Title</th>
            <th>Price</th>
            <th>Image</th>
            <th>Featured</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>

        <?php 
            //  Query to get all categories from database.
            $sql = "SELECT * FROM tbl_food";

            // Execute Query.
            $res = mysqli_query($connect, $sql);

            // Create a variable to number items correctly.
            $sn = 1;

            // Count Rows.
            $count = mysqli_num_rows($res);

            // Check if data is available.
            if ($count > 0)
            {
                // We have data in our database. 
                // Get the data and display it.
                while($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name2 = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

        ?>

                    <tr>
                        <td><?php echo $sn++ ?></td>
                        <td><?php echo $title; ?></td>
                        <td>$ <?php echo $price; ?></td>
                        <td>
                            
                            <?php 

                                 // Check whether image name is available or not.
                                 if($image_name2 != "")
                                 {
                                     // Display the image.
                                     ?>

                                     <img src = "<?php echo SITEURL; ?>images/food/<?php echo $image_name2; ?>" width = "100px">

                                     <?php
                                 }
                                 else
                                 {
                                     // Display a message.
                                     echo "<div class = 'error'>Image not added.</div>";
                                 }

                            ?>

                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                        <a href = "<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class = "btn-secondary">Update Food</a>
                        <a href = "<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name2=<?php echo $image_name; ?>" class = "btn-danger">Delete Food</a>
                        </td>
                    </tr>

                    <?php
                }

            }
            else
            {
                // No data in available in database. 
                // Display a message inside the table.
                    ?>

                <tr>
                    <td colspan = "7"><div class = "error">No Food Added.</div></td>
                </tr>

                <?php
            } 
            
                ?>

<!--         <tr>
            <td>1. </td>
            <td>Burger</td>
            <td>5.00</td>
            <td>Image</td>
            <td>Yes</td>
            <td>Yes</td>

            <td>
            <a href = "#" class = "btn-secondary">Update Food</a>
            <a href = "#" class = "btn-danger">Delete Food</a>
            </td>
        </tr> -->

        </tr>
    </table>

    </div>
</div>

<?php include('partials/footer.php'); ?>