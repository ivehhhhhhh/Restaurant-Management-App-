<?php
include 'connection.php';

# Ensure the script runs only when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Check if no_ic is 12 numbers
    if(strlen($_POST['no_ic']) != 12 || !is_numeric($_POST['no_ic'])) {
        die("<script>
            alert('IC must be 12 numbers');
            window.location.href='reservation.html';
        </script>");
    }

    # Retrieve form data
    $no_ic = $_POST['no_ic'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $hp_no = $_POST['hp_no'];
    $guest_count = $_POST['guest_count'];
    $table_id = $_POST['table_id'];
    $date_of_reservation = $_POST['date_of_reservation'];
    $time_of_reservation = $_POST['time_of_reservation'];

    # Check if the table_id exists in yap_table
    $check_table_sql = "SELECT * FROM yap_table WHERE table_id = '$table_id'";
    $result = mysqli_query($con, $check_table_sql);

    if (mysqli_num_rows($result) == 0) {
        echo '<script>
            alert("Error: Table ID does not exist. Please select a valid table.");
            window.location.href = "reservation.html"; // Redirect back to form
        </script>';
        exit(); 
    }

    # Check if the guest count exceeds the table capacity
    $table_capacity_sql = "SELECT table_capacity FROM yap_table WHERE table_id = '$table_id'";
    $capacity_result = mysqli_query($con, $table_capacity_sql);
    $table_capacity = mysqli_fetch_assoc($capacity_result)['table_capacity'];

    if ($guest_count > $table_capacity) {
        echo '<script>
            alert("Sorry, the number of guests exceeds the table capacity. Please select a table with sufficient capacity.");
            window.location.href = "reservation.html"; // Redirect back to form
        </script>';
        exit(); 
    }

    # Check for duplicate reservations
    $check_sql = "SELECT * FROM reservation 
                  WHERE table_id = '$table_id' 
                  AND date_of_reservation = '$date_of_reservation' 
                  AND time_of_reservation = '$time_of_reservation'";

    $check_result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo '<script>
            alert("Sorry, this table is already reserved at the selected date and time. Please choose another time or table.");
            window.location.href = "reservation.html"; // Redirect back to form
        </script>';
        exit(); 
    }

    # Insert customer data, if it doesn't already exist
    $customer_sql = "INSERT IGNORE INTO customer (no_ic, first_name, last_name, hp_no, guest_count) 
                     VALUES ('$no_ic', '$first_name', '$last_name', '$hp_no', '$guest_count')";

    if (!mysqli_query($con, $customer_sql)) {
        echo '<script>
                alert("Error saving customer details: ' . mysqli_error($con) . '");
                window.history.back(); // Redirect back to form
              </script>';
        exit();
    }

    # Insert reservation data, including guest_count
    $reservation_sql = "INSERT INTO reservation (no_ic, table_id, date_of_reservation, time_of_reservation, guest_count) 
                        VALUES ('$no_ic', '$table_id', '$date_of_reservation', '$time_of_reservation', '$guest_count')";

    if (mysqli_query($con, $reservation_sql)) {
        # Redirect to the reservation list page upon successful insertion
        echo '<script>
                alert("Reservation added successfully!");
                window.location.href = "reservation.html"; // Redirect to reservation list
              </script>';
    } else {
        echo '<script>
                alert("Error saving reservation details: ' . mysqli_error($con) . '");
                window.history.back(); // Redirect back to form
              </script>';
    }
} else {
    # If no form data is submitted
    echo '<script>
            alert("Please fill out the form!");
            window.location.href = "reservation.html"; // Redirect to form
          </script>';
}
?>
