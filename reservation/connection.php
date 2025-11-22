<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# name of host
$host_name = "localhost";

#username for SQL (general username for all sql)
$sql_name = "root";

#password for SQL (there is no password for sql)
$pass_sql = "";

#name of database
$db_name = "yaprestaurant";

$con = mysqli_connect($host_name, $sql_name, $pass_sql, $db_name);

if (!$con) {
    die("Failed to connect to database: " . mysqli_connect_error());
}
?>
