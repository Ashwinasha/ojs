<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users WHERE id =" . $_GET['id']);
    foreach($user->fetch_array() as $k => $v){
        $meta[$k] = $v;
    }
}
?>


<div class="container1">
    

    <!-- The Modal -->
    <div id="userModal" class="modal" style="display: block;"> <!-- Display modal by default -->
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="" id="manage-user">  
            <div id="msg"></div>  
            <br>
            <br>
                <h1>Manage Account</h1>
                <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="name">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
                    <small><i>Leave this blank if you don't want to change the password.</i></small>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Avatar</label>
                    <div class="file-input">
                        <input type="file" id="customFile" name="img" onchange="displayImg(this)"><br><br>
                        
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <img src="<?php echo isset($meta['avatar']) ? 'assets/uploads/' . $meta['avatar'] : '' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>
                <div class="button-container">
                    <button type="submit">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<style>

h1 {
    background-color: #007bff; /* Blue background color */
    color: white; /* White text color */
    text-align: center; /* Center the text horizontally */
    padding: 10px; /* Add padding for better spacing */
    border-radius: 5px; /* Optional: adds rounded corners */
    margin: 20px auto; /* Center the element and add vertical spacing */
    width: fit-content; /* Adjusts the width to fit the content */
}

  
    /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f8; /* Light gray background */
    color: #333; /* Darker text color */
    margin: 0;
    padding: 0;
    justify-content: center;
    align-items: center;
}



/* Modal Styling */
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
}


.container1 {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    width: 100%; /* Ensure full width */
    position: relative; /* Center the content on the page */
}

.modal-content {
    margin: auto; /* Center modal content */
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}


/* Close Button */
.close {
    color: #888;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    margin-top: -10px;
}

.close:hover {
    color: #333;
}

/* Form Styling */
form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
    display: inline-block;
}

input[type="text"],
input[type="password"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border-radius: 4px;
    border: 1px solid #ddd;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus,
input[type="file"]:focus {
    border-color: #4CAF50; /* Green color on focus */
}

small {
    font-size: 12px;
    color: #666;
}

.file-input {
    display: flex;
    align-items: center;
}

#cimg {
    max-height: 15vh;
    margin-top: 10px;
    border-radius: 8px;
    border: 2px solid #ccc;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

button {
    cursor: pointer;
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    margin-top: 10px;
    transition: background-color 0.3s ease;
    font-size: 16px;
    background-color: blue;
    
}

button:hover {
    background-color: brown;
}

/* Alert Styling */
.alert {
    padding: 10px;
    color: white;
    border-radius: 4px;
    margin-top: 10px;
}

.alert-danger {
    background-color: #f44336; /* Red */
}

.alert-success {
    background-color: #4CAF50; /* Green */
}

.button-container {
  display: flex;
  justify-content: center; /* Centers the button horizontally */
  align-items: center; /* Centers the button vertically (optional) */
}

</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Get the modal and close elements
    var modal = document.getElementById('userModal');
    var span = document.getElementsByClassName('close')[0];

    // Close the modal when the close button (x) is clicked and redirect to admin/index.php
    span.onclick = function () {
        if (modal) {
            modal.style.display = 'none';
            // Redirect to admin/index.php
            window.location.href = 'index.php';
        }
    }

    // Close the modal when clicking outside of the modal content
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            // Redirect to admin/index.php
            window.location.href = 'index.php';
        }
    }

    // Display uploaded image
    window.displayImg = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('cimg').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Handle form submission with vanilla JavaScript
    document.getElementById('manage-user').addEventListener('submit', function (e) {
        e.preventDefault();
        fetch('ajax.php?action=update_user', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.text())
        .then(data => {
            if (data == 1) {
                alert('Data successfully saved');
                setTimeout(function () {
                    // Redirect to admin/index.php after successful save
                    window.location.href = 'index.php';
                }, 500);
            } else {
                document.getElementById('msg').innerHTML = '<div class="alert alert-danger">Username already exists</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});


</script>
