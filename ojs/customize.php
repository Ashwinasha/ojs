<?php
include 'admin/db_connect.php';

// Fetch product data
$qry = $conn->query("SELECT p.*, c.name as cname, c.description as cdesc FROM products p INNER JOIN categories c ON c.id = p.category_id WHERE p.item_code = '{$_GET['c']}'")->fetch_array();

foreach ($qry as $k => $v) {
    if ($k == 'title') {
        $k = 'ftitle';
    }
    $$k = $v;
}

$img = [];
if (isset($item_code) && !empty($item_code)) {
    if (is_dir('assets/uploads/products/' . $item_code)) {
        $_fs = scandir('assets/uploads/products/' . $item_code);
        foreach ($_fs as $v) {
            if (is_file('assets/uploads/products/' . $item_code . '/' . $v) && !in_array($v, ['.', '..'])) {
                $img[] = 'assets/uploads/products/' . $item_code . '/' . $v;
            }
        }
    }
}
?>
<style>
     .container1 {
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .product-image {
    width: 20%;
    height: auto;
    object-fit: cover;
    border-radius: 5px;
    justify-content: center;
  }

  .product-image-thumbs {
    display: flex;
    gap: 15px;
    margin-top: 15px;
    justify-content: center;
  }

  .product-image-thumb img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease;
    border: 2px solid transparent;
  }

  .product-image-thumb:hover img,
  .product-image-thumb.active img {
    border-color: #007bff;
    transform: scale(1.1);
  }

  
    input[type="number"] {
        width: 50px;
        text-align: center;
    }

    .product-image {
        max-width: 100%;
        height: auto;
    }

    .product-image-thumb {
        cursor: pointer;
        margin-right: 10px;
    }

    .product-image-thumb.active img {
        border: 2px solid blue; /* Active image border */
    }

    .tab-content {
        
        padding: 10px;
        margin-top: 10px;
    }

    .hidden {
        display: none;
    }

    .nav-tab-item {
    margin-right: 20px; /* Increase gap between tab buttons */
    padding: 10px 15px; /* Padding for better click area */
    border: 1px solid black; /* Make border transparent by default */
    background-color: #f8f9fa; /* Default background */
    color: #000; /* Default text color */
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s; /* Transition for hover and active effects */
}

.nav-tab-item.active {
    background-color: #007bff; /* Active tab background color */
    color: white; /* Active tab text color */
    border-color: #007bff; /* Add border color for active tab */
}

.nav-tab-item:hover {
    background-color: #e2e6ea; /* Hover color */
    border-color: #007bff; /* Add border color on hover */
}


    .btn-qty {
        background-color: #007bff; /* Button color */
        color: white; /* Button text color */
        border: none;
        padding: 5px 10px;
        margin: 0 5px; /* Margin for spacing */
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s; /* Transition for hover effect */
    }

    .btn-qty:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    .form-control {
        border: 1px solid #ccc; /* Light border */
        border-radius: 5px; /* Rounded corners */
        padding: 10px; /* Inner padding */
        width: 100%; /* Full width */
        resize: vertical; /* Vertical resizing only */
        margin-top: 5px; /* Margin on top */
    }

    select {
        border: 1px solid #007bff; /* Blue border */
        border-radius: 5px; /* Rounded corners */
        padding: 10px; /* Inner padding */
        width: 100%; /* Full width */
        margin-top: 5px; /* Margin on top */
        background-color: #f8f9fa; /* Light background */
        color: #007bff; /* Blue text color */
        font-size: 1em; /* Font size */
    }

    /* Placeholder styles for the select fields */
    select option[value="0"] {
        color: #6c757d; /* Gray color for "N/A" option */
    }

    /* Style for the placeholder in textarea */
    textarea::placeholder {
        color: #6c757d; /* Gray color for placeholder text */
    }

    /* Style for the Place Order button */
    #send_request {
        background-color: #007bff; /* Button color */
        color: white; /* Button text color */
        border: none;
        padding: 10px 15px; /* Padding for the button */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer;
        transition: background-color 0.3s; /* Transition for hover effect */
    }

    #send_request:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    /* Product Price */
    .product-price {
        font-size: 1.5em; /* Larger font size */
        color: #007bff; /* Blue color */
        font-weight: bold; /* Bold text */
    }

    input[type="number"] {
    width: 50px;
    text-align: center;
    border: 1px solid #007bff; /* Blue border */
    border-radius: 5px; /* Rounded corners */
    padding: 5px; /* Inner padding */
    margin: 0 5px; /* Margin for spacing */
}

input[type="text"],
input[type="number"],
textarea,
select {
    width: 200px; /* Set the width to 200px */
}

/* Apply to elements with the class 'custom-width' */
.custom-width {
    width: 400px;
}


    /* Add any additional styles you need */
</style>

