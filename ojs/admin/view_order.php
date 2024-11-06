<?php include 'db_connect.php' ?>
<style type="text/css">
	.container {
		width: 100%;
		margin: 0 auto;
		font-family: Arial, sans-serif;
		color: #333;
	}

	.img-field {
		width: 25%;
		max-height: 25vh;
		overflow: hidden;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 16px;
		border: 1px solid #ccc;
		border-radius: 5px;
		padding: 8px;
	}

	.detail-field {
		width: 100%;
		font-size: 16px;
	}

	.amount-field {
		width: 25%;
		text-align: right;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: bold;
	}

	.img-field img {
		max-width: 100%;
		max-height: 100%;
		border-radius: 5px;
	}

	.qty-input {
		width: 75px;
		text-align: center;
	}

	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	.list-group {
		padding: 0;
		margin: 0;
		list-style: none;
	}

	.list-group-item {
		border: 1px solid #ddd;
		border-radius: 5px;
		margin-bottom: 8px;
		padding: 16px;
		display: flex;
		background-color: #f9f9f9;
	}

	.card {
		border: 1px solid #ddd;
		border-radius: 8px;
		box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
	}

	.card-header {
		background-color: #007bff;
		color: #fff;
		padding: 10px;
		font-weight: bold;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
	}

	.card-body {
		padding: 20px;
		text-align: right;
	}

	.modal-footer {
		display: flex;
		justify-content: flex-end;
		padding: 10px;
		border-top: 1px solid #ddd;
	}

	.btn-custom {
		background-color: #555;
		color: #fff;
		padding: 8px 16px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		font-size: 14px;
		transition: background-color 0.3s;
	}

	.btn-custom:hover {
		background-color: #333;
	}
</style>

<div class="container">
	<?php
	$qry = $conn->query("SELECT o.*, p.item_code, p.name as pname FROM order_items o INNER JOIN products p ON p.id = o.product_id WHERE o.order_id = {$_GET['id']}");
	$id = (int)$_GET['id'];
	$msg = $conn->query("SELECT message FROM orders WHERE id = $id");
	if ($msg && $msg->num_rows > 0) {
		$msg_row = $msg->fetch_assoc();
		$message = $msg_row['message'];
	}

	$total = 0;
	?>
	<div class="row">
		<div class="col-md-8">
			<?php if ($qry->num_rows > 0): ?>
				<ul class="list-group">
					<?php
					while ($row = $qry->fetch_array()):
						$total += $row['qty'] * $row['price'];
						$size = $conn->query("SELECT * FROM sizes WHERE id = {$row['size_id']}");
						$size = $size->num_rows > 0 ? $size->fetch_array()['size'] : 'N/A';
						$colour = $conn->query("SELECT * FROM colours WHERE id = {$row['colour_id']}");
						$colour = $colour->num_rows > 0 ? $colour->fetch_array()['color'] : 'N/A';
						$img = [];
						if (isset($row['item_code']) && !empty($row['item_code'])):
							if (is_dir('../assets/uploads/products/' . $row['item_code'])):
								$_fs = scandir('../assets/uploads/products/' . $row['item_code']);
								foreach ($_fs as $k => $v):
									if (is_file('../assets/uploads/products/' . $row['item_code'] . '/' . $v) && !in_array($v, ['.', '..'])):
										$img[] = '../assets/uploads/products/' . $row['item_code'] . '/' . $v;
									endif;
								endforeach;
							endif;
						endif;
					?>
						<li class="list-group-item" data-id="<?php echo $row['id'] ?>" data-price="<?php echo $row['price'] ?>">
							<div class="d-flex w-100">
								<div class="img-field">
									<img src="<?php echo isset($img[0]) ? $img[0] : '' ?>" alt="" class="img-fluid rounded">
								</div>
								<div class="detail-field">
									<p>Product Name: <b><?php echo $row['pname'] ?></b></p>
									<p>Price: <b><?php echo number_format($row['price'], 2) ?></b></p>
									<p>Size: <b><?php echo $size ?></b></p>
									<p>Color: <b><?php echo $colour ?></b></p>
									<p>QTY: <b><?php echo number_format($row['qty']) ?></b></p>
									<p>Message: <b><?php echo isset($message) && $message ? $message : '<span style="color: #17a2b8;">No message</span>'; ?></b></p>
								</div>
								<div class="amount-field">
									<b class="amount"><?php echo number_format($row['qty'] * $row['price'], 2) ?></b>
								</div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else: ?>
				<center><b>No Item</b></center>
			<?php endif; ?>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">Total Amount</div>
				<div class="card-body">
					<h4><b id="tamount"><?php echo number_format($total, 2) ?></b></h4>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn-custom" onclick="window.location.href='index.php'">Close</button>
</div>

<script>
	document.querySelector('.btn-custom').addEventListener('click', function () {
		window.location.href = 'index.php?page=orders';
	});
</script>
