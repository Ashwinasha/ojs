<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
	$type_arr = array('', "Admin", "User");
	$qry = $conn->query("SELECT *, concat(lastname, ', ', firstname, ' ', middlename) as name FROM users WHERE id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container">
	<div class="card shadow">
		<div class="card-header bg-dark">
			<h3 class="card-title"><?php echo ucwords($name) ?></h3>
			<p class="card-subtitle"><?php echo $email ?></p>
		</div>
		<div class="user-avatar">
			<?php if (empty($avatar) || (!empty($avatar) && !is_file('assets/uploads/' . $avatar))): ?>
				<div class="avatar-placeholder"><?php echo strtoupper(substr($firstname, 0, 1) . substr($lastname, 0, 1)) ?></div>
			<?php else: ?>
				<img class="avatar-img" src="assets/uploads/<?php echo $avatar ?>" alt="User Avatar">
			<?php endif ?>
		</div>
		<div class="card-content">
			<dl>
				<dt>Address</dt>
				<dd><?php echo $address ?></dd>
			</dl>
			<dl>
				<dt>User Type</dt>
				<dd><?php echo $type_arr[$type] ?></dd>
			</dl>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button onclick="window.location.href='index.php'" class="btn-close">Close</button>
</div>

<style>
	/* Container and Card Styles */
	.container {
		width: 100%;
		max-width: 500px;
		margin: auto;
	}

	.card {
		border: 1px solid #ddd;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		background: #fff;
	}

	/* Header Styling */
	.card-header {
		background-color: #333;
		color: #fff;
		padding: 20px;
	}

	.card-title {
		font-size: 24px;
		margin: 0;
	}

	.card-subtitle {
		font-size: 14px;
		margin: 4px 0 0;
	}

	/* Avatar Styling */
	.user-avatar {
		display: flex;
		justify-content: center;
		align-items: center;
		margin-top: -45px;
	}

	.avatar-placeholder {
		width: 90px;
		height: 90px;
		border-radius: 50%;
		background-color: #007bff;
		color: #fff;
		font-size: 24px;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.avatar-img {
		width: 90px;
		height: 90px;
		border-radius: 50%;
		object-fit: cover;
	}

	/* Card Content */
	.card-content {
		padding: 20px;
	}

	dt {
		font-weight: bold;
	}

	dd {
		margin: 0 0 10px 0;
	}

	/* Footer Button */
	.modal-footer {
		display: flex;
		justify-content: center;
		padding: 10px;
	}

	.btn-close {
		padding: 10px 20px;
		background-color: #333;
		color: #fff;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		text-align: center;
		transition: background 0.3s ease;
	}

	.btn-close:hover {
		background-color: #555;
	}
</style>
