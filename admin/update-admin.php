<!-- Menu Section Starts -->
<?php include("partials/menu.php"); ?>
<!-- Menu Section Ends -->

<!-- Main Content Section Starts -->

<div class = "main-content">
    <div class = "wrapper">
        <h1>Update Admin</h1></br>

        <?php 

        // 1. Get the ID of the selected admin.
        $id = $_GET['id'];

        // 2. Create SQL Query to get the details.
        $sql = "SELECT * FROM tbl_admin WHERE id = $id";

        // 3. Execute the query.
        $res = mysqli_query($connect, $sql);

        // Check whether query is executed or not.
        if($res == true)
        {
            // Check whether the data is available or not.
            $count = mysqli_num_rows($res);
            // Check whether we have admin data or not.
            if($count == 1)
            {
                // Get the details.
                //echo "Admin Available";
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            }
            else
            {
                // Redirect to Manage Admin Page.
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        
        ?> </br></br>

            <form action = "" method = "POST">

                <table class = "tbl-30">

                <tr>
                <td>Full Name:</td>
                <td><input type = "text" name = "full_name" value = "<?php echo $full_name ?>"></td>
                </tr>

                <tr>
                <td>Username:</td>
                <td><input type = "text" name = "username" value = "<?php echo $username ?>"></td>
                </tr>

                <tr>
                <td colspan = "2">
                <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                <input type = "submit" name ="submit" value = "Update Admin" class = "btn-secondary"></td>
                </tr> 

                </table>

            </form>

    </div>
</div>

<?php 
    // Check whether the submit button is clicked or not.
    if(isset($_POST['submit']))
    {
        // echo "Button Clicked";
        // Get all the values from the form to update
        echo $id = $_POST['id'];
        echo $full_name = $_POST['full_name'];
        echo $username = $_POST['username'];

        // Create a sql query to update Admin details
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";

        echo $sql;

        // Execute the query 
        $res = mysqli_query($connect, $sql);

        // Check whether the query executed successfully or not
        if($res == true)
        {
            // Query executed and admin updated
            $_SESSION['update'] = "<div class = 'success'>Admin updated successfully.</div>";
            // Redirect to manage admin page
            header('location:'.SITEURL."admin/manage-admin.php");
        }
        else
        {
            // Failed to update admin 
            $_SESSION['update'] = "<div class = 'error'>Failed to update admin.</div>";
            // Redirect to manage admin page
            header('location:'.SITEURL."admin/manage-admin.php");            
        }
    }
?>

<!-- Main Content Section Ends -->

<!-- Footer Section Starts -->
<?php include("partials/footer.php"); ?> 
<!-- Footer Section Ends -->
