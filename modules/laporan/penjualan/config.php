<?php
    error_reporting(0);
    define('DB_NAME', 'mitraser_sinardiesel');
    define('DB_USER', 'mitraser_alex');
    define('DB_PASSWORD', 'Poiuy1234567890');
    define('DB_HOST', 'localhost');
    
    // Create connection
    $db     =   new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
?>