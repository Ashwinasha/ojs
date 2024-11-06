<!DOCTYPE html>
<html lang="en">
<?php session_start() ?>
<?php 
    include 'header.php'; 
?>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .fixed-layout {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .topbar {
            background-color: #333;
            padding: 10px;
            color: white;
            text-align: center;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
        }

        .content-header {
            padding: 15px;
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .container-md {
            max-width: 960px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            opacity: 0.9;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-dialog {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .footer, .main-footer {
          margin-top: 100px;
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: relative;
            bottom: 0;
        }


       
        
        .btn-close {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .cart-count {
            background-color: red;
            color: white;
            padding: 5px;
            border-radius: 50%;
        }
    </style>
</head>
<body class="fixed-layout">
<div class="wrapper">
  <?php include 'topbar.php'; ?>

  <div class="content-wrapper">
    <div class="toast" id="alert_toast" role="alert">
        <div class="toast-body text-white">
        </div>
    </div>

    <div class="content-container">
      <div class="content-header">
          <?php echo $title; ?>
      </div>

      <section class="content">
          <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            include $page.'.php';
          ?>
      </section>
    </div>

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
            <button type="button" class="button" id="confirm">Continue</button>
            <button type="button" class="button" onclick="closeModal('confirm_modal')">Close</button>
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
            <button type="button" class="button" id="submit" onclick="submitForm()">Save</button>
            <button type="button" class="button" onclick="closeModal('uni_modal')">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="viewer_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class="btn-close" onclick="closeModal('viewer_modal')">X</button>
          <img src="" alt="">
        </div>
      </div>
    </div>
  </div>

  <aside class="control-sidebar"></aside>

  <footer class="main-footer">
    <strong>Copyright &copy; 2024.</strong> All rights reserved.
    <div class="float-right">
      <b>Online Jewelry Shop</b>
    </div>
</footer>
 
</div>



<script>
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
  }

  function showModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
  }

  function submitForm() {
    document.querySelector('#uni_modal form').submit();
  }

  // Toast functions
  function showToast(message) {
    var toast = document.getElementById('alert_toast');
    toast.querySelector('.toast-body').textContent = message;
    toast.style.display = 'block';
    setTimeout(function () {
      toast.style.display = 'none';
    }, 3000);
  }
</script>

<?php include 'footer.php'; ?>
</body>
</html>
