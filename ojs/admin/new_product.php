<?php if (!isset($conn)) {
  include 'db_connect.php';
} ?>

<div class="col-lg-12">
  <div class="card card-outline card-primary">
    <div class="card-body">
      <form action="" id="manage-product">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="item_code" value="<?php echo isset($item_code) ? $item_code : '' ?>">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Category</label>
              <select name="category_id" id="category_id" class="form-control select2">
                <option value=""></option>
                <?php
                $qry = $conn->query("SELECT * FROM categories order by name asc");
                while ($row = $qry->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Name</label>
              <input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Price</label>
              <input type="text" class="form-control form-control-sm text-right number" name="price" value="<?php echo isset($price) ? number_format($price) : '' ?>">
            </div>
          </div>
        </div>
        <!--  -->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Warranty(in months)</label>
              <input type="text" class="form-control form-control-sm text-right number" name="warranty" value="<?php echo isset($available_in_store) ? number_format($available_in_store) : ''  ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Available in store</label>
              <input type="text" class="form-control form-control-sm text-right number" name="available_in_store" value="<?php echo isset($available_in_store) ? number_format($available_in_store) : '' ?>">
            </div>
          </div>
        </div>
        <!--  -->
        
        <div class="row">
  <!-- Size Field Section -->
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">Available Size</label>
    </div>

    <!-- Default or Existing Size Fields -->
    <?php if (isset($id) && $id > 0): ?>
      <?php
      $sizes = $conn->query("SELECT * FROM sizes where product_id = $id");
      if ($sizes->num_rows > 0):
        while ($row = $sizes->fetch_assoc()):
      ?>
          <div class="form-group size-group">
            <div class="input-group mb-3">
              <input type="hidden" class="form-control" name="sid[]" value="<?php echo $row['id'] ?>">
              <input type="text" class="form-control" name="size[]" value='<?php echo $row['size'] ?>'>
              <div class="input-group-append">
                <button type="button" class="remove-size btn btn-outline-secondary">Remove</button>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <!-- Rendered if no existing sizes in database -->
        <div class="form-group size-group">
          <div class="input-group mb-3">
            <input type="hidden" class="form-control" name="sid[]">
            <input type="text" class="form-control" name="size[]" placeholder="Enter size">
            <br>
            <br>
            <div class="input-group-append">
              <button type="button" class="remove-size btn btn-outline-secondary">Remove</button>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <!-- Rendered if no ID is set -->
      <div class="form-group size-group">
        <div class="input-group mb-3">
          <input type="hidden" class="form-control" name="sid[]">
          <input type="text" class="form-control" name="size[]" placeholder="Enter size">
          <br>
          <br>
          <div class="input-group-append">
            <button type="button" class="remove-size btn btn-outline-secondary">Remove</button>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Add Size Button -->
    <div class="form-group">
      <div class="d-flex justify-content-end w-100">
        <button class="btn btn-flat bg-light border" type="button" id="add_size">+ Add Size</button>
      </div>
    </div>
  </div>

  <!-- Color Field Section -->
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">Available Color</label>
    </div>

    <!-- Default or Existing Color Fields -->
    <?php if (isset($id) && $id > 0): ?>
      <?php
      $colours = $conn->query("SELECT * FROM colours where product_id = $id");
      if ($colours->num_rows > 0):
        while ($row = $colours->fetch_assoc()):
      ?>
          <div class="form-group color-group">
            <div class="input-group mb-3">
              <input type="hidden" class="form-control" name="cid[]" value="<?php echo $row['id'] ?>">
              <input type="text" class="form-control" name="color[]" value='<?php echo $row['color'] ?>'>
              <br>
            <br>
              <div class="input-group-append">
                <button type="button" class="remove-color btn btn-outline-secondary">Remove</button>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <!-- Rendered if no existing colors in database -->
        <div class="form-group color-group">
          <div class="input-group mb-3">
            <input type="hidden" class="form-control" name="cid[]">
            <input type="text" class="form-control" name="color[]" placeholder="Enter color">
            <br>
            <br>
            <div class="input-group-append">
              <button type="button" class="remove-color btn btn-outline-secondary">Remove</button>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <!-- Rendered if no ID is set -->
      <div class="form-group color-group">
        <div class="input-group mb-3">
          <input type="hidden" class="form-control" name="cid[]">
          <input type="text" class="form-control" name="color[]" placeholder="Enter color">
          <br>
            <br>
          <div class="input-group-append">
            <button type="button" class="remove-color btn btn-outline-secondary">Remove</button>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Add Color Button -->
    <div class="form-group">
      <div class="d-flex justify-content-end w-100">
        <button class="btn btn-flat bg-light border" type="button" id="add_color">+ Add Color</button>
      </div>
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

        
        <div id="f-inputs" class="d-none"></div>

        <div class="callout callout-info">
        
  <div id="actions" class="row">
    <div class="col-lg-6">
      <div class="btn-group w-100" id="upload_btns">
        <span class="btn btn-success btn-flat col-sm-4 col fileinput-button dz-clickable" id="add-files">
          <i class="fas fa-plus"></i>
          <span>Add files</span>
          <input type="file" multiple hidden id="file-input" />
        </span>
      </div>
    </div>
    <div class="col-lg-6 d-flex align-items-center">
      <div class="fileupload-process w-100">
        <div id="total-progress" class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
          <div class="progress-bar" style="width: 0%;" id="progress-bar"></div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="table table-striped files" id="previews">
    <div id="template" class="row mt-2">
      <!-- This template will be cloned for each file upload preview -->
      <div class="col-auto">
        <span class="preview"><img src="data:," alt="" data-thumbnail /></span>
      </div>
      <div class="col d-flex align-items-center">
        <p class="mb-0">
          <span class="lead" data-name></span>
          <span data-size></span>
        </p>
        <strong class="error text-danger" data-error></strong>
      </div>
      <div class="col-4 d-flex align-items-center">
        <div class="progress w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
          <div class="progress-bar" style="width: 0%;" data-upload-progress></div>
        </div>
      </div>
      <div class="col-auto d-flex align-items-center">
        <button class="btn btn-danger delete" type="button" data-delete>
          <i class="fas fa-trash"></i>
          <span>Delete</span>
        </button>
      </div>
    </div>
  </div>
</div>
            <div id="default-preview">
              <?php
              if (isset($item_code) && !empty($item_code)):
                if (is_dir('../assets/uploads/products/' . $item_code)):
                  $_fs = scandir('../assets/uploads/products/' . $item_code);
                  foreach ($_fs as $k => $v):
                    if (is_file('../assets/uploads/products/' . $item_code . '/' . $v) && !in_array($v, array('.', '..'))):
                      $dname = explode('_', $v);
              ?>
                      <div class="def-item">
                        <input type="hidden" class="inp-file" name="dname[]" value="<?php echo $item_code . '/' . $v ?>" data-uuid="<?php echo $k ?>">
                        <div id="" class="row mt-2 dz-processing dz-success dz-complete">
                          <div class="col-auto">
                            <span class="preview"><img src="<?php echo '../assets/uploads/products/' . $item_code . '/' . $v ?>" alt="" data-dz-thumbnail="" style="max-width: 100px"></span>
                          </div>
                          <div class="col d-flex align-items-center">
                            <p class="mb-0">
                              <span class="lead"><?php echo $dname[1] ?></span>
                              (<span><strong><?php echo filesize('../assets/uploads/products/' . $item_code . '/' . $v) ?></strong> Bytes</span>)
                            </p>
                            <strong class="error text-danger" data-dz-errormessage=""></strong>
                          </div>
                          <div class="col-4 d-flex align-items-center">
                            <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                              <div class="progress-bar progress-bar-success" style="width: 100%;" data-dz-uploadprogress=""></div>
                            </div>
                          </div>
                          <div class="col-auto d-flex align-items-center">
                            <div class="btn-group">
                              <button class="btn btn-danger delete" type="button" data-uuid="<?php echo $k ?>">
                                <i class="fas fa-trash"></i>
                                <span>Delete</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <br>
        <br>
        <button type="submit" class="btn-primary">Save</button>
        <button type="reset" class="btn-secondary" value="Reset">Reset</button>
      </form>
    </div>
  </div>
</div>

<script>
 



 document.addEventListener("DOMContentLoaded", function() {
  const fileInput = document.getElementById("file-input");
  const previews = document.getElementById("previews");
  const progressBar = document.getElementById("progress-bar");

  document.getElementById("add-files").addEventListener("click", () => fileInput.click());
  fileInput.addEventListener("change", handleFileSelect);

  function handleFileSelect(event) {
    const files = event.target.files;
    Array.from(files).forEach(file => createPreview(file));
  }

  function createPreview(file) {
    const previewTemplate = document.getElementById("template").cloneNode(true);
    previewTemplate.id = ""; // Remove ID for multiple previews
    previewTemplate.style.display = "flex";

    previewTemplate.querySelector("[data-name]").textContent = file.name;
    previewTemplate.querySelector("[data-size]").textContent = `${(file.size / 1024).toFixed(1)} KB`;

    const reader = new FileReader();
    reader.onload = e => previewTemplate.querySelector("[data-thumbnail]").src = e.target.result;
    reader.readAsDataURL(file);

    const deleteButton = previewTemplate.querySelector("[data-delete]");
    deleteButton.style.display = "none"; // Hide until upload starts

    previews.appendChild(previewTemplate);

    uploadFileWithAjax(previewTemplate, file, deleteButton);
  }

  function uploadFileWithAjax(previewTemplate, file, deleteButton) {
    const uploadProgress = previewTemplate.querySelector("[data-upload-progress]");
    const formData = new FormData();
    formData.append("file", file);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax.php?action=upload_file", true);

    xhr.upload.onprogress = function(event) {
      if (event.lengthComputable) {
        const percentComplete = (event.loaded / event.total) * 100;
        uploadProgress.style.width = percentComplete + "%";
        
        if (percentComplete > 0) {
          deleteButton.style.display = "inline-block";
        }
      }
    };

    xhr.onload = function() {
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);
          if (response.status === 1) {
            const inp = document.createElement("input");
            inp.type = "hidden";
            inp.classList.add("inp-file");
            inp.name = "fname[]";
            inp.value = response.fname;
            document.getElementById("f-inputs").appendChild(inp);

            deleteButton.addEventListener("click", function() {
              deleteFile(previewTemplate, response.fname);
            });

            console.log("File uploaded successfully:", response);
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      } else {
        console.error("Upload error:", xhr.statusText);
      }
      updateProgress();
    };

    xhr.send(formData);
  }

 
  function deleteFile(previewTemplate, filename) {
  // Immediately hide the preview element with a fade-out effect
  previewTemplate.style.transition = "opacity 0.5s";
  previewTemplate.style.opacity = "0";

  // Wait for the fade-out effect to complete before removing from DOM
  setTimeout(() => {
    previewTemplate.remove();
    updateProgress(); // Update progress after removing preview
  }, 500);

  // Proceed to delete from the backend
  fetch('ajax.php?action=delete_file', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({ filename: filename })
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 1) {
      console.log('File deleted successfully on server.');
    } else {
      console.error('Error deleting file on server:', data.message);
      // Optionally, re-attach the preview if the backend deletion fails
    }
  })
  .catch(error => {
    console.error('An error occurred during deletion:', error);
    // Optionally, re-attach the preview if the backend deletion fails
  });
}



  function updateProgress() {
    const totalFiles = previews.querySelectorAll(".row").length;
    const completedFiles = Array.from(previews.querySelectorAll("[data-upload-progress]"))
      .filter(progress => progress.style.width === "100%");

    const totalProgress = (completedFiles.length / totalFiles) * 100;
    progressBar.style.width = totalProgress + "%";
    progressBar.setAttribute("aria-valuenow", totalProgress.toFixed(0));
  }
});



  


