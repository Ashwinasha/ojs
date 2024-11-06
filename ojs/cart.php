<?php include 'admin/db_connect.php' ?>

<style>


/* Cart Container */
.container1 {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

/* Cart Item Styles */
.list-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    margin-bottom: 15px;
    background-color: #f5f5f5;
    border: none;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s;
}

.list-group-item:hover {
    background-color: #e9ecef;
}

/* Image Field */
.img-field {
    width: 25%;
    max-height: 120px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.img-field img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

/* Detail Field */
.detail-field {
    width: 100%;
    padding-left: 15px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.btn-minus, .btn-plus {
    margin: 0; /* Remove side margins */
    width: 35px;
    height: 35px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    line-height: 1;
    background-color: #007bff;
    color: #fff;
    border: none;
    font-size: 18px;
    width: 30px;  
    height: 30px; 
}

/* Adjust input style to fit between buttons */
.qty-input {
    margin: 0 10px; /* Provide spacing between buttons */
    text-align: center;
    font-size: 16px;
    padding: 3px;
    width: 60px; /* Adjust width if needed */
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-minus:hover, .btn-plus:hover {
    background-color: #0056b3;
}

/* Align Quantity Input */
.qty-input {
    width: 50px;
    text-align: center;
    font-size: 16px; /* Slightly increase font size */
    padding: 3px; /* Adjust padding for better alignment */
    margin: 0 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Remove Button */
.rem_item {
    background: transparent;
    border: none;
    color: #dc3545; /* Red color for visibility */
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s ease;
    position: absolute;
    top: 15px; /* Position the button */
    right: 15px; /* Add spacing from the edges */
}

.rem_item:hover {
    color: #c82333; /* Darker red on hover */
    transform: scale(1.1); /* Slight zoom effect */
}


/* Amount Field */
.amount-field {
    width: 15%;
    text-align: right;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    font-size: 18px;
    font-weight: bold;
}

/* Remove Button */
.rem_item {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s;
}

.rem_item:hover {
    color: #c82333;
}

/* Total Amount Card */
.card {
    background-color: #f8f9fa;
    border: none;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.card-header {
    background-color: #007bff;
    color: #ffffff;
    font-size: 1.25rem;
    border-bottom: none;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    padding: 15px;
}

.card-body {
    padding: 15px;
    font-size: 1.5rem;
    text-align: right;
}

/* Checkout Button */
#checkout {
    width: 10%;
    padding: 15px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    font-weight: bold;
    transition: background-color 0.3s;
    float: right;
}

#checkout:hover {
    background-color: #218838;
}

/* Cart Item Styles */
.list-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    margin-bottom: 15px;
    background-color: #f5f5f5;
    border: none;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s;
    position: relative; /* Added to manage inner elements */
}




.qty-wrapper {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Align horizontally */
    margin-top: 10px; /* Adjust spacing between elements */
}

.btn-minus, .btn-plus {
    margin: 0; /* Remove side margins */
    width: 35px;
    height: 35px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    line-height: 1;
    background-color: #007bff;
    color: #fff;
    border: none;
    font-size: 18px;
    width: 30px;  
    height: 30px; 
    cursor: pointer;
}

.qty-input {
    margin: 0 10px; /* Space between the buttons */
    text-align: center;
    font-size: 16px;
    padding: 3px;
    width: 60px; /* Adjust width if needed */
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Align Amount Field */
.amount-field {
    width: 20%;
    text-align: right;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    font-size: 18px;
    font-weight: bold;
    margin-left: 100px;
    margin-top: 50px; /* Add space between details and amount */
}

/* Custom Danger Button */
.btn-danger {
    background-color: #dc3545; /* Bootstrap's red color */
    color: #fff; /* White text */
    border: none;
    font-size: 16px;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.1s ease;
    display: inline-block;
}

.btn-danger:hover {
    background-color: #c82333; /* Darker red for hover */
    transform: scale(1.05); /* Slight zoom on hover */
}

.btn-danger:active {
    background-color: #bd2130; /* Even darker red on click */
    transform: scale(0.95); /* Press effect */
}



</style>


<div class="col-lg-12">	
    <?php 
    $qry = $conn->query("SELECT c.*,p.item_code,p.name as pname FROM cart c inner join products p on p.id = c.product_id where c.user_id ={$_SESSION['login_id']}");
    $total = 0;
    ?>
    <div class="row">
    <div class="col-md-8">
    	<?php if($qry->num_rows > 0): ?>
    		<ul class="list-group">
    			<?php 
    			while($row= $qry->fetch_array()):
    				$total += $row['qty']*$row['price'];
    				$size = $conn->query("SELECT * FROM sizes where id = {$row['size_id']}");
    				$size = $size->num_rows>0 ? $size->fetch_array()['size'] : 'N/A';
    				$colour = $conn->query("SELECT * FROM colours where id = {$row['colour_id']}");
    				$colour = $colour->num_rows>0 ? $colour->fetch_array()['color'] : 'N/A';
    				$img = array();
					if(isset($row['item_code']) && !empty($row['item_code'])):
			            if(is_dir('assets/uploads/products/'.$row['item_code'])):
			                $_fs = scandir('assets/uploads/products/'.$row['item_code']);
			              foreach($_fs as $k => $v):
				                if(is_file('assets/uploads/products/'.$row['item_code'].'/'.$v) && !in_array($v,array('.','..'))):
				                	$img[] = 'assets/uploads/products/'.$row['item_code'].'/'.$v;
								endif;
							endforeach;
						endif;
					endif;
    			?>
    			<li class="list-group-item" data-id="<?php echo $row['id'] ?>" data-price="<?php echo $row['price'] ?>">
    				<div class="d-flex w-100">
                    <div class="img-field mr-4 img-thumbnail rounded">
                            <?php if (!empty($img[0])): ?>
                                <img src="<?php echo $img[0]; ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>" class="img-fluid rounded">
                            <?php else: ?>
                                <img src="assets/uploads/default.jpg" alt="Default Image" class="img-fluid rounded">
                            <?php endif; ?>
                        </div>

    					<div class="detail-field">
    						<p>Product Name: <b><?php echo $row['pname'] ?></b></p>
    						<p>Price: <b><?php echo number_format($row['price'],2) ?></b></p>
    						<p>Size: <b><?php echo $size ?></b></p>
    						<p>Color: <b><?php echo $colour ?></b></p>
    						<div class="qty-wrapper">
                                <button class="btn btn-minus"><b>-</b></button>
                                <input type="number" name="qty" class="qty-input" value="<?php echo $row['qty'] ?>">
                                <button class="btn btn-plus"><b>+</b></button>
                            </div>


    					</div>
                        <br>
    					<div class="amount-field">
    						<b class="amount">Amount: &nbsp;&nbsp;<?php echo number_format($row['qty']*$row['price'],2) ?></b>
    					</div>
    				<span class="float-right"><button class="btn btn-sm btn-danger rem_item" type="button"  data-id="<?php echo $row['id'] ?>">delete</button></span>
    				</div>
    			</li>
    		<?php endwhile; ?>
    		</ul>
    	<?php else: ?>
    		<center><b>No Item</b></center>
    	<?php endif; ?>
    </div>
    <div class="col-md-4">
    	<div class="card mb-4">
    		<div class="card-header bg-primary text-white"><b>Total Amount</b></div>
    		<div class="card-body">
    			<h4 class="text-right"><b id="tamount"><?php echo number_format($total,2) ?></b></h4>
    		</div>
    	</div>
    	<button class="btn btn-block btn-primary" id="checkout" type="button">Checkout</button>
    </div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const minusButtons = document.querySelectorAll('.btn-minus');
    const plusButtons = document.querySelectorAll('.btn-plus');
    const removeButtons = document.querySelectorAll('.rem_item');
    const checkoutButton = document.getElementById('checkout');
    const tamount = document.getElementById('tamount');

    function updateCart(id, qty, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/ajax.php?action=update_cart', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText.trim() === '1') {
                    callback();
                } else {
                    console.error('Failed to update cart');
                }
            }
        };
        xhr.send(`id=${id}&qty=${qty}`);
    }

    function calculateTotal() {
        const qtyInputs = document.querySelectorAll('.qty-input');
        let total = 0;

        qtyInputs.forEach(function (input) {
            const li = input.closest('li');
            const price = parseFloat(li.getAttribute('data-price'));
            const qty = parseFloat(input.value);
            const amount = qty * price;

            // Update amount display in the cart item
            li.querySelector('.amount').textContent = amount.toLocaleString('en-US', {
                style: 'decimal',
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
        });

        // Calculate total
        document.querySelectorAll('.amount').forEach(function (amountElem) {
            const amount = parseFloat(amountElem.textContent.replace(/,/g, ''));
            total += amount;
        });

        // Update total amount display
        tamount.textContent = total.toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigits: 2,
            minimumFractionDigits: 2
        });
    }

    minusButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const qtyInput = button.nextElementSibling;
            let qty = parseInt(qtyInput.value, 10);
            qty = qty > 1 ? qty - 1 : 1;
            const id = button.closest('li').getAttribute('data-id');

            updateCart(id, qty, function () {
                qtyInput.value = qty;
                calculateTotal();
            });
        });
    });

    plusButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const qtyInput = button.previousElementSibling;
            let qty = parseInt(qtyInput.value, 10) + 1;
            const id = button.closest('li').getAttribute('data-id');

            updateCart(id, qty, function () {
                qtyInput.value = qty;
                calculateTotal();
            });
        });
    });

    removeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.getAttribute('data-id');
            if (confirm('Are you sure to remove this item from the cart?')) {
                deleteCart(id);
            }
        });
    });

    function deleteCart(id) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/ajax.php?action=delete_cart', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText.trim() === '1') {
                    alert('Item removed from cart');
                    const item = document.querySelector(`li[data-id="${id}"]`);
                    if (item) item.remove(); // Remove item from DOM
                    calculateTotal(); // Update total after removal
                } else {
                    console.error('Failed to remove item from cart');
                }
            }
        };
        xhr.send(`id=${id}`);
    }

    checkoutButton.addEventListener('click', function () {
        // Replace this with your modal logic if required.
        window.location.href = 'manage_order.php';
    });
});

</script>
