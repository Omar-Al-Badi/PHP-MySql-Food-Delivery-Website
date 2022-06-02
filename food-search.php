    <!-- Navbar Section Starts Here -->
    <?php include('partials-front/menu.php'); ?>
    <!-- Navbar Section Ends Here -->

    <!-- Food Search Section Starts Here -->
    <section class = "food-search text-center">
        <div class = "container">
            
        <?php
            // Get the search keyword.
            $search = $_POST['search'];
        ?>
            
        <h2>Based on your search <a href = "#" class = "text-white" >"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class = "food-menu">
        <div class = "container">
            <h2 class = "text-center">Food Menu</h2>

            <?php

                // SQL Query to get food based on the search keyword. 
                $sql = "SELECT * FROM  tbl_food WHERE title Like '%$search%' OR description LIKE '%$search%'";

                // Execute the query.
                $res = mysqli_query($connect, $sql);

                // Count Rows
                $count = mysqli_num_rows($res);

                if($count > 0)
                {
                    // Food available.
                    while($row = mysqli_fetch_assoc($res))
                    {
                    // Get the details.
                    $id = $row['id'];   
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
            ?>

                    <div class = "food-menu-box">
                        <div class = "food-menu-img">

                        <?php
                            // Check whether image is availble or not.
                            if($image_name == "")
                            {
                                // Display message.
                                echo "<div class = 'error'>Image not available.</div>";
                            }
                            else
                            {
                                // Image available.
                                ?>
                                <img src = "<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt = "Pizza" class = "img-responsive img-curve">
                                <?php
                            }
                                ?>

                    </div>

                        <div class = "food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class = "food-price">$ <?php echo $price; ?></p>
                            <p class = "food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href = "<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class = "btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php

                    }
                }
                else
                {
                    // Food not available.
                    echo "<div class='error'>Food not found.</div>";
                }

                    ?>

<!--             <div class = "food-menu-box">
                <div class = "food-menu-img">
                    <img src = "images/menu-pizza.jpg" alt = "Chicken Hawaiian Pizza" class = "img-responsive img-curve">
                </div>

                <div class = "food-menu-desc">
                    <h4>Food Title</h4>
                    <p class = "food-price">$ 10.00</p>
                    <p class = "food-detail">
                        A tasty pizza with chicken and pineapple toppings.
                    </p>
                    <br>

                    <a href="#" class = "btn btn-primary">Order Now</a>
                </div>
            </div> -->

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Food Menu Section Ends Here -->

    <!-- Footer Section Starts Here -->
    <?php include('partials-front/footer.php'); ?>
    <!-- Footer Section Ends Here -->