document.addEventListener("DOMContentLoaded", function() {
    // Add new size field
    document.getElementById("add_size").addEventListener("click", function() {
        const sizeGroup = document.createElement("div");
        sizeGroup.classList.add("form-group", "size-group");
        sizeGroup.innerHTML = `
            <div class="input-group mb-3">
                <input type="hidden" class="form-control" name="sid[]">
                <input type="text" class="form-control" name="size[]" placeholder="Enter size">
                <br>
            <br>
                <div class="input-group-append">
                    <button type="button" class="remove-size btn btn-outline-secondary">Remove</button>
                </div>
            </div>
        `;
        const addSizeButtonGroup = document.getElementById("add_size").closest(".form-group");
        addSizeButtonGroup.insertAdjacentElement("beforebegin", sizeGroup);
    });

    // Add new color field
    document.getElementById("add_color").addEventListener("click", function() {
        const colorGroup = document.createElement("div");
        colorGroup.classList.add("form-group", "color-group");
        colorGroup.innerHTML = `
            <div class="input-group mb-3">
                <input type="hidden" class="form-control" name="cid[]">
                <input type="text" class="form-control" name="color[]" placeholder="Enter color">
                <br>
            <br>
                <div class="input-group-append">
                    <button type="button" class="remove-color btn btn-outline-secondary">Remove</button>
                </div>
            </div>
        `;
        const addColorButtonGroup = document.getElementById("add_color").closest(".form-group");
        addColorButtonGroup.insertAdjacentElement("beforebegin", colorGroup);
    });

    // Remove size/color field when "Remove" button is clicked
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-size")) {
            e.target.closest(".size-group").remove();
        } else if (e.target.classList.contains("remove-color")) {
            e.target.closest(".color-group").remove();
        }
    });
});





  document.querySelectorAll('.delete').forEach(button => {
  button.addEventListener('click', function () {
    const uuid = this.getAttribute('data-uuid'); // Get the unique identifier for the file
    const filePath = this.closest('.def-item').querySelector('.inp-file').value;

    // Send an AJAX request to delete the file
    fetch('ajax.php?action=remove_file', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ filePath })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Remove the HTML element after successful deletion
        this.closest('.def-item').remove();
      } else {
        console.error('File deletion failed:', data.error);
      }
    })
    .catch(error => console.error('Error:', error));
  });
});


