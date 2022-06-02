<?php include('partials/menu.php'); ?>
<?php include('helpers/calculateTotal.php'); ?>

<div class = "main-content"> 
    <div class = "wrapper"> 
    <h1>Update Order</h1> <br><br><br>
    
    <?php
        // Check whether id is set or empty.
        if(isset($_GET['id'])) 
        {
            // Get the order details.
            $id = $_GET['id'];

            // Get all other details based on this id.
            // SQL Query to get the order details from database.
            $sql = "SELECT * FROM tbl_order WHERE id = $id";

            // Execute Query.
            $res = mysqli_query($connect, $sql);

            // Count Rows.
            $count = mysqli_num_rows($res);

            // Check if data is available.
            if($count == 1)
            {
                // Data is available.
                $row = mysqli_fetch_assoc($res);

                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
            }
            else
            {
                // No data available, redirect to manage order page.
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        } 
        else 
        {
            // Redirect to manage order page.
            header('location:'.SITEURL.'admin/manage-order.php');
        }

    ?>

        <form action = "" method = "POST">

            <table class = "tbl-30">
                <tr>
                    <td>Food Name:</td>
                    <td><?php echo $food ?></td>
                </tr>
 
                <tr>
                    <td>Price:</td>
                    <td><?php echo $price ?></td>
                </tr>

                <tr>
                    <td>Quantity:</td>
                    <td>
                        <input type = "number" name = "qty" value = "<?php echo $qty ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <select name = "status">
                        <option <?php if($status == "Ordered"){echo "selected";} ?> value = "Ordered">Ordered</option>
                        <option <?php if($status == "On Delivery"){echo "selected";} ?> value = "On Delivery">On Delivery</option>
                        <option <?php if($status == "Delivered"){echo "selected";} ?> value = "Delivered">Delivered</option>
                        <option <?php if($status == "Cancelled"){echo "selected";} ?> value = "Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type = "text" name = "customer_name" value = "<?php echo $customer_name ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type = "text" name = "customer_contact" value = "<?php echo $customer_contact ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type = "text" name = "customer_email" value = "<?php echo $customer_email ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <textarea name = "customer_address" name = "customer_address" cols = "30" rows = "5"><?php echo $customer_address ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                    <input type = "hidden" name = "id" value = "<?php echo $id ?>">
                    <input type = "hidden" name = "price" value = "<?php echo $price ?>">
                    <input type = "submit" name = "submit" value = "Update Order" class = "btn-secondary">
                    </td>
                </tr>


            </table>

            <?php

                // Check if form is submitted.
                if(isset($_POST['submit']))
                {
                    // Get the form data.
                    $id = $_POST['id'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = calculateTotal($qty, $price);

                    $status = $_POST['status'];

                    $customer_name = $_POST['customer_name'];
                    $customer_contact = $_POST['customer_contact'];
                    $customer_email = $_POST['customer_email'];
                    $customer_address = $_POST['customer_address'];

                    // Update the order details.
                    // SQL Query to update the order details in database.
                    $sql2 = "UPDATE tbl_order SET
                    qty = '$qty',
                    total = '$total',  
                    status = '$status', 
                    customer_name = '$customer_name', 
                    customer_contact = '$customer_contact', 
                    customer_email = '$customer_email', 
                    customer_address = '$customer_address' 
                    WHERE id = '$id'
                    "; 
            
                    //echo $sql2; die();
            
                    // Execute the query.
                    $res2 = mysqli_query($connect, $sql2);

                    // Check if data is updated.
                    if($res2 == true)
                    {
                        // Data is updated.
                        $_SESSION['update'] = "<div class = 'success'>Order updated successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                    else
                    {
                        // Data is not updated.
                        $_SESSION['update'] = "<div class = 'error'>Order failed to update.</div>";
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                }

            ?>

        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>