<?php include('partials/menu.php'); ?>

<div class = "main-content">

    <div class = "wrapper">
        <h1>Add Admin</h1></br>

        <form action = "" method="POST">

        <table class = "tbl-30">

        <tr>
        <td>Full Name:</td>
        <td><input type = "text" name = "full_name" placeholder = "Enter Your Name..."></td>
        </tr>

        <tr>
        <td>Username:</td>
        <td><input type = "text" name = "username" placeholder = "Enter Your Username..."></td>
        </tr>

        <tr>
        <td>Password:</td>
        <td><input type = "password" name = "password" placeholder = "Enter Your Password..."></td>
        </tr>

        <tr>
        <td colspan = "2">
        <input type = "submit" name = "submit" value = "Add Admin" class = "btn-secondary"></td>
        </tr>

        </table>
        
        </form>

    </div>

</div>

<?php include('partials/footer.php'); ?>

<?php 

    // Process the value from the form and save it in the database.

    // Check whether the submit button is clicked or not.

    if(isset($_POST['submit']))
    {

        // Button clicked
        // echo "button clicked";
        // 1. Get the data from the form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // 2. SQL Query to save the data into the database.
        $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'
        ";

        //echo $sql;

        // 3. Execute Query and save data into Database.
        $res = mysqli_query($connect, $sql) or die(mysqli_error());

        // 4. Check whether the (Query is executed) data is inserted or not and dislay appropriate message.
        if($res == TRUE)
        {
            // Data inserted.
            // echo "Data insterted";
            // Create a session variable to display message.
            $_SESSION['add'] = 'Admin added successfully.';
            // Redirect to manage admin page.
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to insert data.
            // echo "Data not inserted";
            // Create a session variable to display message.
            $_SESSION['add'] = 'Failed to add Admin.';
            // Redirect to add admin page.
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }

?>
