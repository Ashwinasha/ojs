<!DOCTYPE html>
<html lang="en">
<?php session_start() ?>
<?php 
	if(!isset($_SESSION['login_id']))
	    header('location:login.php');
	include 'header.php';
?>
<head>
  <style>
    /* Custom CSS for Vanilla Styling */

    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f6f9;
    }

    .wrapper {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    .content-wrapper {
      flex: 1;
      padding: 20px;
      margin-left: 250px; /* Adjust this if you have a sidebar */
    }

    .container-fluid1 {
      width: 100%;
      margin: 0 auto;
    }

    h1 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 15px;
    }

    hr.border-primary {
      border: 1px solid #007bff;
    }

    /* Toast Message */
    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #333;
      color: white;
      padding: 10px;
      border-radius: 5px;
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .toast.show {
      opacity: 1;
    }

    /* Modals */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
    }

    .modal-dialog {
      position: relative;
      margin: 50px auto;
      width: 50%;
      max-width: 500px;
      background-color: #fff;
      border-radius: 5px;
      overflow: hidden;
    }

    .modal-content {
      padding: 20px;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 10px;
      border-bottom: 1px solid #ccc;
    }

    .modal-title {
      font-size: 18px;
      font-weight: bold;
    }

    .modal-body {
      padding: 15px 0;
    }

    .modal-footer {
      display: flex;
      justify-content: flex-end;
      padding-top: 10px;
      border-top: 1px solid #ccc;
    }

    .btn {
      padding: 8px 15px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      margin-left: 10px;
    }

    .btn-primary {
      background-color: #007bff;
      color: white;
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn-close {
      background: transparent;
      border: none;
      cursor: pointer;
    }

    
    /* Footer */
    .main-footer {
      background-color: #f8f9fa;
      padding: 10px 15px;
      text-align: center;
      border-top: 1px solid #dee2e6;
    }

    /* Close Button Icon */
    .fa-times, .fa-arrow-right {
      color: #333;
      cursor: pointer;
    }

    /* Button Styles */
    .fa {
      margin-right: 5px;
    }
  </style>
</head>
<body>
<div class="wrapper">
  <?php include 'topbar.php' ?>
  <?php include 'sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	 <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
	    <div class="toast-body text-white">
	    </div>
	  </div>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid1">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title ?></h1>
          </div>
        </div>
        <hr class="border-primary">
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid1">
         <?php 
          $page = isset($_GET['page']) ? $_GET['page'] : 'home';
          include $page.'.php';
          ?>
      </div>
    </section>
    <!-- /.content -->
    
    <!-- Modals -->
    <div class="modal" id="confirm_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirmation</h5>
          </div>
          <div class="modal-body">
            <div id="delete_content"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary" onclick="closeModal('confirm_modal')">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" id="uni_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"></h5>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='submit' onclick="document.querySelector('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-secondary" onclick="closeModal('uni_modal')">Cancel</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" id="uni_modal_right">
      <div class="modal-dialog modal-full-height">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="btn-close" onclick="closeModal('uni_modal_right')">
              <span class="fa fa-arrow-right"></span>
            </button>
          </div>
          <div class="modal-body"></div>
        </div>
      </div>
    </div>
    <div class="modal" id="viewer_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class="btn-close" onclick="closeModal('viewer_modal')">
            <span class="fa fa-times"></span>
          </button>
          <img src="" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline-block">
      <b>Online Jewelry Shop</b>
    </div>
  </footer>
</div>

<!-- Custom JavaScript -->
<script>
  // JavaScript for opening and closing modals
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
  }

  function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
  }

  // Example: Display toast message
  function showToast(message) {
    const toast = document.getElementById('alert_toast');
    toast.querySelector('.toast-body').innerText = message;
    toast.classList.add('show');
    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  }
</script>
</body>
</html>