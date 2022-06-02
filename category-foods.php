    <!-- Navbar Section Starts Here -->
    <?php include('partials-front/menu.php'); ?>
    <!-- Navbar Section Ends Here -->

    <?php
        // Check whether id is passed or not.
        if(isset($_GET['category_id']))
        {
            // Category id is set, get the id.
            $category_id = $_GET['category_id'];

            // Get the category title based on category id.
            $sql = "SELECT title FROM tbl_category WHERE id = $category_id";

            // Execute the query.
            $res = mysqli_query($connect, $sql);

            // Get the value from the database.
            $row = mysqli_fetch_assoc($res);

            // Get the title.
            $category_title = $row['title'];
        }
        else
        {
            // Category not passed, redirect to homepage.
            header('location:'.SITEURL);
        }

    ?>

    <!-- Food Search Section Starts Here -->
    <section class = "food-search text-center">
        <div class = "container">
            
        <?php
            // Get the search keyword.
            $search = $_POST['search'];
        ?>
            
        <h2>Based on you search <a href = "#" class = "text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class = "food-menu">
        <div class = "container">
            <h2 class = "text-center">Food Menu</h2>

            <?php

                // SQL query to get food based on selected category.
                $sql2 = "SELECT * FROM tbl_food WHERE category_id = $category_id";

                // Execute Query.
                $res2 = mysqli_query($connect, $sql2);

                // Count Rows.
                $count2 = mysqli_num_rows($res2);

                // Check whether food is available or not.
                if($count2 > 0)
                {
                    // Food is available.
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
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
                    // Food is not available.
                    echo "<div class = 'error'>Food not available.</div>";
                }

                        ?>

<!--             <div class = "food-menu-box">
                <div class = "food-menu-img">
                    <img src = "images/menu-momo.jpg" alt = "Chicken Hawaiian Pizza" class = "img-responsive img-curve">
                </div>

                <div class = "food-menu-desc">
                    <h4>Chicken Steam Momo</h4>
                    <p class = "food-price">$ 10.0</p>
                    <p class = "food-detail">
                        Steamed Chicken Momo, with organic vegetables.
                    </p>
                    <br>

                    <a href = "#" class = "btn btn-primary">Order Now</a>
                </div>
            </div> -->


            <div class = "clearfix"></div>

        </div>
    </section>

    <!-- Food Menu Section Ends Here -->

    <!-- Footer Section Starts Here -->
    <?php include('partials-front/footer.php'); ?>
    <!-- Footer Section Ends Here -->