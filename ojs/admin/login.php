<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Online Jewelry Shop</title>

  <?php include('./header.php'); ?>
  <?php 
  if(isset($_SESSION['login_id']))
    header("location:index.php?page=home");
  ?>

  <style>
    body {
  width: 100%;
  height: 100%;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #343a40;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: Arial, sans-serif;
}

#main {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.card {
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
  padding: 30px;
  margin: 20px;

}



.form-group {
  margin-bottom: 20px;
  margin-right: 20px;
}

.form-group label {
  font-weight: 600;
  color: #495057;
  display: block;
  margin-bottom: 8px;
  font-size: 14px;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.3s;
}

.form-group input:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
}

.btn-primary {
  background-color: #007bff;
  color: #ffffff;
  border: none;
  padding: 12px 15px;
  width: 100%;
  cursor: pointer;
  border-radius: 4px;
  font-size: 16px;
  font-weight: bold;
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.alert {
  color: #ffffff;
  background-color: #dc3545;
  padding: 12px;
  margin-bottom: 15px;
  border-radius: 5px;
  font-size: 14px;
  text-align: center;
}

.text-center {
  text-align: center;
}

.text-white {
  color: #ffffff;
}

h4 {
  font-weight: bold;
  margin-bottom: 20px;
}

  </style>
</head>

<body>

  <main id="main">
    <div class="align-self-center w-100">
      <h4 class="text-white text-center"><b>Online Jewelry Shop - Admin</b></h4>
      <div id="login-center" class="row justify-content-center">
        <div class="card">
          <div class="card-body">
            <form id="login-form">
              <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="text" id="email" name="email" class="form-control">
              </div>
              <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" id="password" name="password" class="form-control">
              </div>
              <button type="submit" class="btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const button = this.querySelector('button');
      button.disabled = true;
      button.textContent = 'Logging in...';
      
      const alertDiv = this.querySelector('.alert');
      if (alertDiv) alertDiv.remove();
      
      fetch('ajax.php?action=login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(new FormData(this)).toString()
      })
      .then(response => response.text())
      .then(resp => {
        if (resp === '1') {
          window.location.href = 'index.php?page=home';
        } else {
          const errorDiv = document.createElement('div');
          errorDiv.className = 'alert';
          errorDiv.textContent = 'Username or password is incorrect.';
          this.insertBefore(errorDiv, this.firstChild);
          button.disabled = false;
          button.textContent = 'Login';
        }
      })
      .catch(err => {
        console.log(err);
        button.disabled = false;
        button.textContent = 'Login';
      });
    });

    // Function to allow only numbers in an input field
    document.querySelectorAll('.number').forEach(function(input) {
      input.addEventListener('input', function() {
        let val = this.value.replace(/[^0-9,]/g, '');
        this.value = new Intl.NumberFormat('en-US').format(val.replace(/,/g, ''));
      });
    });
  </script>
</body>
</html>
