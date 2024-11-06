<?php include'db_connect.php' ?>
<div class="container">
	<div class="card">
		<div class="card-header">
			<button class="btn-add" onclick="window.location.href='./index.php?page=new_product'">
				<i class="fa fa-plus"></i> Add New
			</button>
		</div>
		<div class="card-body">
			<table class="table" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Item Code</th>
						<th>Product</th>
						<th>Name</th>
						<th>Stock Available</th>
						<th>Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT p.*, c.name as cname FROM products p INNER JOIN categories c ON c.id = p.category_id ORDER BY p.name ASC");
					while($row = $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td><?php echo $row['item_code'] ?></td>
						<td><?php echo ucwords($row['cname']) ?></td>
						<td><?php echo ucwords($row['name']) ?></td>
						<td><?php echo $row['available_in_store'] ?></td>
						<td class="text-right"><?php echo number_format($row['price']) ?></td>
						<td class="text-center">
		                    <div class="action-group">
		                        <a href="./index.php?page=edit_product&id=<?php echo $row['id'] ?>" class="btn btn-edit">
		                          <i class="fas fa-edit">edit</i>
		                        </a>
		                        <a href="./index.php?page=view_product&id=<?php echo $row['id'] ?>" class="btn btn-view">
		                          <i class="fas fa-eye">view </i>
		                        </a>
		                        <button type="button" class="btn btn-delete" onclick="confirmDelete(<?php echo $row['id'] ?>)">
		                          <i class="fas fa-trash">delete</i>
		                        </button>
	                      </div>
						</td>
					</tr>	
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		const deleteButtons = document.querySelectorAll('.btn-delete');
		deleteButtons.forEach(button => {
			button.addEventListener('click', function() {
				const productId = this.getAttribute('data-id');
				confirmDelete(productId);
			});
		});
	});

	function confirmDelete(id) {
		if (confirm("Are you sure you want to delete this product?")) {
			deleteProduct(id);
		}
	}

	function deleteProduct(id) {
		fetch('ajax.php?action=delete_product', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'id=' + id
		})
		.then(response => response.text())
		.then(resp => {
			if (resp == 1) {
				alert("Data successfully deleted");
				setTimeout(() => location.reload(), 1500);
			}
		})
		.catch(error => console.error("Error:", error));
	}
</script>

<style>
	/* General container and card styling */
	.container {
		width: 100%;
		max-width: 900px;
		margin: auto;
		padding-top: 20px;
	}
	.card {
		border: 1px solid #ddd;
		border-radius: 8px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		background: #fff;
		overflow: hidden;
	}

	.card-header {
		padding: 15px;
		border-bottom: 1px solid #ddd;
		background-color: #f8f9fa;
		display: flex;
		justify-content: flex-end;
	}

	.btn-add {
		padding: 10px 20px;
		background-color: #007bff;
		color: #fff;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		transition: background-color 0.3s;
	}
	.btn-add:hover {
		background-color: #0056b3;
	}

	/* Table styling */
	.table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 10px;
	}
	.table th, .table td {
		padding: 12px;
		border: 1px solid #ddd;
		text-align: center;
	}
	.table th {
		background-color: #f1f1f1;
		font-weight: bold;
	}

	/* Action buttons */
	.action-group {
		display: flex;
		gap: 8px;
	}

	.btn {
		padding: 8px 12px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		color: #fff;
		transition: background-color 0.3s;
		display: inline-flex;
		align-items: center;
		justify-content: center;
	}

	a{
		text-decoration: none;
	}

	.btn-edit { background-color: #28a745; }
	.btn-edit:hover { background-color: #218838; }

	.btn-view { background-color: #17a2b8; }
	.btn-view:hover { background-color: #138496; }

	.btn-delete { background-color: #dc3545; }
	.btn-delete:hover { background-color: #c82333; }
</style>
