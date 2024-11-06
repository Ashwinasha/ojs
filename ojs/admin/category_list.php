<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn-add-new" href="./index.php?page=new_category">+ Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table" id="list">
				<colgroup>
					<col width="10%">
					<col width="30%">
					<col width="50%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM categories order by unix_timestamp(date_created) desc ");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b class="truncate"><?php echo strip_tags($desc) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="./index.php?page=edit_category&id=<?php echo $row['id'] ?>" class="btn-edit">Edit</a>
		                        <button type="button" class="btn-delete" data-id="<?php echo $row['id'] ?>">Delete</button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<style>
	/* Styles for buttons and layout */
	.btn-add-new, .btn-edit, .btn-delete {
		display: inline-block;
		padding: 5px 10px;
		margin: 2px;
		text-decoration: none;
		color: #fff;
		border-radius: 3px;
		cursor: pointer;
	}
	.btn-add-new { background-color: #007bff; }
	.btn-edit { background-color: #28a745; }
	.btn-delete { background-color: #dc3545; }
	.table { width: 100%; border-collapse: collapse; }
	.table th, .table td { padding: 10px; border: 1px solid #ddd; text-align: center; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
	// Initialize delete buttons
	document.querySelectorAll('.btn-delete').forEach(button => {
		button.addEventListener('click', function() {
			const categoryId = this.getAttribute('data-id');
			if (confirm("Are you sure to delete this category?")) {
				deleteCategory(categoryId);
			}
		});
	});
});

// Delete category function
function deleteCategory(id) {
	const xhr = new XMLHttpRequest();
	xhr.open('POST', 'ajax.php?action=delete_category', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
		if (xhr.status === 200 && xhr.responseText == 1) {
			alert("Data successfully deleted");
			setTimeout(() => location.reload(), 1500);
		}
	};
	xhr.send('id=' + id);
}
</script>
