<?php
// Include the database connection
include 'connection.php';

// Check if the request is a GET or POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle the "Edit" functionality
    if (isset($_GET['no_ic'])) {
        $no_ic = $_GET['no_ic'];

        // Fetch reservation details for the provided `no_ic`
        $query = "SELECT * FROM reservation WHERE no_ic = '$no_ic'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Extract the existing data
            $table_id = $row['table_id'];
            $date_of_reservation = $row['date_of_reservation'];
            $time_of_reservation = $row['time_of_reservation'];
            $guest_count = $row['guest_count'];
        } else {
            echo "<script>alert('Reservation not found.'); window.location.href='reservation_list.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid request. No IC provided.'); window.location.href='reservation_list.php';</script>";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the "Update" functionality
    if (isset($_POST['no_ic'])) {
        $no_ic = $_POST['no_ic'];
        $table_id = $_POST['table_id'];
        $date_of_reservation = $_POST['date_of_reservation'];
        $time_of_reservation = $_POST['time_of_reservation'];
        $guest_count = $_POST['guest_count'];

        // Update the reservation in the database
        $update_query = "UPDATE reservation 
                         SET table_id = '$table_id', 
                             date_of_reservation = '$date_of_reservation', 
                             time_of_reservation = '$time_of_reservation', 
                             guest_count = '$guest_count' 
                         WHERE no_ic = '$no_ic'";

        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Reservation updated successfully!'); window.location.href='reservation_list.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error updating reservation: " . mysqli_error($con) . "'); window.location.href='reservation_list.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid request. Missing reservation details.'); window.location.href='reservation_list.php';</script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Reservation</title>
    <style>
        form {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label, input, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($no_ic)): ?>
        <form action="edit_reservation.php" method="post">
            <h2 style="text-align: center;">Edit Reservation</h2>
            <input type="hidden" name="no_ic" value="<?= htmlspecialchars($no_ic) ?>">

            <label for="table_id">Table ID:</label>
            <select name="table_id" id="table_id" required>
                    <option value="" disabled selected>Choose Table</option>
                    <option value="001">Table 001 (Capacity: 2)</option>
                    <option value="002">Table 002 (Capacity: 2)</option>
                    <option value="003">Table 003 (Capacity: 2)</option>
                    <option value="004">Table 004 (Capacity: 2)</option>
                    <option value="005">Table 005 (Capacity: 2)</option>
                    <option value="006">Table 006 (Capacity: 2)</option>
                    <option value="007">Table 007 (Capacity: 2)</option>
                    <option value="008">Table 008 (Capacity: 2)</option>
                    <option value="009">Table 009 (Capacity: 4)</option>
                    <option value="010">Table 010 (Capacity: 4)</option>
                    <option value="011">Table 011 (Capacity: 4)</option>
                    <option value="012">Table 012 (Capacity: 4)</option>
                    <option value="013">Table 013 (Capacity: 4)</option>
                    <option value="014">Table 014 (Capacity: 4)</option>
                    <option value="015">Table 015 (Capacity: 5)</option>
                    <option value="016">Table 016 (Capacity: 5)</option>
                    <option value="017">Table 017 (Capacity: 5)</option>
                    <option value="018">Table 018 (Capacity: 6)</option>
                    <option value="019">Table 019 (Capacity: 6)</option>
                    <option value="020">Table 020 (Capacity: 6)</option>
                </select><br><br>

            <label for="date_of_reservation">Date:</label>
            <input type="date" name="date_of_reservation" value="<?= htmlspecialchars($date_of_reservation) ?>" required>

            <label for="time_of_reservation">Time:</label>
            <select name="time_of_reservation" required>
                <option value="9:00 AM" <?= $time_of_reservation == "9:00 AM" ? 'selected' : '' ?>>9:00 AM</option>
                <option value="11:00 AM" <?= $time_of_reservation == "11:00 AM" ? 'selected' : '' ?>>11:00 AM</option>
                <option value="1:00 PM" <?= $time_of_reservation == "1:00 PM" ? 'selected' : '' ?>>1:00 PM</option>
                <option value="3:00 PM" <?= $time_of_reservation == "3:00 PM" ? 'selected' : '' ?>>3:00 PM</option>
                <option value="5:00 PM" <?= $time_of_reservation == "5:00 PM" ? 'selected' : '' ?>>5:00 PM</option>
                <option value="7:00 PM" <?= $time_of_reservation == "7:00 PM" ? 'selected' : '' ?>>7:00 PM</option>
                <option value="9:00 PM" <?= $time_of_reservation == "9:00 PM" ? 'selected' : '' ?>>9:00 PM</option>
            </select>

            <label for="guest_count">Guest Count:</label>
            <input type="number" name="guest_count" value="<?= htmlspecialchars($guest_count) ?>" min="1" required>

            <button type="submit">Update Reservation</button>
        </form>
    <?php endif; ?>
</body>
</html>