<div class="container1">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="d-inline-block d-sm-none"><?php echo $name; ?></h3>
                    <div>
                        <img src="<?php echo isset($img[0]) ? $img[0] : ''; ?>" class="product-image" alt="Product Image">
                    </div>
                    <div class="product-image-thumbs">
                        <?php foreach ($img as $k => $v): ?>
                            <div class="product-image-thumb <?php echo $k == 0 ? 'active' : ''; ?>" onclick="showImage('<?php echo $v; ?>')">
                                <img src="<?php echo $v; ?>" alt="Product Thumbnail" style="width: 50px; height: auto;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="my-3"><?php echo ucwords($name); ?></h3>
                    <p>Category: <?php echo ucwords($cname); ?></p>
                    <hr>

                    <h4>Available Sizes</h4>
                    <div>
                        <select name="size_id" id="size_id">
                            <?php
                            $sizes = $conn->query("SELECT * FROM sizes WHERE product_id = $id");
                            if ($sizes->num_rows === 0): ?>
                                <option value="0">N/A</option>
                            <?php else: ?>
                                <?php while ($row = $sizes->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['size']; ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <h4>Available Colors</h4>
                    <div>
                        <select name="colour_id" id="colour_id">
                            <?php
                            $colours = $conn->query("SELECT * FROM colours WHERE product_id = $id");
                            if ($colours->num_rows === 0): ?>
                                <option value="0">N/A</option>
                            <?php else: ?>
                                <?php while ($row = $colours->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['color']; ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div>
                        <h2 class="mb-0"><?php echo number_format($price, 2); ?></h2>
                    </div>

                    <div class="mt-4">
                        <button class="btn-qty" onclick="changeQty(-1)">-</button>
                        <input type="number" id="qty" value="1" min="1">
                        <button class="btn-qty" onclick="changeQty(1)">+</button>
                    </div>

                    <br>
                    <div class="my-3">
                        <label>Customization Requests</label><br>
                        <textarea id="cus_req" class="form-control custom-width"></textarea>
                    </div>

                    <div class="my-3">
                        <label>Delivery Address</label><br>
                        <textarea id="delivery_address" class="form-control custom-width"></textarea>
                    </div>

                    <br>

                    <button id="send_request">Place Order</button>
                </div>
            </div>

            <br> <br>

            <div class="row mt-4">
                <nav class="w-100">
                    <div class="nav nav-tabs" id="product-tab">
                        <button class="nav-tab-item nav-item nav-link active" onclick="openTab('product-desc')">Description</button>
                        <button class="nav-tab-item nav-item nav-link" onclick="openTab('product-cat-desc')">Category Description</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="product-desc">
                        <p><?php echo html_entity_decode($description); ?></p>
                    </div>
                    <div class="tab-pane fade hidden" id="product-cat-desc">
                        <p><?php echo html_entity_decode($cdesc); ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

function changeQty(amount) {
        const qtyInput = document.getElementById('qty');
        let qty = parseInt(qtyInput.value) || 1;
        qty += amount;
        qty = Math.max(qty, 1);
        qtyInput.value = qty;
        qtyInput.dispatchEvent(new Event('change'));
    }

    

    function openTab(tabId) {
        const tabs = document.querySelectorAll('.tab-content > div');
        tabs.forEach(tab => {
            tab.classList.add('hidden');
            if (tab.id === tabId) {
                tab.classList.remove('hidden');
            }
        });

        const buttons = document.querySelectorAll('.nav-item');
        buttons.forEach(button => button.classList.remove('active'));
        event.currentTarget.classList.add('active');
    }


    document.addEventListener('DOMContentLoaded', function() {
    // Event listeners for minus button
    document.querySelectorAll('.btn-minus').forEach(function(button) {
        button.addEventListener('click', function() {
            var qtyInput = button.previousElementSibling; // Get the input field
            var qty = parseInt(qtyInput.value) || 1; // Ensure qty is a number
            qty = qty > 1 ? qty - 1 : 1; // Decrease qty or set to 1
            qtyInput.value = qty; // Update the input field
            qtyInput.dispatchEvent(new Event('change')); // Trigger change event
        });
    });

    // Event listeners for plus button
    document.querySelectorAll('.btn-plus').forEach(function(button) {
        button.addEventListener('click', function() {
            var qtyInput = button.previousElementSibling; // Get the input field
            var qty = parseInt(qtyInput.value) || 0; // Ensure qty is a number
            qty = qty + 1; // Increase qty
            qtyInput.value = qty; // Update the input field
            qtyInput.dispatchEvent(new Event('change')); // Trigger change event
        });
    });

    // Event listener for send request button
    document.getElementById('send_request').addEventListener('click', function() {
    if ('<?php echo !isset($_SESSION['login_id']) ?>' == 1) {
        window.location.href = 'login.php'; // Redirect to login
        return false; // Prevent further execution
    }
    start_load(); // Custom loading function

    var formData = new FormData(); // Create a FormData object
    formData.append('product_id', '<?php echo $id ?>');
    formData.append('price', '<?php echo $price ?>');
    formData.append('qty', document.getElementById('qty').value);
    formData.append('colour_id', document.getElementById('colour_id').value);
    formData.append('size_id', document.getElementById('size_id').value);
    formData.append('msg', document.getElementById('cus_req').value);
    formData.append('delivery_address', document.getElementById('delivery_address').value);

    // AJAX request
    fetch('admin/ajax.php?action=custom_req', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Get response as text
    .then(resp => {
        if (resp == 1) {
            alert_toast("Customization request sent successfully", "success"); // Show toast message
            alert("Customization request sent successfully!"); // Basic alert message
            end_load(); // Custom loading function
            load_cart(); // Custom function to load cart
        } else {
            alert("There was an error sending the request. Please try again."); // Error message
        }
    })
    .catch(error => {
        alert("An error occurred. Please try again."); // Error message
        console.error('Error:', error);
        end_load(); // Custom loading function
    });
});

});

function showImage(src) {
  const mainImage = document.querySelector('.product-image');
  if (mainImage) {
    mainImage.src = src;
  }
  
  // Update the active thumbnail style
  document.querySelectorAll('.product-image-thumb').forEach(thumb => {
    thumb.classList.remove('active');
  });
  document.querySelector(`.product-image-thumb img[src="${src}"]`).parentElement.classList.add('active');
}


</script>