document.getElementById('manage-product').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch('ajax.php?action=save_product', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(response => {
      if (parseInt(response) > 0) {
        alert('Data successfully saved');
        setTimeout(() => {
          window.location.href = 'index.php?page=view_product&id=' + response;
        }, 500);
      } else {
        alert('Changes saved');
        console.log("Response ID:", response); // Check what the response contains
        setTimeout(() => {
          window.location.href = 'index.php?page=product_list'; // Redirect to product_list.php
        }, 500);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while saving. Please try again later.');
    });
});





</script>

<style>
  /* Container for form group */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

/* Label styling */
.form-group label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: #333;
}

/* Input styling */
.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"],
.form-group input[type="file"],
.form-group select,
.form-group textarea {
    padding: 10px 15px;
    font-size: 16px;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
    transition: all 0.3s ease;
}

/* Input focus effect */
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #0056b3;
    box-shadow: 0px 0px 5px rgba(0, 86, 179, 0.3);
}

/* File input styling */
.form-group input[type="file"] {
    padding: 10px 0;
}

/* Button styling */
.form-group button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #0056b3;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.form-group button:hover {
    background-color: #003d7a;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        font-size: 14px;
        padding: 8px 12px;
    }
}

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

  /* Container for file upload actions */
.callout {
  border: 1px solid #007bff;
  background-color: #f1f8ff;
  padding: 15px;
  border-radius: 5px;
}

#upload_btns {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.fileinput-button {
  display: flex;
  align-items: center;
  padding: 10px;
  background-color: #28a745;
  color: white;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.fileinput-button:hover {
  background-color: #218838;
}

/* Preview Table Styling */
.files {
  margin-top: 20px;
  width: 100%;
}

#previews .row {
  display: flex;
  align-items: center;
  margin-top: 10px;
}

.preview img {
  max-width: 80px;
  border-radius: 4px;
  margin-right: 10px;
  margin-top: 10px;
}

.lead {
  font-weight: bold;
}

.progress {
  background-color: #e9ecef;
  border-radius: 4px;
  overflow: hidden;
  height: 10px;
}

.progress-bar {
  background-color: #28a745;
  width: 0;
  height: 100%;
  transition: width 0.3s ease;
}

.delete {
  background-color: #dc3545;
  color: white;
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.delete:hover {
  background-color: #c82333;
}

#previews .delete {
  display: none;
}



</style>