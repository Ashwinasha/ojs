<?php session_start() ?>
<div class="container">
    <div class="form-container">
        <p>This transaction accepts only cash on delivery. Please wait for a verification email or call from management after checking out.</p>
        <form id="manage-order">
            <div class="form-group">
                <label for="delivery-address" class="control-label">Delivery Address</label>
                <textarea name="address" id="delivery-address" cols="30" rows="4" class="input-field" required><?php echo $_SESSION['login_address'] ?></textarea>
            </div>
            <button type="submit" class="submit-btn">Submit Order</button>
        </form>
    </div>
</div>

<style>
    .container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .form-container {
        padding: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .control-label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }

    .submit-btn {
        display: inline-block;
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('manage-order');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        startLoad(); // Call the loading function if you have one

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/ajax.php?action=save_order', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onerror = function () {
            console.error('Request failed');
            alertToast('An error occurred. Please try again.', 'error');
            setTimeout(() => {
                window.location.href = 'index.php'; // Redirect to index.php after showing the error
            }, 2000);
        };

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.responseText === '1') {
                    alertToast('Order successfully submitted.', 'success');
                    setTimeout(function () {
                        window.location.href = 'index.php'; // Redirect to index.php after successful submission
                    }, 100);
                } else {
                    alertToast('Failed to submit order. Please try again.', 'error');
                    setTimeout(() => {
                        window.location.href = 'index.php'; // Redirect to index.php after showing the error
                    }, 100);
                }
            }
        };

        const formData = new FormData(form);
        const urlParams = new URLSearchParams(formData).toString();
        xhr.send(urlParams);
    });

    function startLoad() {
        // Implement your loader logic here
        console.log('Loading...');
    }

    function alertToast(message, type) {
        // Implement your toast alert logic here
        alert(message); // Simple alert example, you can customize with a better UI
    }
});
</script>