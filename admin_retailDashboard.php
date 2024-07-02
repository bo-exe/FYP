<?php
include "dbFunctions.php";
session_start();

$query = "SELECT COUNT(*) as usedCount FROM offers WHERE redeemed_vouchers = 1";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

$data = array(
    "usedCount" => $row['usedCount']
);

header('Content-Type: application/json');
echo json_encode($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    padding: 20px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.card {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

canvas {
    width: 100% !important;
    height: auto !important;
}

</style>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="card">
            <h2>Voucher Usage</h2>
            <canvas id="voucherChart"></canvas>
        </div>
    </div>
    <script>document.addEventListener("DOMContentLoaded", function() {
    fetch('admin_getVoucherData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('voucherChart').getContext('2d');
            const voucherChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Used Vouchers'],
                    datasets: [{
                        label: 'Number of Used Vouchers',
                        data: [data.usedCount],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
</script>
</body>
</html>
