<?php include('admin/db_connect.php') ?>
<div class="col-lg-12">
  <div class="row">
    <!-- Categories Sidebar -->
    <div class="col-md-3">
      <div class="category-card">
        <div class="category-header">
          <h3 class="category-title">Categories</h3>
        </div>
        <div class="category-body">
          <ul class="category-list">
            <?php 
            $category = $conn->query("SELECT * FROM categories ORDER BY name ASC");
            while($row = $category->fetch_assoc()):
              $cname[$row['id']] = ucwords($row['name']);
            ?>
              <li class="category-item">
                <input type="checkbox" id="chk<?php echo $row['id'] ?>" class="cat-filter" value="<?php echo $row['id'] ?>">
                <label for="chk<?php echo $row['id'] ?>"><small><?php echo ucwords($row['name']) ?></small></label>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Products Section -->
    <div class="col-md-9 product-section">
      <div class="container-fluid">
        <div class="search-bar">
          <input type="search" id="filter" class="search-input" placeholder="Type your keywords here">
          <button type="button" id="search" class="search-button">Search</button>
        </div>
        <div class="product-list">
            <?php
              $products = $conn->query("SELECT * FROM products ORDER BY rand()");
              while($row = $products->fetch_assoc()):
                $img = array();
                if(isset($row['item_code']) && !empty($row['item_code'])):
                  if(is_dir('assets/uploads/products/'.$row['item_code'])):
                    $_fs = scandir('assets/uploads/products/'.$row['item_code']);
                    foreach($_fs as $k => $v):
                      if(is_file('assets/uploads/products/'.$row['item_code'].'/'.$v) && !in_array($v, array('.', '..'))):
                        $img[] = 'assets/uploads/products/'.$row['item_code'].'/'.$v;
                      endif;
                    endforeach;
                  endif;
                endif;
                $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                $desc = strtr(html_entity_decode($row['description']), $trans);
                $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
            ?>
            <a class="prod-item" href="./index.php?page=view_product&c=<?php echo $row['item_code'] ?>" target="_blank" data-cat="<?php echo $row['category_id'] ?>">
              <div class="product-card">
                <div class="item-img">
                  <img src="<?php echo isset($img[0]) ? $img[0] : '' ?>" alt="Product Image">
                </div>
                <div class="card-details">
                  <h6><?php echo $row['name'] ?></h6>
                  <p class="category"><small><?php echo isset($cname[$row['category_id']]) ? $cname[$row['category_id']] : '' ?></small></p>
                  <p class="description"><?php echo strip_tags($desc) ?></p>
                  <p class="price">Price <?php echo number_format($row['price'], 2) ?></p>
                </div>
              </div>
            </a>
            <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<style>


  /* Container Styling */
  .category-card {
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 500px;
  }

  .category-header {
    border-bottom: 2px solid #007bff;
    margin-bottom: 15px;
  }

  .category-title {
    font-size: 1.5rem;
    margin: 0;
    color: #007bff;
  }

  .category-list {
    list-style: none;
    padding: 0;
  }

  .category-item {
    margin-bottom: 10px;
  }

  /* Product Section Styling */
  .product-section {
    padding-left: 20px;
  }

  .search-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    width: 200px;
  }

  .search-input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
  }

  .search-button {
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .search-button:hover {
    background-color: #0056b3;
  }

  .product-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }

  .card-details {
    padding-top: 10px;
    border-top: 1px solid #007bff;
  }

  .description {
    font-size: 0.9rem;
    color: #666;
    margin: 10px 0;
  }

  .price {
    color: #007bff;
    font-weight: bold;
    font-size: 1.1rem;
  }

  .item-img {
    height: 180px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    margin-bottom: 10px;
  }

  .item-img img {
    max-width: 100%;
    height: auto;
    transition: transform 0.3s;
  }

  .item-img:hover img {
    transform: scale(1.05);
  }

  /* Checkbox Styling */
  .cat-filter {
    margin-right: 8px;
  }

  /* Updated Product Section Styling */
.product-section {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Product List Styling */
.product-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
  align-items: start;
}

.product-card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border: 1px solid #ddd;
  background-color: white;
  padding: 15px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
  border-radius: 5px;
}

</style>

<script>
  document.querySelectorAll('.prod-item').forEach(item => {
    item.addEventListener('mouseenter', () => {
      item.querySelector('.product-card').classList.add('hovered');
    });

    item.addEventListener('mouseleave', () => {
      item.querySelector('.product-card').classList.remove('hovered');
    });
  });

  document.querySelectorAll('.cat-filter').forEach(filter => {
    filter.addEventListener('change', _search);
  });

  function _search() {
    const searchFilter = document.getElementById('filter').value.toLowerCase();
    const filters = document.querySelectorAll('.cat-filter:checked');
    document.querySelectorAll('.prod-item').forEach(item => {
      const txt = item.textContent.toLowerCase();
      const isVisible = txt.includes(searchFilter) &&
        (filters.length === 0 || filters[0].value === item.dataset.cat);
      item.style.display = isVisible ? 'block' : 'none';
    });
  }

  document.getElementById('search').addEventListener('click', _search);
  document.getElementById('filter').addEventListener('keyup', event => {
    if (event.key === 'Enter') _search();
  });
</script>
