<?php include 'db_connect.php' ?>

<br>
<br>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary custom-btn" href="./index.php?page=new_user">
                    <i class="fa fa-plus"></i> Add New User
                </a>
            </div>
        </div>
		<br>
		<br>
        <div class="card-body">
            <table class="table tabe-hover table-bordered custom-table" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Contact #</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $type = array('', "Admin", "User");
                    $qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM users order by concat(lastname,', ',firstname,' ',middlename) asc");
                    while ($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['name']) ?></b></td>
                        <td><b><?php echo $row['contact'] ?></b></td>
                        <td><b><?php echo $type[$row['type']] ?></b></td>
                        <td><b><?php echo $row['email'] ?></b></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info custom-action-btn" data-id="<?php echo $row['id'] ?>">
                                Action
                            </button>
                            <div class="dropdown-menu custom-dropdown">
                                <a class="dropdown-item view_user" href="./index.php?page=view_user&id=<?php echo $row['id'] ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
    .custom-btn {
        padding: 8px;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th, .custom-table td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    .custom-dropdown {
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        display: none;
        width: 150px;
    }

    .custom-action-btn:hover + .custom-dropdown,
    .custom-dropdown:hover {
        display: block;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete User
        document.querySelectorAll('.delete_user').forEach(function(deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const confirmDelete = confirm("Are you sure to delete this user?");
                if (confirmDelete) {
                    deleteUser(userId);
                }
            });
        });
    });

    // Delete user with vanilla JS
    function deleteUser(id) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax.php?action=delete_user", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText === '1') {
                alert("Data successfully deleted");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        };
        xhr.send(`id=${id}`);
    }
</script>
