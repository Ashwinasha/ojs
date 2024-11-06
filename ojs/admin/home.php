<?php include('db_connect.php') ?>
<style>

    /* Custom styles replacing Bootstrap */
    

    .col-12, .col-sm-6, .col-md-3 {
        padding: 10px;
        box-sizing: border-box;
    }

    /* For different column sizes */
    .col-12 {
        flex: 0 0 100%;
    }

    .col-sm-6 {
        flex: 0 0 50%;
    }

    .col-md-3 {
        flex: 0 0 25%;
    }

    .info-box {
      margin-left: 250px;
        display: flex;
        background-color: #f4f6f9;
        border-radius: 5px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        padding: 10px;
        margin-bottom: 15px;
    }

    .info-box-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #fff;
        width: 60px;
        height: 60px;
        border-radius: 5px;
        margin-right: 10px;
    }

    .bg-info {
        background-color: #17a2b8;
    }

    .bg-primary {
        background-color: #007bff;
    }

    .info-box-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-box-text {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .info-box-number {
        font-size: 1.5rem;
        color: #555;
    }

    /* Card styles */
    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-body {
        padding: 15px;
        font-size: 1rem;
        color: #555;
    }
</style>

<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM users where type = 2")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-gem"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Product</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM products")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pending Orders</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM orders where status = 0")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Delivered Orders</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM orders where status = 3")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                Welcome <?php echo $_SESSION['login_name'] ?>!
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-folder"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Documents</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM documents where user_id = {$_SESSION['login_id']}")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Add this script for JavaScript-based interactions (if needed) -->
<script>
    // JavaScript code can go here if you need dynamic interactions in the future.
</script>
