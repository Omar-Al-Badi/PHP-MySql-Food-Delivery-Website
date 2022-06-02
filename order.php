    <!-- Navbar Section Starts Here -->
    <?php include('partials-front/menu.php'); ?>
    <!-- Navbar Section Ends Here -->

    <?php

        // Check whether food is set or not.
        if(isset($_GET['food_id']))
        {
            // Get the the food id and details of the selected food.
            $food_id = $_GET['food_id'];

            // Get the details of the selected food.
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

            // Execute Query.
            $res = mysqli_query($connect, $sql);

            // Count Rows.
            $count = mysqli_num_rows($res);

            // Check whether the data is available or not.
            if($count == 1)
            {
                // Data is available.
                // Get the data from the database.
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                // Food not available.
                // Redirect to homepage.
                header('location:'.SITEURL);                
            }

        }
        else
        {
            // Redirect to homepage.
            header('location:'.SITEURL);
        }

    ?>

    <!-- Food Search Section Starts Here -->
    <section class = "food-search">
        <div class = "container">
            
            <h2 class = "text-center text-white">Fill this form to confirm your order.</h2>

            <form action = "" method = "POST" class = "order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class = "food-menu-img">
                        <?php
                            // Check whether the image is available or not.
                            if($image_name == "")
                            {
                                // Image not available.
                                echo "<div class = 'error'>Image not available.</div>";
                            }
                            else
                            {
                                // Image is available.
                        ?>
                                <img src = "<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt = "Pizza" class = "img-responsive img-curve">
                                <?php
                            }

                                ?>
                    </div>
    
                    <div class = "food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type = "hidden" name = "food" value = "<?php echo $title; ?>">

                        <p class = "food-price">$ <?php echo $price; ?></p>
                        <input type = "hidden" name = "price" value = "<?php echo $price; ?>">

                        <div class = "order-label">Quantity</div>
                        <input type = "number" name = "qty" class = "input-responsive" value = "1" required>
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class = "order-label">Full Name</div>
                    <input type = "text" name = "full-name" placeholder = "E.g. John Doe" class = "input-responsive" required>

                    <div class = "order-label">Phone Number</div>
                    <input type = "tel" name = "contact" placeholder = "E.g. +1-xxx-xxx-xxx" class = "input-responsive" required>

                    <div class = "order-label">Email</div>
                    <input type = "email" name = "email" placeholder = "E.g. johndoe@mail.com" class = "input-responsive" required>

                    <div class = "order-label">Address</div>
                    <textarea name = "address" rows = "10" placeholder = "E.g. Street, City, Country" class = "input-responsive" required></textarea>

                    <input type = "submit" name = "submit" value = "Confirm Order" class = "btn btn-primary">
                </fieldset>

            </form>

            <?php

                // Check whether submit button is clicked or not.
                if(isset($_POST['submit']))
                {
                    // Get all the details from the form.
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // Total price.

                    $order_date = date('Y-m-d H:i:s');

                    $status = "Ordered"; // Ordered, On Delivery, Delivered, Cancelled.

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    // Save the order to the database.
                    // SQL to save the data.
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = '$price',
                        qty = '$qty',
                        total = '$total',
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    // echo $sql2; die();

                    // Execute the query.
                    $res2 = mysqli_query($connect, $sql2);

                    // Check whether the query executed successfully or not.
                    if($res2 == true)
                    {
                        // Query executed and order saved.
                        $_SESSION['order'] = "<div class = 'success text-center'>Food ordered successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        // Failed to save order.
                        $_SESSION['order'] = "<div class = 'error text-center'>Failed to order food.</div>";
                        header('location:'.SITEURL);
                    }

                }

            ?>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <!-- Footer Section Starts Here -->
    <?php include('partials-front/footer.php'); ?>
    <!-- Footer Section Ends Here -->