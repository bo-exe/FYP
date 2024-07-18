<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vouchers Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="images/admin_logo.jpg">
</head>
<body>
    <?php
    include "dbFunctions.php";
    include "admin_retailNavbar.php";
    include "ft.php";

    // Query to get total redeemed vouchers per offer
    $query = "SELECT title, SUM(redeemed_vouchers) AS total_redeemed_vouchers 
              FROM offers 
              GROUP BY title";
    $result = mysqli_query($link, $query);

    // Prepare data for Chart.js
    $labels = [];
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['title'];
        $data[] = $row['total_redeemed_vouchers'];
    }

    // Convert data arrays to JSON for JavaScript
    $labels = json_encode($labels);
    $data = json_encode($data);

    // Debugging output
    var_dump($labels, $data);
    ?>

    <div class="container">
        <h1>Vouchers Usage by Offer</h1>
        <canvas id="voucherChart" width="400" height="400"></canvas>
    </div>

    <script>
// Parse PHP variables from PHP to JavaScript
var labels = <?php echo $labels; ?>;
var data = <?php echo $data; ?>;

// Debugging output in JavaScript console
console.log(labels);
console.log(data);

// Create a bar chart using Chart.js
var ctx = document.getElementById('voucherChart').getContext('2d');
var voucherChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: JSON.parse(labels), // Parse JSON string back to array
        datasets: [{
            label: 'Vouchers Used',
            data: JSON.parse(data), // Parse JSON string back to array
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Customize color if needed
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Vouchers Used'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Offer Title'
                }
            }
        }
    }
});

// Check for any JavaScript errors in console
console.log("Chart initialized:", voucherChart);

    </script>
</body>
</html>
