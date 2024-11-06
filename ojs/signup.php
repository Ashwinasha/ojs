<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Jewelry Shop - Register</title>
  <style>
    /* Basic CSS styles to replace Bootstrap */
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      max-width: 800px;
      width: 100%;
      background: white;
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .register-logo a {
      font-size: 24px;
      text-align: center;
      display: block;
      margin-bottom: 20px;
    }

    .input-group {
      display: flex;
      margin-bottom: 15px;
    }

    .input-group input,
    .input-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .input-group span {
      background: #eee;
      padding: 10px;
      border: 1px solid #ddd;
      border-left: 0;
      display: inline-block;
      border-radius: 0 4px 4px 0;
    }

    button {
      background-color: #007bff;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: #0056b3;
    }

    .alert {
      color: red;
      margin-top: 10px;
    }

    /* Additional styles */
    .row {
      display: flex;
      justify-content: space-between;
    }

    .col-md-6 {
      width: 48%;
    }

    .border-right {
      border-right: 1px solid #ddd;
    }

    #msg,
    #pass_match {
      font-size: 14px;
    }

    .terms {
      display: flex;
      align-items: center;
    }

    .terms label {
      margin-left: 5px;
    }

    .text-center {
      text-align: center;
    }

    .mb-3 {
      margin-bottom: 20px;
    }

    .text-success {
  color: #28a745;
}

.text-danger {
  color: #dc3545;
}

.alert {
  padding: 10px;
  margin-top: 10px;
  border-radius: 5px;
  font-size: 14px;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}

small {
  color: #555;
  font-size: 12px;
}
  </style>
</head>
<body>
  <div class="container">
    <div class="register-logo">
      <a href="#"><b>Online Jewelry </b>Shop</a>
    </div>
    <?php session_start() ?>
    <?php include('admin/db_connect.php'); ?>
    <?php 
    if (isset($_SESSION['login_id'])) {
        $qry = $conn->query("SELECT * from users where id = {$_SESSION['login_id']} ");
        foreach ($qry->fetch_array() as $k => $v) {
            $$k = $v;
        }
    }
    ?>
    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg"><?php echo !isset($id) ? 'Create Account' : 'Manage Account'; ?></p>
        <form id="manage-signup">
          <input type="hidden" value="<?php echo isset($id) ? $id : '' ?>" name="id">
          <div class="row">
            <div class="col-md-6 border-right">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="firstname" required placeholder="First Name" value="<?php echo isset($firstname) ? $firstname : '' ?>">
                <span class="input-group-text">👤</span>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="<?php echo isset($middlename) ? $middlename : '' ?>">
                <span class="input-group-text">👤</span>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="lastname" required placeholder="Last Name" value="<?php echo isset($lastname) ? $lastname : '' ?>">
                <span class="input-group-text">👤</span>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="contact" required placeholder="Contact Number" value="<?php echo isset($contact) ? $contact : '' ?>">
                <span class="input-group-text">📱</span>
              </div>
              <div class="mb-3">
                <textarea cols="30" rows="3" class="form-control" name="address" required placeholder="Address"><?php echo isset($address) ? $address : '' ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-group mb-3">
                <input type="email" class="form-control" name="email" required placeholder="Email" value="<?php echo isset($email) ? $email : '' ?>">
                <span class="input-group-text">📧</span>
              </div>
             
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" <?php echo isset($id) ? '' : "required" ?> placeholder="Password">
                <span class="input-group-text">🔒</span>
              </div>
              <?php if (isset($id)): ?>
                <small><i>Leave this field blank if you don't want to change your password.</i></small>
              <?php endif; ?>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="cpass" <?php echo isset($id) ? '' : "required" ?> placeholder="Retype password">
                <span class="input-group-text">🔒</span>
              </div>
              <small id="pass_match" data-status=''></small>
            </div>
          </div>
          <div class="row">

            <small id="msg" style="margin-bottom:20px;"></small>
            <br>

            <div class="col-4">
              <button type="submit"><?php echo !isset($id) ? 'Register' : 'Update Account'; ?></button>
            </div>
          </div>
        </form>
        <?php if (!isset($id)): ?>
          <a href="login.php" class="text-center">I have an account already</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
 
  <script>

document.addEventListener('DOMContentLoaded', function () {
  // Form submission
  document.getElementById('manage-signup').addEventListener('submit', function (e) {
    e.preventDefault();

    // Remove previous error styling
    const passwordFields = document.querySelectorAll('input[name="password"], input[name="cpass"]');
    passwordFields.forEach(input => input.classList.remove("border-danger"));
    document.getElementById('msg').innerHTML = '';

    // Check if password matches
    if (document.getElementById('pass_match').dataset.status !== '1') {
      if (document.querySelector('[name="password"]').value !== '') {
        passwordFields.forEach(input => input.classList.add("border-danger"));
        return; // Stop the form submission if passwords do not match
      }
    }

    // Check if terms checkbox is checked
    

    // Create FormData object for AJAX request
    const formData = new FormData(this);

    // Remove the terms checkbox data (if you added it)
    formData.delete('terms');

    // AJAX request using Fetch API
    fetch('admin/ajax.php?action=signup', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(resp => {
      console.log('Response from server:', resp); // Debugging response from server
      if (resp.trim() === '1') {
        alert('Data successfully saved.');
        setTimeout(function () {
          window.location.replace('index.php?page=home');
        }, 750);
      } else if (resp.trim() === '2') {
        document.getElementById('msg').innerHTML = "<div class='alert alert-danger'>Email already exists.</div>";
        document.querySelector('[name="email"]').classList.add("border-danger");
      } else {
        alert('Error occurred: ' + resp); // Show any other server response for debugging
      }
    })
    .catch(error => {
      console.error('Error during AJAX request:', error);
      alert('An error occurred while submitting the form. Please try again.');
    });
  });

  // Password matching check
  const passwordInput = document.querySelector('[name="password"]');
  const confirmPasswordInput = document.querySelector('[name="cpass"]');

  [passwordInput, confirmPasswordInput].forEach(input => {
    input.addEventListener('keyup', function () {
      const pass = passwordInput.value;
      const cpass = confirmPasswordInput.value;
      const passMatch = document.getElementById('pass_match');

      // Check if passwords are empty or matching
      if (cpass === '' || pass === '') {
        passMatch.dataset.status = '';
        passMatch.innerHTML = '';
      } else if (cpass === pass) {
        passMatch.dataset.status = '1';
        passMatch.innerHTML = '<i class="text-success">Password Matched.</i>';
      } else {
        passMatch.dataset.status = '2';
        passMatch.innerHTML = '<i class="text-danger">Password does not match.</i>';
      }
    });
  });
});

</script>

</body>
</html>
