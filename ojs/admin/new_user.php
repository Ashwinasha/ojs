<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<b class="text-muted">Personal Information</b>
						<br>
						<br>
						<div class="form-group">
							<label for="firstname" class="control-label">First Name</label>
							<input type="text" id="firstname" name="firstname" class="form-input" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
						</div>
						<div class="form-group">
							<label for="middlename" class="control-label">Middle Name</label>
							<input type="text" id="middlename" name="middlename" class="form-input" value="<?php echo isset($middlename) ? $middlename : '' ?>">
						</div>
						<div class="form-group">
							<label for="lastname" class="control-label">Last Name</label>
							<input type="text" id="lastname" name="lastname" class="form-input" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
						</div>
						<div class="form-group">
							<label for="contact" class="control-label">Contact No.</label>
							<input type="text" id="contact" name="contact" class="form-input" required value="<?php echo isset($contact) ? $contact : '' ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Address</label>
							<textarea name="address" id="address" cols="30" rows="4" class="form-input" required><?php echo isset($address) ? $address : '' ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="avatar" class="control-label">Avatar</label>
							<input type="file" id="avatar" name="img" class="form-input" onchange="displayImg(this)">
						</div>
						<div class="form-group d-flex justify-content-center">
							<img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar : '' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
						</div>
						<b class="text-muted">System Credentials</b>
						<?php if ($_SESSION['login_type'] == 1): ?>
							<div class="form-group">
								<label for="type" class="control-label">User Role</label>
								<select name="type" id="type" class="form-input">
									<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>User</option>
									<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Admin</option>
								</select>
							</div>
						<?php else: ?>
							<input type="hidden" name="type" value="3">
						<?php endif; ?>
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" id="email" class="form-input" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Password</label>
							<input type="password" id="password" class="form-input" name="password" <?php echo isset($id) ? "" : 'required' ?>>
							<small><i><?php echo isset($id) ? "Leave this blank if you don't want to change your password" : '' ?></i></small>
						</div>
						<div class="form-group">
							<label class="control-label">Confirm Password</label>
							<input type="password" id="cpass" class="form-input" name="cpass" <?php echo isset($id) ? 'required' : '' ?>>
							<small id="pass_match" data-status=''></small>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn-primary" type="submit">Save</button>
					<button class="btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	/* Custom CSS */
	.form-input {
		width: 100%;
		padding: 8px;
		margin-bottom: 10px;
		border: 1px solid #ccc;
		border-radius: 4px;
	}
	.btn-primary, .btn-secondary {
		padding: 8px 16px;
		margin: 0 5px;
		cursor: pointer;
	}
	.btn-primary {
		background-color: #007bff;
		color: #fff;
		border: none;
	}
	.btn-secondary {
		background-color: #6c757d;
		color: #fff;
		border: none;
	}
	img#cimg {
		max-height: 15vh;
	}
</style>

<script>
	// Password Matching
	document.getElementById('password').addEventListener('keyup', checkPasswordMatch);
	document.getElementById('cpass').addEventListener('keyup', checkPasswordMatch);

	function checkPasswordMatch() {
		const password = document.getElementById('password').value;
		const cpass = document.getElementById('cpass').value;
		const passMatch = document.getElementById('pass_match');

		if (cpass === '' || password === '') {
			passMatch.setAttribute('data-status', '');
			passMatch.innerHTML = '';
		} else if (cpass === password) {
			passMatch.setAttribute('data-status', '1');
			passMatch.innerHTML = '<i class="text-success">Password Matched.</i>';
		} else {
			passMatch.setAttribute('data-status', '2');
			passMatch.innerHTML = '<i class="text-danger">Password does not match.</i>';
		}
	}

	// Display Image Preview
	function displayImg(input) {
		if (input.files && input.files[0]) {
			const reader = new FileReader();
			reader.onload = function (e) {
				document.getElementById('cimg').setAttribute('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

// Form Submission
document.getElementById('manage_user').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    // Simulating AJAX behavior
    fetch('ajax.php?action=save_user', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(resp => {
        console.log("Response:", resp); // Debugging line
        if (resp === '1') {
            alert('Data successfully saved.');
            setTimeout(() => {
                window.location.replace('index.php?page=user_list');
            }, 500);
        } else if (resp === '2') {
            document.getElementById('msg').innerHTML = "<div style='color: red;'>Email already exists.</div>";
            document.getElementById('email').classList.add("border-danger");
        } else {
            alert('Unexpected response: ' + resp); // To catch any unexpected responses
        }
    })
    .catch(error => {
        console.error("Error during fetch:", error); // Debugging error handling
    });
});

</script>
