    <!-- Navbar Section Starts Here -->
    <?php include('partials-front/menu.php'); ?>
    <!-- Navbar Section Ends Here -->

    <!-- Food Search Section Starts Here -->
    <section class = "food-search text-center">
        <div class = "container">
            
            <form action = "<?php echo SITEURL; ?>food-search.php" method = "POST">
                <input type = "search" name = "search" placeholder = "Search for Food.." required>
                <input type = "submit" name = "submit" value = "Search" class = "btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class = "food-menu">
        <div class = "container">
            <h2 class = "text-center">Food Menu</h2>

            <?php

            //  Query to get items from database that are active.
            $sql = "SELECT * FROM tbl_food WHERE active = 'Yes'";

            //echo $sql; //die();

            // Execute Query.
            $res = mysqli_query($connect, $sql);

            // Count Rows.
            $count = mysqli_num_rows($res);

            if($count > 0)
            {
                // Food available.
                while($row = mysqli_fetch_assoc($res))
                {

                // Get values needed.
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
                                echo "<div class='error'>Image not available.</div>";
                            }
                            else
                            {
                                // Image available.
                    ?>
                                <img src = "<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
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
                echo "<div class = 'error'>Food not available.</div>";
            }

                ?>

            <div class = "clearfix"></div>
          
        </div>

    </section>
    <!-- Food Menu Section Ends Here -->

    <!-- Footer Section Starts Here -->
    <?php include('partials-front/footer.php'); ?>
    <!-- Footer Section Ends Here -->
