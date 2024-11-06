<?php
include 'admin/db_connect.php';
$qry = $conn->query("SELECT p.*, c.name as cname,c.description as cdesc FROM products p inner join categories c on c.id = p.category_id where p.item_code = '{$_GET['c']}' ")->fetch_array();
foreach ($qry as $k => $v) {
  if ($k == 'title')
    $k = 'ftitle';
  $$k = $v;
}
$img = array();
if (isset($item_code) && !empty($item_code)):
  if (is_dir('assets/uploads/products/' . $item_code)):
    $_fs = scandir('assets/uploads/products/' . $item_code);
    foreach ($_fs as $k => $v):
      if (is_file('assets/uploads/products/' . $item_code . '/' . $v) && !in_array($v, array('.', '..'))):
        $img[] = 'assets/uploads/products/' . $item_code . '/' . $v;
      endif;
    endforeach;
  endif;
endif;
?>
<style>
  body {
    font-family: Arial, sans-serif;
  }
  
  .container1 {
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .form-group select {
    padding: 10px;
    width: 100%;
    margin-bottom: 20px;
  }

  .bg-gray {
    background-color: #f8f9fa;
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 24px;
    width: 300px;
  }

  .quantity-controls {
    display: flex;
    align-items: center;
  }

  .quantity-controls button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
  }

  .quantity-controls input {
    width: 50px;
    text-align: center;
    padding: 10px;
    margin: 0 5px;
    border: 1px solid #ccc;
  }

  .buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
  }

  .btn-primary {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
  }

  .btn-secondary {
    background-color: #6c757d;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
  }

  .tabs {
    display: flex;
    margin-top: 30px;
    gap: 10px;
  }

  .tab {
    padding: 10px;
    border: 1px solid #ccc;
    cursor: pointer;
  }

  .tab.active {
    background-color: #007bff;
    color: white;
  }

  .tab-content {
    margin-top: 20px;
    padding: 10px;
    
    width: 250px;

  }
  
  

.product-image {
    width: 20%;
    height: auto;
    object-fit: cover;
    border-radius: 5px;
    justify-content: center;
  }

  .product-image-thumbs {
    display: flex;
    gap: 15px;
    margin-top: 15px;
    justify-content: center;
  }

  .product-image-thumb img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease;
    border: 2px solid transparent;
  }

  .product-image-thumb:hover img,
  .product-image-thumb.active img {
    border-color: #007bff;
    transform: scale(1.1);
  }

  
    input[type="number"] {
        width: 50px;
        text-align: center;
    }

    .product-image {
        max-width: 100%;
        height: auto;
    }

    .product-image-thumb {
        cursor: pointer;
        margin-right: 10px;
    }
  
</style>

<div id="alert-message" style="display: none; padding: 10px; margin-bottom: 20px; border-radius: 5px;" class="alert">
    <span id="alert-text"></span>
  </div>

<div class="container1">
  <div class="product-page">
    <div class="row">
      <div class="col-12 col-sm-6">
        <h3 class="d-inline-block d-sm-none"><?php echo $name ?></h3>
        <div class="col-12">
          <img src="<?php echo isset($img[0]) ? $img[0] : '' ?>" class="product-image img-thumbnail" alt="Product Image">
        </div>
        <div class="product-image-thumbs">
                        <?php foreach ($img as $k => $v): ?>
                            <div class="product-image-thumb <?php echo $k == 0 ? 'active' : ''; ?>" onclick="showImage('<?php echo $v; ?>')">
                                <img src="<?php echo $v; ?>" alt="Product Thumbnail" style="width: 50px; height: auto;">
                            </div>
                        <?php endforeach; ?>
                    </div>
      </div>
      <div class="col-12 col-sm-6">
        <h3 class="my-3"><?php echo ucwords($name) ?></h3>
        <p>Category: <?php echo ucwords($cname) ?></p>

        <h4>Available Sizes</h4>
        <?php
        $sizes = $conn->query("SELECT * FROM sizes where product_id = $id");
        $size_arr = array();
        while ($row = $sizes->fetch_assoc()) {
          $size_arr[$row['id']] = $row['size'];
        }
        ?>
        <div class="form-group">
          <select name="size_id" id="size_id">
            <?php if (count($size_arr) == 0): ?>
              <option value="0">N/A</option>
            <?php else: ?>
              <?php foreach ($size_arr as $k => $v): ?>
                <option value="<?php echo $k ?>"><?php echo $v ?></option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <h4>Available Colors</h4>
        <?php
        $colours = $conn->query("SELECT * FROM colours where product_id = $id");
        $colour_arr = array();
        while ($row = $colours->fetch_assoc()) {
          $colour_arr[$row['id']] = $row['color'];
        }
        ?>
        <div class="form-group">
          <select name="colour_id" id="colour_id">
            <?php if (count($colour_arr) == 0): ?>
              <option value="0">N/A</option>
            <?php else: ?>
              <?php foreach ($colour_arr as $k => $v): ?>
                <option value="<?php echo $k ?>"><?php echo $v ?></option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <div class="bg-gray disabled py-2 px-3 mt-4">
          <h2 class="mb-0"><?php echo number_format($price, 2) ?></h2>
        </div>

        <div class="buttons">
          <div class="quantity-controls">
            <button class="btn-minus">-</button>
            <input type="number" name="qty" id="qty" value="1" min="1">
            <button class="btn-plus">+</button>
          </div>
          <button class="btn-primary" id="add_to_cart">Add to Cart</button>
          <a href="./index.php?page=customize&c=<?php echo $item_code ?>" class="btn-secondary" id="customize">Customize</a>
        </div>
      </div>
    </div>

    <div class="tabs">
      <div class="tab active" data-tab="product-desc">Description</div>
      <div class="tab" data-tab="product-cat-desc">Category Description</div>
    </div>
    <div class="tab-content" id="product-desc"><?php echo html_entity_decode($description) ?></div>
    <div class="tab-content" id="product-cat-desc" style="display: none;"><?php echo html_entity_decode($cdesc) ?></div>
  </div>
