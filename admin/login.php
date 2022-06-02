<?php include('../config/constants.php') ?>

<html>

    <head>  
        <title>Food Ordering Website - Login Page</title>
        <link rel = "stylesheet" href = "../css/admin.css">
    </head>

    <body>  
        <div class = "login"> 
            <h1 class = "text-center">Login</h1> <br> 

            <?php
                if(isset($_SESSION['login'])) 
                {
                    echo $_SESSION['login']; // Displaying Session Message.
                    unset($_SESSION['login']); // Removing Session Message.
                }            
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message']; // Displaying Session Message.
                    unset($_SESSION['no-login-message']); // Removing Session Message.
                }


            ?> <br>

            <!-- Login form starts here -->

            <form action = "" method = "POST" class = "text-center">

            Username: <br>
            <input type = "text" name = "username" placeholder = "Enter Username..."> <br><br>
            Password: <br>
            <input type = "password" name = "password" placeholder = "Enter Password..."> <br><br>
            <input type = "submit" name = "submit" value = "Login" class = "btn-primary"> <br><br>

            </form>

            <!-- Login form ends here -->

            <p class = "text-center">Coded by <a href = "https://www.linkedin.com/in/omar-al-badi/"> Omar Al-Badi </a></p>
        </div>
        
    </body>

</html>

<?php
    // Check whether the submit button is clicked or not.
    if(isset($_POST['submit']))
    {

        // Process for login.
        // 1. Get the data for the login form.
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // 2. SQL to check whether the user with username and password exist or not.
        $sql = "SELECT id FROM tbl_admin WHERE username='$username' AND password = '$password' LIMIT 1";

        // 3. Execute the query.
        $res = mysqli_query($connect, $sql);

        // 4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);
            if($count == 1)
            {
                // User available and login success.
                $_SESSION['login'] = "<div class = 'success'>Login successful.</div>";
                $_SESSION['user'] = $username; // To check whether user is logged in or not (will be unset with session destroy when logging out.).
                
                // Redirect to home page / Dashboard.
                header('location:'.SITEURL.'admin/');
                exit;
            }
            else
            {
                // User not available and login failed. 
                $_SESSION['login'] = "<div class = 'error text-center'>Username or password did not match.</div>";
                // Redirect to login page.
                header('location:'.SITEURL."admin/login.php");    
                exit;        
            }
    }

?>