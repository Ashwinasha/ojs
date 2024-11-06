<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-category">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Category Name</label>
							<input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10">
						<div class="form-group">
							<label for="" class="control-label">Description</label>
							<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
								<?php echo isset($description) ? $description : '' ?>
							</textarea>
						</div>
					</div>
				</div>
    </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-category">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
<script>

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('manage-category');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        start_load(); // Call your loading function
        
        const formData = new FormData(form); // Create a new FormData object

        fetch('ajax.php?action=save_category', {
            method: 'POST',
            body: formData, // Send the form data
        })
        .then(response => response.text()) // Parse the response as text
        .then(resp => {
            console.log('Server response:', resp); // Debugging line
            
            if (resp.trim() === '1') { // Check if response is '1'
                alert_toast('Data successfully saved', "success");
                setTimeout(function() {
                    window.location.href = 'index.php?page=category_list'; // Redirect after success
                }, 2000);
            } else {
                alert_toast('Failed to save data: ' + resp, "error"); // Handle failure
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log any errors
            alert_toast('An error occurred while saving data.', "error"); // Notify user of error
        });
    });

    // Example function for loading indication (you should implement this)
    function start_load() {
        console.log('Load started'); // You can show a loading spinner here
    }

    // Example function to handle alert toast
    function alert_toast(message, type) {
        // You can implement your toast notification logic here
        alert(`${type.toUpperCase()}: ${message}`);
    }

document.querySelector('.btn.bg-gradient-secondary').addEventListener('click', function() {
    form.reset(); // Reset the form on cancel
});

});


</script>

<style>

	/* Card styling */
.card {
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  margin: 20px 0;
  padding: 20px;
  background-color: #fff;
}

.card-footer {
  border-top: 1px solid #ccc;
  padding-top: 10px;
  text-align: center;
}

.card-outline.card-primary {
  border-color: #007bff;
}

/* Form and input styling */
.form-group {
  margin-bottom: 15px;
}

.control-label {
  font-weight: bold;
  margin-bottom: 5px;
}

.form-control {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 3px;
  box-sizing: border-box;
}

.form-control-sm {
  padding: 5px;
}

/* Button styling */
.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  margin: 5px;
}

.btn-flat {
  box-shadow: none;
}

.bg-gradient-primary {
  background-color: #007bff;
  color: #fff;
}

.bg-gradient-secondary {
  background-color: #6c757d;
  color: #fff;
}

/* Flex container for buttons */
.d-flex {
  display: flex;
  justify-content: center;
  align-items: center;
}

.mx-2 {
  margin-left: 10px;
  margin-right: 10px;
}


</style>