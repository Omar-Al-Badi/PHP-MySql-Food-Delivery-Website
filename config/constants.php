<?php 

    // Start Session.
    session_start();

    // Create constants to store non repeating values.
    define('SITEURL', 'http://localhost/food-order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');

    $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error()); // Connects to database.
    $db_select = mysqli_select_db($connect, 'food-order') or die(mysqli_error()); // Selects database.

?>