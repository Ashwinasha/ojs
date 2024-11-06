<?php
include 'db_connect.php';

$query = "SELECT s.id, p.name, p.warranty, u.firstname, s.updated_on, s.order_item_id, p.id AS pid, s.message
          FROM service_requests s
          JOIN products p ON s.product_id = p.id
          JOIN users u ON s.user_id = u.id 
          WHERE s.request_type = 'r' AND s.status = 'pending'";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>

<div class="container mb-5">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Product Name</th>
                        <th>User</th>
                        <th>Purchase Date</th>
                        <th>Repair Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        $request_id = $row['id'];
                        $product_name = $row['name'];
                        $username = $row['firstname'];
                        $order_item_id = $row['order_item_id'];
                        $message = $row['message'];

                        // Fetch the purchase date from order_items
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
                            <td><?php echo $username; ?></td>
                            <td><?php echo $purchase_date; ?></td>
                            <td><?php echo $message; ?></td>
                            <td>
                                <button class="button button-primary" onclick="handleStatus(<?php echo $request_id; ?>,'accepted')">Accept</button>
                                <button class="button button-danger" onclick="handleStatus(<?php echo $request_id; ?>,'rejected')">Deny</button>
                            </td>
                        </tr>

                        <!-- Modal for images -->
                        <div id="viewImagesModal<?php echo $request_id; ?>" class="modal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Damaged Product Images - Request <?php echo $request_id; ?></h5>
                                    <span class="close" onclick="closeModal(<?php echo $request_id; ?>)">&times;</span>
                                </div>
                                <div class="modal-body">
                                    <div class="row gap-3 align-items-center justify-content-center">
                                        <div class="col-5 mb-3">
                                            <img src="https://via.placeholder.com/300" class="img-fluid" alt="Damaged Product Image 1">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="button button-secondary" onclick="closeModal(<?php echo $request_id; ?>)">Close</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="toast" class="toast">Customization request updated successfully</div>


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
    /* Custom CSS for layout */
    .container {
        margin-bottom: 20px;
        width: 100%;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .table-striped tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .button {
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 0.9rem;
        cursor: pointer;
        outline: none;
        transition: background-color 0.3s ease;
        border: none;
    }

    .button-primary {
        background-color: #007bff;
        color: #fff;
    }

    .button-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .button-primary:hover {
        background-color: #0056b3;
    }

    .button-danger:hover {
        background-color: #b21f2d;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        border-radius: 8px;
    }

    .modal-header,
    .modal-body,
    .modal-footer {
        padding: 12px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }


    @keyframes fadein {
        from {bottom: 0; opacity: 0;} 
        to {bottom: 30px; opacity: 1;}
    }

    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;} 
        to {bottom: 0; opacity: 0;}
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
