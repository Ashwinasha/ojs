<?php include 'db_connect.php' ?>
<?php 
$qry = $conn->query("SELECT * FROM orders WHERE id = {$_GET['id']}")->fetch_array();
foreach ($qry as $key => $value) {
	$$key = $value;
}
?>
<div class="container">
	<h2>Update Order Status</h2>
	<form action="" id="update-order">
		<input type="hidden" name="id" value="<?php echo $id ?>">
		<div class="form-group">
			<label for="status">Order Status</label>
			<select name="status" id="status" class="custom-select">
				<option value="0" <?php echo $status == 0 ? 'selected' : '' ?>>Pending</option>
				<option value="1" <?php echo $status == 1 ? 'selected' : '' ?>>Verified</option>
				<option value="2" <?php echo $status == 2 ? 'selected' : '' ?>>Shipped</option>
				<option value="3" <?php echo $status == 3 ? 'selected' : '' ?>>Delivered</option>
				<option value="4" <?php echo $status == 4 ? 'selected' : '' ?>>Cancelled</option>
			</select>
		</div>
		<div class="button-group">
			<button type="button" onclick="submitForm()">Save</button>
			<button type="button" onclick="window.location.href='index.php'">Close</button>
		</div>
	</form>
</div>

<style>
	/* Container and Layout */
	.container {
		width: 100%;
		max-width: 600px;
		margin: 0 auto;
		padding: 20px;
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		border-radius: 8px;
		background-color: #f9f9f9;
	}
	h2 {
		text-align: center;
		margin-bottom: 20px;
		font-size: 1.5rem;
	}

	/* Form styling */
	.form-group {
		margin-bottom: 16px;
		display: flex;
		flex-direction: column;
	}
	label {
		margin-bottom: 8px;
		font-weight: bold;
	}
	.custom-select {
		width: 100%;
		padding: 10px;
		font-size: 1rem;
		border: 1px solid #ccc;
		border-radius: 4px;
	}

	/* Button Group Styling */
	.button-group {
		display: flex;
		justify-content: space-between;
		margin-top: 10px;
	}
	button {
		width: 48%;
		padding: 10px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		font-size: 1rem;
		color: white;
	}
	button:first-of-type {
		background-color: #007bff;
	}
	button:first-of-type:hover {
		background-color: #0056b3;
	}
	button:last-of-type {
		background-color: #dc3545;
	}
	button:last-of-type:hover {
		background-color: #c82333;
	}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('update-order').addEventListener('submit', function(event) {
		event.preventDefault();
		submitForm();
	});
});

function submitForm() {
	const form = document.getElementById('update-order');
	const formData = new FormData(form);

	const xhr = new XMLHttpRequest();
	xhr.open('POST', 'ajax.php?action=update_order', true);
	xhr.onload = function() {
		if (xhr.status === 200 && xhr.responseText == 1) {
			alert("Data successfully saved");
			setTimeout(() => window.location.href = 'index.php', 500);
		}
	};
	xhr.send(formData);
}
</script>
