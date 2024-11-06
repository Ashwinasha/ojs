<?php include 'admin/db_connect.php' ?>
<div class="col-lg-12">
	<div class="custom-card">
		<div class="card-body">
			<table class="custom-table">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Date Ordered</th>
						<th class="text-center">Order Code</th>
						<th class="text-center">Delivery Address</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$query = $conn->query("SELECT * FROM orders where user_id = '{$_SESSION['login_id']}' order by unix_timestamp(date_created)");
					while($row= $query->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td><?php echo date("M d, Y", strtotime($row['date_created'])) ?></td>
						<td><?php echo $row['ref_id'] ?></td>
						<td><?php echo $row['delivery_address'] ?></td>
						<td class="text-center">
							<?php if ($row['status'] == 0): ?>
								<span class="badge badge-secondary">Pending</span>
							<?php elseif ($row['status'] == 1): ?>
								<span class="badge badge-primary">Verified</span>
							<?php elseif ($row['status'] == 2): ?>
								<span class="badge badge-info">Shipped</span>
							<?php elseif ($row['status'] == 3): ?>
								<span class="badge badge-success">Delivered</span>
							<?php else: ?>
								<span class="badge badge-danger">Cancelled</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
		                    <button data-id="<?php echo $row['id'] ?>" data-code="<?php echo $row['ref_id'] ?>" class="view-order-button">
		                          View Order
	                        </button>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Custom CSS -->
<style>
    .custom-card {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 10px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .custom-table th,
    .custom-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        color: white;
    }

    .badge-secondary { background-color: gray; }
    .badge-primary { background-color: blue; }
    .badge-info { background-color: #17a2b8; }
    .badge-success { background-color: green; }
    .badge-danger { background-color: red; }

    .view-order-button {
        padding: 8px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .view-order-button:hover {
        background-color: #0056b3;
    }
    /* Modal Styles */
.custom-modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 80%;
    margin: auto;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
    margin-bottom: 10px;
}

.modal-header h2 {
    margin: 0;
}

.close-modal {
    cursor: pointer;
    font-size: 24px;
    font-weight: bold;
}

.large {
    width: 60%;
}

.modal-body {
    padding: 10px;
    overflow-y: auto;
    max-height: 400px;
}

</style>
<script>
	document.addEventListener('DOMContentLoaded', function() {
    // Initialize table sorting and search functionality (if needed)
    initializeDataTable();

    // Add event listeners to each 'View Order' button
    var viewOrderButtons = document.querySelectorAll('.view-order-button');
    viewOrderButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var orderId = this.getAttribute('data-id');
            var orderCode = this.getAttribute('data-code');
            uniModal("My Order " + orderCode, "view_order.php?id=" + orderId, "large");
        });
    });
});

// Function to mimic table sorting and search functionality
function initializeDataTable() {
    // You can implement a custom sorting and filtering if needed here
    // For a basic approach, you can loop through rows and filter based on user input
}

function uniModal(title, url, size) {
    // Instead of using an alert, implement a modal window
    // For demonstration, let's dynamically load the content via AJAX
    fetch(url)
        .then(response => response.text())
        .then(data => {
            // Create a modal dynamically
            const modal = document.createElement('div');
            modal.classList.add('custom-modal');

            // Add modal content
            modal.innerHTML = `
                <div class="modal-content ${size}">
                    <div class="modal-header">
                        <h2>${title}</h2>
                        <span class="close-modal">&times;</span>
                    </div>
                    <div class="modal-body">
                        ${data}
                    </div>
                </div>
            `;

            // Append modal to the body
            document.body.appendChild(modal);

            // Close modal functionality
            modal.querySelector('.close-modal').addEventListener('click', () => {
                document.body.removeChild(modal);
            });

            // Close modal when clicking outside the content
            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    document.body.removeChild(modal);
                }
            });
        })
        .catch(error => {
            console.error('Error loading the modal content:', error);
        });
}



</script>