<?php
include 'admin/db_connect.php';

function checkOrderItemExists($order_item_id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT COUNT(*) FROM service_requests WHERE order_item_id = ?");
    $stmt->bind_param("i", $order_item_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['COUNT(*)'] > 0) {
        return true;
    } else {
        return false;
    }

    $stmt->close();
}
?>
<div class="container1" id="warrantyModal">
    <div class="modal-body">
        <form id="requestForm" enctype="multipart/form-data" method="POST">
            <input type="hidden" id="order_item_id" name="order_item_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <input type="hidden" id="request_type" name="request_type" value="<?php echo isset($_GET['r']) ? $_GET['r'] : ''; ?>">
            <input type="hidden" id="product_id" name="product_id" value="<?php echo isset($_GET['p']) ? $_GET['p'] : ''; ?>">

            <div class="form-group">
                <label for="message" class="form-label">Message:</label>
                <textarea id="message" name="message" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="images" class="form-label">Upload Images:</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
                <small>Upload up to 4 images of the product.</small>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button <?php echo checkOrderItemExists($_GET['id']) ? "disabled" : ''; ?> type="button" id="submit" onclick="submitForms()">Submit Request</button>
    </div>
</div>

<style>
    /* Container Styling */
    .container1 {
        width: 100%;
        max-width: 500px;
        margin: auto;
        padding: 20px;
        background-color: #f9f9f9;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .modal-body {
        padding: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }
    textarea, input[type="file"] {
        width: 100%;
        padding: 8px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    small {
        display: block;
        margin-top: 5px;
        font-size: 0.9rem;
        color: #6c757d;
    }
    .modal-footer {
        display: flex;
        justify-content: flex-end;
    }
    #submit {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
    }
    #submit[disabled] {
        background-color: #ccc;
        cursor: not-allowed;
    }
    #submit:hover:not([disabled]) {
        background-color: #0056b3;
    }
</style>

<script>
    
    function submitForms() {
        var isLoggedIn = '<?php echo isset($_SESSION['login_id']) ? 1 : 0; ?>';
        if (isLoggedIn == 0) {
            location.href = 'login.php';
            return false;
        }

        const form = document.getElementById('requestForm');
        const formData = new FormData(form);
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/ajax.php?action=make_req', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                if (xhr.responseText == 1) {
                    alert("Request sent successfully!");
                } else {
                    alert("Error: " + xhr.responseText);
                }
            } else {
                alert("Error occurred: " + xhr.statusText);
            }
        };
        xhr.onerror = function() {
            alert("Error occurred: " + xhr.statusText);
        };
        xhr.send(formData);
    }


</script>

<style>
    /* Custom Loading and Toast Notification */
    .loading::before {
        content: 'Loading...';
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 20px;
        border-radius: 4px;
    }
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #333;
        color: white;
        padding: 10px;
        border-radius: 4px;
        opacity: 0.9;
    }
    .toast.success {
        background-color: #28a745;
    }
</style>
