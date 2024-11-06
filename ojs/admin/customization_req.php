<?php
include 'db_connect.php';

if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit;
}
?>
<div class="container mb-5">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Product</th>
                        <th>User</th>
                        <th>Requested Customization</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $conn->query("SELECT * FROM customization WHERE status = 'pending' ORDER BY unix_timestamp(date_created) DESC");
                    while ($row = $query->fetch_assoc()):
                        $qry = $conn->query("SELECT p.item_code as item_code, name as name FROM products p WHERE p.id = '{$row['product_id']}'")->fetch_array();
                        $uqry = $conn->query("SELECT u.firstname as firstname FROM users u WHERE u.id = '{$row['user_id']}'")->fetch_array();
                    ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><a href="./index.php?page=view_product&id=<?php echo $row['product_id'] ?>"><?php echo $qry['name'] ?></a></td>
                            <td><?php echo $uqry['firstname'] ?></td>
                            <td>
                                <ul>
                                    <li><?php echo $row['message'] ?></li>
                                </ul>
                            </td>
                            <td>
                                <button class="button button-primary" onclick="handleStatus(<?php echo $row['id'] ?>, 'accepted')">Accept</button>
                                <button class="button button-danger" onclick="handleStatus(<?php echo $row['id'] ?>, 'denied')">Deny</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="toast" class="toast">Customization request updated successfully</div>

<script>
    function handleStatus(id, status) {
    showLoader();

    fetch('ajax.php?action=update_custom_req', {
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

    function showToast() {
        const toast = document.getElementById("toast");
        toast.className = "toast show";
        setTimeout(() => toast.className = toast.className.replace("show", ""), 3000);
    }
</script>

<style>
    /* Custom CSS for table and buttons */
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
        text-align: left;
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
    }

    .button-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
    }

    .button-danger {
        background-color: #dc3545;
        color: #fff;
        border: none;
    }

    .button-primary:hover {
        background-color: #0056b3;
    }

    .button-danger:hover {
        background-color: #b21f2d;
    }

    .toast {
        visibility: hidden;
        min-width: 250px;
        margin: 0 auto;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 17px;
    }

    .toast.show {
        visibility: visible;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @keyframes fadein {
        from {bottom: 0; opacity: 0;} 
        to {bottom: 30px; opacity: 1;}
    }

    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;} 
        to {bottom: 0; opacity: 0;}
    }

    .loading {
        cursor: wait;
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
