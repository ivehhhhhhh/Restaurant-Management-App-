<?php
require 'connection.php'; // Include your database connection

// Handle deletion request
if (isset($_GET['delete'])) {
    $no_ic = $_GET['delete'];

    // SQL query to delete the reservation
    $sql = "DELETE FROM reservation WHERE no_ic = '$no_ic'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Reservation deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting reservation: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all reservations to display
$result = mysqli_query($con, "SELECT * FROM reservation LIMIT 50");
$data = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
mysqli_close($con);
?>

<style>
    table {
        display: flex;
        justify-content: center;
        border-collapse: collapse;
        font-size: 20px;
        width: 80%;
        margin: 20px auto;
    }
    th, tr, td, a {
        border: 1px solid black;
        padding: 10px;
        text-align: center;
    }
    a {
        color: #ff6666;
        text-decoration: none;
        font-weight: bold;
    }
    a:hover {
        color: #cc0000;
    }
</style>

<table>
    <tr>
        <th>IC Number</th>
        <th>Table ID</th>
        <th>Reservation Date</th>
        <th>Reservation Time</th>
        <th>Guest Count</th>
        <th>Delete</th>
    </tr>
    <?php if (isset($data) && !empty($data)): ?>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['no_ic']) ?></td>
                <td><?= htmlspecialchars($row['table_id']) ?></td>
                <td><?= htmlspecialchars($row['date_of_reservation']) ?></td>
                <td><?= htmlspecialchars($row['time_of_reservation']) ?></td>
                <td><?= htmlspecialchars($row['guest_count']) ?></td>
                <td>
                    <a href="?delete=<?= htmlspecialchars($row['no_ic']) ?>" 
                       onclick="return confirm('Are you sure you want to delete this reservation?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No reservations found.</td>
        </tr>
    <?php endif; ?>
</table>
