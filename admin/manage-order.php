<?php include('partials/menu.php'); ?>

<div class = "main-content"> 
    <div class = "wrapper"> 
    <h1>Manage Order</h1> <br><br><br>

    <?php 
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update']; // Displaying Session Message
            unset($_SESSION['update']); // Removing Session Message
        }
    ?>

    <table class = "tbl-full">
        
        <tr>
            <th>S.N.</th>
            <th>Food</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status </th>
            <th>Customer Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>

        <?php 

            //  Query to get all orders from database.
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // Display by most recent order.

            // Execute Query.
            $res = mysqli_query($connect, $sql);

            // Create a variable to number orders correctly.
            $sn = 1;

            // Count Rows.
            $count = mysqli_num_rows($res);

            // Check if data is available.
            if ($count > 0)
            {
                // We have data in our database. 
                // Get the data and display it.
                while($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

        ?>

                    <tr>

                    <td> <?php echo $sn++; ?> </td>
                    <td> <?php echo $food; ?> </td>
                    <td> <?php echo $price; ?> </td>
                    <td> <?php echo $qty; ?> </td>
                    <td> <?php echo $total; ?> </td>
                    <td> <?php echo $order_date; ?> </td>
                    <td> <?php echo $status; ?> </td>
                    <td> <?php echo $customer_name; ?> </td>
                    <td> <?php echo $customer_contact; ?> </td>
                    <td> <?php echo $customer_email; ?> </td>
                    <td> <?php echo $customer_address; ?> </td>

                    <td>
                    <a href = "<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class = "btn-secondary">Update Order</a>
                    </td>

                    </tr> 

                    <?php
                }

            }
            else
            {
                // Orders not available.
                echo "<tr><td colspan = '12' class = 'error'>Orders not available.</td></tr>";
            } 
            
                    ?>

        </tr>
    </table>

    </div>
</div>

<?php include('partials/footer.php'); ?>