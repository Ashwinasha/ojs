<?php
include 'db_connect.php';

$query = "SELECT s.id, p.name, p.warranty, u.firstname, s.updated_on, s.order_item_id, p.id AS pid, s.message
          FROM service_requests s
          JOIN products p ON s.product_id = p.id
          JOIN users u ON s.user_id = u.id 
          WHERE s.request_type = 'w' AND s.status = 'pending'";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Product Name</th>
                        <th>Warranty Period</th>
                        <th>User</th>
                        <th>Purchase Date</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) :
                        $request_id = $row['id'];
                        $product_name = $row['name'];
                        $warranty_period = $row['warranty'];
                        $username = $row['firstname'];
                        $request_date = $row['updated_on'];
                        $order_item_id = $row['order_item_id'];

                        $query1 = "SELECT date_created FROM order_items WHERE id = ?";
                        $stmt = $conn->prepare($query1);
                        $stmt->bind_param("i", $order_item_id);
                        $stmt->execute();
                        $purchaseResult = $stmt->get_result();
                        $purchase_date = $purchaseResult->num_rows > 0 ? $purchaseResult->fetch_assoc()['date_created'] : 'N/A';
                        $stmt->close();
                    ?>
                    <tr>
                        <td>
                            <a href="#" class="fw-bold" style="color: blue;" onclick="openModal(<?php echo $request_id; ?>)">
                                <?php echo $request_id; ?>
                            </a>
                        </td>
                        <td><a class="fw-semibold" style="color: blue;" href="index.php?page=view_product&id=<?php echo $row['pid']; ?>"><?php echo $product_name; ?></a></td>
                        <td><?php echo $warranty_period; ?></td>
                        <td><?php echo $username; ?></td>
                        <td><?php echo $purchase_date; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td>
                            <button class="btn btn-primary" onclick="handleStatus(<?php echo $request_id; ?>, 'accepted')">Accept</button>
                            <button class="btn btn-danger" onclick="handleStatus(<?php echo $request_id; ?>, 'rejected')">Deny</button>
                        </td>
                    </tr>

                    <div class="modal" id="viewImagesModal<?php echo $request_id; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Damaged Product Images - Request <?php echo $request_id; ?></h5>
                                    <button type="button" onclick="closeModal(<?php echo $request_id; ?>)">Close</button>
                                </div>
                                <div class="modal-body">
                                    <img src="https://via.placeholder.com/300" alt="Damaged Product Image 1">
                                    <img src="https://via.placeholder.com/300" alt="Damaged Product Image 2">
                                    <img src="https://via.placeholder.com/300" alt="Damaged Product Image 3">
                                    <img src="https://via.placeholder.com/300" alt="Damaged Product Image 4">
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" onclick="closeModal(<?php echo $request_id; ?>)">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function handleStatus(id, status) {
    showLoader();

    fetch('ajax.php?action=update_user_req', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&status=${status}`
    })
    .then(response => response.text())
    .then(resp => {
        if (resp === "1") {
            alert(`Request has been ${status === 'accepted' ? 'accepted' : 'denied'}.`);
            location.reload();
        } else {
            alert("There was an error processing your request. Please try again.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please check your connection and try again.");
    })
    .finally(hideLoader);
}

    function showLoader() {
        document.body.classList.add("loading");
    }

    function hideLoader() {
        document.body.classList.remove("loading");
    }

    function openModal(request_id) {
        document.getElementById(`viewImagesModal${request_id}`).style.display = 'flex';
    }

    function closeModal(request_id) {
        document.getElementById(`viewImagesModal${request_id}`).style.display = 'none';
    }
</script>

<style>
    /* style.css */
.container {
    margin-bottom: 3rem;
    max-width: 100%;
    padding: 1rem;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 1.5rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table-striped tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-dialog {
    background: #fff;
    padding: 1rem;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
}

.modal-content {
    padding: 1rem;
}

.modal-header,
.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.modal-body img {
    width: 100%;
    border-radius: 5px;
}

.loading::after {
    content: "Loading...";
    display: block;
    position: fixed;
    top: 50%;
    left: 50%;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    padding: 0.5rem;
    border-radius: 5px;
}

</style>