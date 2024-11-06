<?php
include 'db_connect.php';
$qry = $conn->query("SELECT p.*, c.name as cname, c.description as cdesc FROM products p INNER JOIN categories c ON c.id = p.category_id WHERE p.id = '{$_GET['id']}'")->fetch_array();
foreach ($qry as $k => $v) {
  if ($k == 'title') $k = 'ftitle';
  $$k = $v;
}
$img = array();
if (isset($item_code) && !empty($item_code)):
  if (is_dir('../assets/uploads/products/' . $item_code)):
    $_fs = scandir('../assets/uploads/products/' . $item_code);
    foreach ($_fs as $k => $v):
      if (is_file('../assets/uploads/products/' . $item_code . '/' . $v) && !in_array($v, array('.', '..'))):
        $img[] = '../assets/uploads/products/' . $item_code . '/' . $v;
      endif;
    endforeach;
  endif;
endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Page</title>
  <style>
    /* Custom CSS */
    .container { max-width: 1200px; margin: auto; padding: 20px; }
    .card { background-color: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .row { display: flex; flex-wrap: wrap; }
    .col-12 { flex: 100%; }
    .col-sm-6 { flex: 50%; }
    .product-image { max-width: 100%; border-radius: 8px; }
    .product-image-thumbs { display: flex; gap: 10px; margin-top: 10px; }
    .product-image-thumb { cursor: pointer; transition: transform 0.3s; border: 2px solid transparent; border-radius: 8px; }
    .product-image-thumb.active, .product-image-thumb:hover { transform: scale(1.1); border-color: #333; }
    .product-info h3 { margin-top: 0; }
    .badge { background-color: green; color: white; padding: 5px 10px; border-radius: 10px; font-size: 12px; }
    .tabs { display: flex; gap: 20px; cursor: pointer; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
    .tab { padding: 10px 20px; background: #ddd; border-radius: 5px; }
    .tab.active { background-color: #333; color: #fff; }
    .tab-content { display: none; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-top: 10px; }
    .tab-content.active { display: block; }

    .main-image {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 400px;
  overflow: hidden;
  border-radius: 8px;
  background-color: #f3f3f3;
  margin-right: 100px;
}

.main-image img.product-image {
  max-height: 100%;
  max-width: 100%;
  object-fit: cover;
  border-radius: 8px;
}

.product-image-thumbs {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 10px;
  flex-wrap: wrap;
}

.product-image-thumb {
  width: 80px;
  height: 80px;
  cursor: pointer;
  transition: transform 0.3s;
  border: 2px solid transparent;
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 100px;
}

.product-image-thumb img {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover;
}

.product-image-thumb.active, .product-image-thumb:hover {
  transform: scale(1.1);
  border-color: #333;
}
  </style>
</head>
<body>

<div class="container">
  <div class="card">
    <div class="row">
      <div class="col-12 col-sm-6">
        <h3 class="product-title"><?php echo $name; ?></h3>
        <div class="main-image">
          <img src="<?php echo isset($img[0]) ? $img[0] : ''; ?>" class="product-image" alt="Product Image">
        </div>
        <div class="product-image-thumbs">
          <?php foreach ($img as $k => $v): ?>
            <div class="product-image-thumb <?php echo $k == 0 ? 'active' : ''; ?>">
              <img src="<?php echo $v; ?>" alt="Product Image" onclick="setMainImage(this)">
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-12 col-sm-6 product-info">
        <h3><?php echo ucwords($name); ?></h3>
        <p>Category: <?php echo ucwords($cname); ?></p>
        <p>In Stock: <span class="badge"><?php echo ucwords($available_in_store); ?></span></p>
        
        <h4>Available Sizes</h4>
        <?php
          $sizes = $conn->query("SELECT * FROM sizes WHERE product_id = $id");
          $size_arr = array();
          while ($row = $sizes->fetch_assoc()) {
            $size_arr[] = $row['size'];
          }
        ?>
        <p><i><?php echo implode(', ', $size_arr); ?></i></p>

        <h4>Available Colors</h4>
        <?php
          $colours = $conn->query("SELECT * FROM colours WHERE product_id = $id");
          $colour_arr = array();
          while ($row = $colours->fetch_assoc()) {
            $colour_arr[] = $row['color'];
          }
        ?>
        <p><i><?php echo implode(', ', $colour_arr); ?></i></p>

        <div class="price">
          <h2><?php echo number_format($price, 2); ?></h2>
        </div>
      </div>
    </div>

    <div class="tabs">
      <div class="tab active" onclick="showTab('description')">Description</div>
      <div class="tab" onclick="showTab('category')">Category Description</div>
    </div>

    <div id="description" class="tab-content active"><?php echo html_entity_decode($description); ?></div>
    <div id="category" class="tab-content"><?php echo html_entity_decode($cdesc); ?></div>
  </div>
</div>

<script>
  // JavaScript functions
  function setMainImage(thumb) {
    document.querySelector('.product-image').src = thumb.src;
    document.querySelectorAll('.product-image-thumb').forEach(img => img.classList.remove('active'));
    thumb.parentElement.classList.add('active');
  }

  function showTab(tabId) {
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.querySelector('.tab[onclick="showTab(\'' + tabId + '\')"]').classList.add('active');
    document.getElementById(tabId).classList.add('active');
  }
</script>

</body>
</html>
