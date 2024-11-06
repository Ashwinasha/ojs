<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<table class="custom-table" id="orderTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Date Ordered</th>
						<th>Order Code</th>
						<th>Delivery Address</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$query = $conn->query("SELECT o.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as name FROM orders o inner join users u on u.id = o.user_id order by unix_timestamp(o.date_created)");
					while($row= $query->fetch_assoc()):
					?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
						<td><?php echo $row['ref_id'] ?></td>
						<td><?php echo $row['delivery_address'] ?></td>
						<td class="text-center">
							<?php if($row['status'] == 0): ?>
								<span class="badge badge-secondary">Pending</span>
							<?php elseif($row['status'] == 1): ?>
								<span class="badge badge-primary">Verified</span>
							<?php elseif($row['status'] == 2): ?>
								<span class="badge badge-info">Shipped</span>
							<?php elseif($row['status'] == 3): ?>
								<span class="badge badge-success">Delivered</span>
							<?php else: ?>
								<span class="badge badge-danger">Cancelled</span>
							<?php endif; ?>
						</td>
						<td>
	                         <div class="btn-group">
		                        <a href="javascript:void(0)" class="btn btn-primary update_order" data-id="<?php echo $row['id'] ?>" data-code="<?php echo $row['ref_id'] ?>">
		                          Edit
		                        </a>
		                         <a href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-code="<?php echo $row['ref_id'] ?>" class="btn btn-info view_order">
		                          View
								</a>
		                        <button type="button" class="btn btn-danger delete_order" data-id="<?php echo $row['id'] ?>">
		                          Delete
		                        </button>
	                      </div>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<style>
	/* Custom table styles */
	.custom-table {
		width: 100%;
		border-collapse: collapse;
	}
	.custom-table th, .custom-table td {
		padding: 10px;
		border: 1px solid #ddd;
		text-align: center;
	}
	.badge {
		padding: 5px 10px;
		border-radius: 3px;
		color: #fff;
	}
	.badge-secondary { background-color: #6c757d; }
	.badge-primary { background-color: #007bff; }
	.badge-info { background-color: #17a2b8; }
	.badge-success { background-color: #28a745; }
	.badge-danger { background-color: #dc3545; }
	.btn {
		padding: 5px 10px;
		margin: 2px;
		border: none;
		border-radius: 3px;
		cursor: pointer;
		color: #fff;
		text-decoration: none;
	}
	.btn-primary { background-color: #007bff; }
	.btn-info { background-color: #17a2b8; }
	.btn-danger { background-color: #dc3545; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
	
	// Redirect to view order page
	document.querySelectorAll('.view_order').forEach(button => {
		button.addEventListener('click', function() {
			const orderId = this.getAttribute('data-id');
			window.location.href = `view_order.php?id=${orderId}`;
		});
	});

	// Redirect to update order page
	document.querySelectorAll('.update_order').forEach(button => {
		button.addEventListener('click', function() {
			const orderId = this.getAttribute('data-id');
			window.location.href = `manage_order.php?id=${orderId}`;
		});
	});

	// Delete Order confirmation
	document.querySelectorAll('.delete_order').forEach(button => {
		button.addEventListener('click', function() {
			const orderId = this.getAttribute('data-id');
			if (confirm("Are you sure to delete this order?")) {
				deleteOrder(orderId);
			}
		});
	});
});

// Delete order AJAX request
function deleteOrder(id) {
	const xhr = new XMLHttpRequest();
	xhr.open('POST', 'ajax.php?action=delete_order', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
		if (xhr.status === 200 && xhr.responseText == 1) {
			alert("Data successfully deleted");
			setTimeout(() => location.reload(), 500);
		}
	};
	xhr.send('id=' + id);
}

// Placeholder function for uniModal
function uniModal(title, url, size) {
	// Custom modal handling logic here
	alert(`${title} - Modal triggered`);
}
</script>