</div>

<script>

// Ensure the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function() {
  // Event handlers for quantity buttons
  document.querySelectorAll('.btn-minus').forEach(function(button) {
    button.addEventListener('click', function() {
      var qtyInput = this.nextElementSibling;
      var qty = parseInt(qtyInput.value);
      qty = qty > 1 ? qty - 1 : 1; // Prevent qty from going below 1
      qtyInput.value = qty; // Update the input value
    });
  });

  document.querySelectorAll('.btn-plus').forEach(function(button) {
    button.addEventListener('click', function() {
      var qtyInput = this.previousElementSibling;
      var qty = parseInt(qtyInput.value);
      qtyInput.value = qty + 1; // Increment qty
    });
  });

  // Add to cart functionality
  document.getElementById('add_to_cart').addEventListener('click', function() {
  if (!<?php echo isset($_SESSION['login_id']) ? 'true' : 'false'; ?>) {
    window.location.href = 'login.php'; // Redirect to login if not logged in
    return false;
  }

  start_load(); // Call loading function

  var xhr = new XMLHttpRequest();
  xhr.open("POST", 'admin/ajax.php?action=add_to_cart', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    end_load(); // End loading

    if (xhr.responseText == 1) {
      alert("Product successfully added to cart."); // Success alert
    } else {
      alert("Failed to add product to cart."); // Failure alert
    }

    load_cart(); // Update cart display
  };
  xhr.onerror = function() {
    end_load(); // End loading on error
    alert("An error occurred while adding to cart."); // Error alert
  };

  // Prepare data for sending
  var data = 'product_id=<?php echo $id ?>&price=<?php echo $price ?>&qty=' + document.getElementById('qty').value +
             '&colour_id=' + document.getElementById('colour_id').value +
             '&size_id=' + document.getElementById('size_id').value;

  xhr.send(data); // Send the request
});

});


document.addEventListener("DOMContentLoaded", function() {
  const tabs = document.querySelectorAll('.tab');
  const tabContents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      // Remove 'active' class from all tabs
      tabs.forEach(t => t.classList.remove('active'));
      // Add 'active' class to the clicked tab
      tab.classList.add('active');

      // Hide all tab contents
      tabContents.forEach(content => {
        content.style.display = 'none';
      });

      // Show the relevant content based on the clicked tab
      const contentToShow = document.getElementById(tab.getAttribute('data-tab'));
      if (contentToShow) {
        contentToShow.style.display = 'block';
      }
    });
  });
});

function showImage(src) {
  const mainImage = document.querySelector('.product-image');
  if (mainImage) {
    mainImage.src = src;
  }
  
  // Update the active thumbnail style
  document.querySelectorAll('.product-image-thumb').forEach(thumb => {
    thumb.classList.remove('active');
  });
  document.querySelector(`.product-image-thumb img[src="${src}"]`).parentElement.classList.add('active');
}


    
</script>
