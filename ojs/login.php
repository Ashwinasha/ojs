<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<head>
  <style>
    /* Basic CSS to replace Bootstrap */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    
    .login-box {
      width: 360px;
      margin: 0 auto;
    }

    .login-logo a {
      font-size: 1.8rem;
      color: #333;
      text-align: center;
      display: block;
      margin-bottom: 20px;
      text-decoration: none;
    }

    .card {
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .login-card-body {
      padding: 20px;
    }

    .login-box-msg {
      text-align: center;
      margin-bottom: 15px;
      font-size: 1.1rem;
    }

    .input-group {
      display: flex;
      margin-bottom: 15px;
    }

    .input-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      outline: none;
    }

    .input-group-append {
      background: #eee;
      border: 1px solid #ccc;
      border-left: 0;
      display: flex;
      align-items: center;
      padding: 0 10px;
    }

    .input-group-text {
      font-size: 1rem;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-align: center;
    }

    .btn:hover {
      background-color: #0056b3;
    }

    .mb-0 {
      margin-bottom: 0;
      text-align: center;
      margin-top: 15px;
    }

    .alert {
      color: white;
      background-color: #f44336;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      text-align: center;
    }

    /* Checkbox styling */
    .icheck-primary {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .icheck-primary input {
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Online Jewelry </b>Shop</a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" id="login-form">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" required placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope">&#9993;</span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" required placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock">&#128274;</span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
              </div>
            </div>
            <br>
            <div class="col-4">
              <button type="submit" class="btn">Sign In</button>
            </div>
          </div>
        </form>
        <p class="mb-0">
          <a href="signup.php" class="text-center">Create Account</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    // JavaScript to replace jQuery
    document.addEventListener('DOMContentLoaded', function () {
      var form = document.getElementById('login-form');
      form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Remove any previous error alerts
        var existingAlert = form.querySelector('.alert');
        if (existingAlert) {
          existingAlert.remove();
        }

        // Start loading indicator (implement this if needed)
        start_load();

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/ajax.php?action=login2', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
          // End loading indicator (implement this if needed)
          end_load();

          if (xhr.status === 200) {
            if (xhr.responseText.trim() === '1') {
              window.location.href = 'index.php?page=home';
            } else {
              var alertDiv = document.createElement('div');
              alertDiv.className = 'alert';
              alertDiv.textContent = 'Username or password is incorrect.';
              form.insertBefore(alertDiv, form.firstChild);
            }
          } else {
            console.error('An error occurred');
          }
        };

        var formData = new FormData(form);
        var encodedData = new URLSearchParams(formData).toString();
        xhr.send(encodedData);
      });
    });

    // Placeholder functions for loading states
    function start_load() {
      // Add your loading spinner or indicator code here
    }

    function end_load() {
      // Remove your loading spinner or indicator code here
    }
  </script>
</body>
</html>
