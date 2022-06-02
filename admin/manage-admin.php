<!-- Menu Section Starts -->
<?php include("partials/menu.php"); ?>
<!-- Menu Section Ends -->

<!-- Main Content Section Starts -->

        <div class = "main-content">
        <div class = "wrapper">

            <h1>Manage Admin</h1>
            <br>

            <?php
                if(isset($_SESSION['add'])) // Relates to add-admin.php
                {
                    echo $_SESSION['add']; // Displaying Session Message
                    unset($_SESSION['add']); // Removing Session Message
                }
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete']; // Displaying Session Message
                    unset($_SESSION['delete']); // Removing Session Message
                }
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update']; // Displaying Session Message
                    unset($_SESSION['update']); // Removing Session Message
                }
                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found']; // Displaying Session Message
                    unset($_SESSION['user-not-found']); // Removing Session Message
                }
                if(isset($_SESSION['pwd-not-match']))
                {
                    echo $_SESSION['pwd-not-match']; // Displaying Session Message
                    unset($_SESSION['pwd-not-match']); // Removing Session Message
                }
                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd']; // Displaying Session Message
                    unset($_SESSION['change-pwd']); // Removing Session Message
                }

            ?> 
            <br/><br/><br/>

            <!-- Button to Add Admin-->
            <a href = "add-admin.php" class = "btn-primary">Add Admin</a>
            <br/><br/><br/>

            <table class = "tbl-full">

                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php

                    // Query to get all admins.
                    $sql = "SELECT * FROM tbl_admin";
                    // Execute all Query.
                    $res = mysqli_query($connect, $sql);

                    // Check whether the query excuted or not.
                    if($res == TRUE)
                    {
                        // Count rows to check whether we have data in database or not.
                        $count = mysqli_num_rows($res); // Function that returns the number of rows in the result set.
                        $sn = 1; 
                        
                        if($count>0) // if count more than 0, while loop will fetch a row of data per run will run as long as we have data in database.
                        {
                            while($rows = mysqli_fetch_assoc($res)) // This is the sqli function that fetches one row of data from the result set and returns it as an associative array.

                            {
                                // Get indvidual data.
                                $id = $rows['id']; # Brackets indicate the column name.
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];

                                // Display values in our visible table.
                ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                    <a href = "<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class = "btn-primary">Change Password</a>
                                    <a href = "<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class = "btn-secondary">Update Admin</a>
                                    <a href = "<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class = "btn-danger">Delete Admin</a>
                                    </td>
                                </tr>
                                <?php 
                                
                            }
                        }

                        else

                        {
                            // We do not have data in database
                            echo "No data found.";
                        }
                    }
                                ?>

                <!-- <tr>
                    <td>1. </td>
                    <td>Omar Al-Badi</td>
                    <td>OmarAlBadi</td>
                    <td>
                    <a href = "#" class = "btn-secondary">Update Admin</a>
                    <a href = "#" class = "btn-danger">Delete Admin</a>
                    </td>
                </tr>
                -->
                
            </table>

            </div>
        </div>

<!-- Main Content Section Ends -->

<!-- Footer Section Starts -->
<?php include("partials/footer.php"); ?> 
<!-- Footer Section Ends -->
