<?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class = "main-content">
        <div class = "wrapper">

            <h1>Dashboard</h1><br>

            <?php
                if(isset($_SESSION['login'])) 
                {
                    echo $_SESSION['login']; // Displaying Session Message.
                    unset($_SESSION['login']); // Removing Session Message.
                }            
            ?> <br>

                <div class="col-4 text-center">
                    <?php
                        // Sql query to to help calculate number of rows.
                        $sql = "SELECT * FROM tbl_category";

                        // Execute query.
                        $res = mysqli_query($connect, $sql);

                        // Count number of rows.
                        $category_count = mysqli_num_rows($res);
                    ?>
                <h1><?php echo $category_count; ?></h1>
                Categories
                </div>

                <div class="col-4 text-center">
                    <?php
                        // Sql query to to help calculate number of rows.
                        $sql2 = "SELECT * FROM tbl_food";

                        // Execute query.
                        $res2 = mysqli_query($connect, $sql2);

                        // Count number of rows.
                        $food_count = mysqli_num_rows($res2);
                    ?>
                <h1><?php echo $food_count; ?></h1>
                Food Items
                </div>

                <div class = "col-4 text-center">
                    <?php
                        // Sql query to help calculate number of rows.
                        $sql3 = "SELECT * FROM tbl_order";

                        // Execute query.
                        $res3 = mysqli_query($connect, $sql3);

                        // Count number of rows.
                        $order_count = mysqli_num_rows($res3);
                    ?>
                <h1><?php echo $order_count; ?></h1>
                Total Orders
                </div>

                <div class="col-4 text-center">
                    <?php
                            // Sql query to get total revenue.
                            $sql4 = "SELECT SUM(total) AS Total FROM tbl_order";
                            //$sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status = 'Delivered'";

                            // Execute query.
                            $res4 = mysqli_query($connect, $sql4);

                            // Count number of rows.
                            $total_revenue_count = mysqli_fetch_assoc($res4);

                            // Get total revenue.
                            $total_revenue = $total_revenue_count['Total'];

                        ?>
                <h1>$ <?php echo $total_revenue; ?></h1>
                Revenue Generated
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>