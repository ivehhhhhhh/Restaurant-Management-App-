<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="logo" href="../reservation/css/images/logo spoon.png">
    <title>Restaurant Reservation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Athiti:wght@200;300;400;500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Ubuntu&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <img src="../reservation/css/images/logo spoon.png" alt="Logo">
        <div class="nav-links">
            <a href="../landing page.html">HOME</a>
            <a href="../menu.html">MENU</a>
            <a href="../about us.html">ABOUT US</a>
            <a href="reservation.html">RESERVATION</a>
            <a href="reservation_list.php">RESERVATION LIST</a>
        </div>
    </nav>

    <div class="content" id="content">
        <h1 class="h1">Search Reservation by IC Number</h1>

        <!-- Input form for IC number -->
        <form method="POST" action="" onsubmit="scaleContent()">
            <input type="text" name="no_ic" id="no_ic" placeholder="Enter your IC number" required>
            <button type="submit" class="search">Search</button>
        </form>

        <?php
// Connect to the database
include('connection.php');

// Initialize variables
$filter_no_ic = '';
$query_result = null;

// Delete reservation functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['del'])) {
    $no_ic = $_POST['no_ic'];  // Get the IC number of the reservation to be deleted

    // SQL query to delete the reservation
    $sql = "DELETE FROM reservation WHERE no_ic = '$no_ic'";

    // Execute the query and check if deletion was successful
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Reservation deleted successfully!'); window.location.href='reservation_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting reservation: " . mysqli_error($con) . "');</script>";
    }
}

// Search reservation functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['no_ic'])) {
    $filter_no_ic = $_POST['no_ic'];

    // SQL query to fetch reservation details for the specific IC
    $sql = "SELECT 
                r.no_ic, 
                r.table_id, 
                r.date_of_reservation, 
                r.time_of_reservation,
                c.first_name, 
                c.last_name, 
                c.hp_no, 
                r.guest_count  -- Ensure this is selected from the reservation table
            FROM 
                reservation r
            JOIN 
                customer c 
            ON 
                r.no_ic = c.no_ic
            WHERE 
                r.no_ic = '$filter_no_ic'";

    // Execute the query
    $query_result = mysqli_query($con, $sql);
}

if ($query_result) {
    if (mysqli_num_rows($query_result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>IC Number</th>
                    <th>Table ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact Number</th>
                    <th>Guest Count</th>
                    <th>Actions</th>
                </tr>";

        // Output matching reservations
        while ($row = mysqli_fetch_assoc($query_result)) {
            echo "<tr>
                    <td>{$row['no_ic']}</td>
                    <td>{$row['table_id']}</td>
                    <td>{$row['date_of_reservation']}</td>
                    <td>{$row['time_of_reservation']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['hp_no']}</td>
                    <td>{$row['guest_count']}</td>  <!-- Correctly display guest count -->
                    <td>
                        <a href='edit_reservation.php?no_ic={$row['no_ic']}&date={$row['date_of_reservation']}&time={$row['time_of_reservation']}'>Edit</a> |
                        <form action='' method='POST' style='display:inline;'>
                            <input type='hidden' name='no_ic' value='{$row['no_ic']}'>
                            <button type='submit' name='del' onclick='return confirm(\"Are you sure you want to delete this reservation?\");'>Delete</button>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No reservations found for IC: $filter_no_ic</p>";
    }
}
?>

    </div>

    <footer>
        <div class="contact">
            <div>
                <a href="https://www.facebook.com/" target="_blank">
                    <img src="../reservation/css/images/facebook.png">
                </a>
            </div>
            <div> 
                <a href="https://x.com/" target="_blank">
                    <img src="../reservation/css/images/instagram.png">
                </a>
            </div>
            <div>
                <a href="https://www.instagram.com/" target="_blank">
                    <img src="../reservation/css/images/x.png">
                </a>
            </div>
        </div>
        <p>Copyright © 2024 Yap. All rights reserved.</p>
        <p>Wong Yen Yuee | Justin Tan Jiing Wen | Ivy Tan Wei Yee | Myra Ting ZiQi </p>
    </footer>

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform .5s ease, margin-top .5s ease;
        }
        .content.scaled {
            transform: scale(0.9);
            margin-top: -50px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        footer {
            background-color: rgb(41, 41, 41);
            padding: 30px;
            position: relative;
            bottom: 0;
        }
        footer p {
            font-size: 15px;
            color: white;
            font-family: athiti;
        }
        .contact {
            display: flex;
            justify-content: right;
        }
        .contact img {
            margin: 0%;
            padding-left: 20%;
            padding-right: 20%;
            width: 100%;
        }
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: rgb(30, 26, 39);
            font-family: athiti;
        }
        nav img {
            height: 50px;
        }
        .nav-links {
            display: flex;
            gap: 15px;
            font-family: athiti;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .nav-links a:hover {
            background-color: #555;
        }
        h1 {
            font-family: crimson-text;
            padding: 20px;
            text-align: center;
            font-size: 40px;
        }
        .search, input {
            font-family: athiti;
            width: 400px;
            padding: 10px;
            margin: 10px 0;
        }
        .search {
            width: 100px;
        }
        form {
            text-align: center;
        }
        table {
            margin: 10px;
            margin-bottom: 40px;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
            font-family: athiti;
        }
        th {
            padding: 10px;
            background-color: skyblue;
            font-family: athiti;
        }
        .action-buttons a, .action-buttons form {
            margin-right: 10px;
        }
    </style>

    <script>
        function scaleContent() {
            const content = document.getElementById("content");
            content.classList.add("scaled");

            setTimeout(() => {
                content.classList.remove("scaled");
            }, 1000); // Reset after 1 second
        }
    </script>
</body>
</html>
