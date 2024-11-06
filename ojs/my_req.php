<?php include 'admin/db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Requests</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <div class="container2">

        <!-- Customization Requests Section -->
        <div class="card">
            <div class="card-header">
                <h2>Customization Requests</h2>
            </div>
            <div class="card-body">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Product</th>
                            <th>Customization Details</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = $conn->query("SELECT * FROM customization where user_id = '{$_SESSION['login_id']}' order by unix_timestamp(date_created)");
                        while ($row = $query->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <?php $qry = $conn->query("SELECT p.item_code as item_code ,name as name FROM products p  where p.id = '{$row['product_id']}' ")->fetch_array(); ?>
                                <td><a href="./index.php?page=view_product&c=<?php echo $qry['item_code'] ?>"><?php echo $qry['name'] ?></a></td>
                                <td>
                                    <ul>
                                        <li><?php echo $row['message'] ?></li>
                                    </ul>
                                </td>
                                <td>
                                    <span class="badge <?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Warranty Claims Section -->
        <div class="card">
            <div class="card-header">
                <h2>Warranty Claims</h2>
            </div>
            <div class="card-body">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Claim ID</th>
                            <th>Product</th>
                            <th>Warranty Period</th>
                            <th>Purchase Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $conn->query("SELECT * FROM service_requests where user_id = '{$_SESSION['login_id']}' AND request_type = 'w' order by unix_timestamp(updated_on)");
                        while ($row = $query->fetch_assoc()):
                            $claim_id = $row['id'];
                            $qry = $conn->query("SELECT p.item_code as item_code,p.warranty as warranty ,name as name FROM products p  where p.id = '{$row['product_id']}' ")->fetch_array();
                            $product_name = $qry['name'];
                            $warranty_period = $qry['warranty'];
                            $claim_date = $row['updated_on'];
                            $status = $row['status'];

                            $purchase_query = $conn->query("SELECT date_created FROM order_items WHERE id = '{$row['order_item_id']}'")->fetch_assoc();
                            $purchase_date = $purchase_query ? $purchase_query['date_created'] : 'N/A';
                        ?>
                            <tr>
                                <td><?php echo $claim_id; ?></td>
                                <td><a href="./index.php?page=view_product&c=<?php echo $qry['item_code'] ?>"><?php echo $product_name ?></a></td>
                                <td><?php echo $warranty_period; ?></td>
                                <td><?php echo $purchase_date; ?></td>
                                <td>
                                    <span class="badge <?php echo strtolower($status); ?>"><?php echo ucfirst($status); ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Repair Requests Section -->
        <div class="card">
            <div class="card-header">
                <h2>Repair Requests</h2>
            </div>
            <div class="card-body">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Product</th>
                            <th>Damage Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $repair_query = $conn->query("SELECT sr.id AS request_id, p.name AS product_name, u.firstname AS user_name, 
                            sr.message AS damage_description, sr.status AS repair_status
                            FROM service_requests sr
                            JOIN products p ON sr.product_id = p.id
                            JOIN users u ON sr.user_id = u.id
                            WHERE sr.request_type = 'r' AND sr.status != 'completed' AND sr.user_id = '{$_SESSION['login_id']}'
                            ORDER BY unix_timestamp(sr.updated_on) DESC");

                        while ($row = $repair_query->fetch_assoc()):
                            $request_id = $row['request_id'];
                            $product_name = $row['product_name'];
                            $damage_description = $row['damage_description'];
                            $repair_status = $row['repair_status'];
                        ?>
                            <tr>
                                <td><?php echo $request_id; ?></td>
                                <td><a href="./index.php?page=view_product&c=<?php echo $qry['item_code'] ?>"><?php echo $product_name ?></a></td>
                                <td><?php echo $damage_description; ?></td>
                                <td>
                                    <span class="badge <?php echo strtolower($repair_status); ?>"><?php echo ucfirst($repair_status); ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>

<style>
/* Reset some default styles */
body, h2, p, table {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    color: #333;
    box-sizing: border-box;
}

body {
    background-color: #f5f5f5;
}


.card {
    background-color: #fff;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background-color: #007bff;
    color: #fff;
    padding: 15px;
}

.card-body {
    padding: 15px;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.custom-table th, .custom-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.custom-table th {
    background-color: #f0f0f0;
    font-weight: bold;
}

.custom-table tr:hover {
    background-color: #f9f9f9;
}

.custom-table a {
    color: #007bff;
    text-decoration: none;
}

.custom-table a:hover {
    text-decoration: underline;
}

.badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: bold;
}

.badge.pending {
    background-color: #ffc107;
    color: #000;
}

.badge.accepted {
    background-color: #28a745;
    color: #fff;
}

.badge.rejected, .badge.completed {
    background-color: #dc3545;
    color: #fff;
}

.container2 {
    max-width: 1200px;
    margin: 20px auto;
    padding: 15px;
    display: block; /* Ensure container elements are stacked */
}

.card {
    background-color: #fff;
    margin-bottom: 20px; /* Separate each card vertically */
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: 100%; /* Ensure the card takes full width of the container */
}

</style>
