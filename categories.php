    <!-- Navbar Section Starts Here -->
    <?php include('partials-front/menu.php'); ?>
    <!-- Navbar Section Ends Here -->


    <!-- Categories Section Starts Here -->
    <section class = "categories">
        <div class = "container">
            <h2 class = "text-center">Explore Foods</h2>

            <?php

                // Display all the categories that are active.
                $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                //echo $sql; //die();

                // Execute Query.
                $res = mysqli_query($connect, $sql);

                // Count Rows.
                $count = mysqli_num_rows($res);

                // Check whether categories are availble or not.
                if($count > 0)
                {
                    // Categories available.
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
            ?>

                            <a href = "<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id ?>">
                            <div class = "box-3 float-container">
                                <?php
                                    if($image_name == "")
                                    {
                                        // Image not available.
                                        echo "<div class = 'error'>Image not found.</div>";
                                    }
                                    else
                                    {
                                        // Image available.
                                ?>
                                        <img src = "<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt = "Pizza" class = "img-responsive img-curve">
                                        <?php
                                    }

                                        ?>
                                
                                <h3 class = "float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    // Categories not available.
                    echo "<div class = 'error'>Category not found.</div>";
                }

                        ?>

<!--             <a href = "category-foods.html">
            <div class = "box-3 float-container">
                <img src = "images/pizza.jpg" alt = "Pizza" class = "img-responsive img-curve">

                <h3 class = "float-text text-white">Pizza</h3>
            </div>
            </a>

            <a href = "#">
            <div class = "box-3 float-container">
                <img src = "images/burger.jpg" alt = "Burger" class = "img-responsive img-curve">

                <h3 class = "float-text text-white">Burger</h3>
            </div>
            </a> -->
            
            <div class = "clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- Footer Section Starts Here -->
    <?php include('partials-front/footer.php'); ?>
    <!-- Footer Section Ends Here -->