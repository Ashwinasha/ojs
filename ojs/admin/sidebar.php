<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="dropdown">
    <a href="javascript:void(0)" class="brand-link dropdown-toggle" id="userDropdown">
      <?php if(empty($_SESSION['login_avatar'])): ?>
        <span class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 38px; height: 50px;">
          <?php echo strtoupper(substr($_SESSION['login_firstname'], 0,1).substr($_SESSION['login_lastname'], 0,1)) ?>
        </span>
      <?php else: ?>
        <span class="image">
          <img src="assets/uploads/<?php echo $_SESSION['login_avatar'] ?>" style="width: 38px; height: 38px;" class="img-circle elevation-2" alt="User Image">
        </span>
      <?php endif; ?>
      <span class="brand-text font-weight-light"><?php echo ucwords($_SESSION['login_firstname'].' '.$_SESSION['login_lastname']) ?></span>
    </a>
    <div class="dropdown-menu" id="dropdownMenu">
      <a class="dropdown-item manage_account" href="javascript:void(0)" data-id="<?php echo $_SESSION['login_id'] ?>">Manage Account</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="ajax.php?action=logout">Logout</a>
    </div>
  </div>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" role="menu">
        <li class="nav-item">
          <a href="./" class="nav-link nav-home">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>    
        <li class="nav-item">
          <a href="#" class="nav-link nav-is-tree nav-edit_category nav-view_category">
            <i class="nav-icon fa fa-th-list"></i>
            <p>Categories <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="./index.php?page=new_category" class="nav-link nav-new_category tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>Add New</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index.php?page=category_list" class="nav-link nav-category_list tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>List</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="./index.php?page=orders" class="nav-link nav-orders">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Orders</p>
          </a>
        </li>  
        <li class="nav-item">
          <a href="#" class="nav-link nav-is-tree nav-edit_product nav-view_product">
            <i class="nav-icon fa fa-gem"></i>
            <p>Products <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="./index.php?page=new_product" class="nav-link nav-new_product tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>Add New</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index.php?page=product_list" class="nav-link nav-product_list tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index.php?page=customization_req" class="nav-link nav-customization_req tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>Customization Req</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index.php?page=warranty_climb" class="nav-link nav-warranty_climb tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>Warranty climb</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index.php?page=repair_req" class="nav-link nav-repair_req tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>Repair Req</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
  <a href="#" class="nav-link nav-is-tree nav-edit_user">
    <i class="nav-icon fas fa-users"></i>
    <p>Users <i class="right fas fa-angle-left"></i></p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
        <i class="fas fa-angle-right nav-icon"></i>
        <p>Add New</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
        <i class="fas fa-angle-right nav-icon"></i>
        <p>List</p>
      </a>
    </li>
  </ul>
</li>

      </ul>
    </nav>
  </div>
</aside>

<!-- JavaScript to replace jQuery functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home'; ?>';

  // Highlight the active page
  var activeLink = document.querySelector('.nav-link.nav-' + page);
  if (activeLink) {
    activeLink.classList.add('active');

    if (activeLink.classList.contains('tree-item')) {
      var parentTreeview = activeLink.closest('.nav-treeview');
      if (parentTreeview) {
        var parentLink = parentTreeview.previousElementSibling;
        parentLink.classList.add('active');
        parentTreeview.style.display = 'block'; // Ensure treeview is visible
        parentTreeview.parentElement.classList.add('menu-open');
      }
    }

    if (activeLink.classList.contains('nav-is-tree')) {
      activeLink.parentElement.classList.add('menu-open');
    }
  }

  // Dropdown toggle for user menu
  var userDropdown = document.getElementById('userDropdown');
  var dropdownMenu = document.getElementById('dropdownMenu');

  userDropdown.addEventListener('click', function(event) {
    event.stopPropagation();
    dropdownMenu.classList.toggle('show');
    var rect = userDropdown.getBoundingClientRect();
    dropdownMenu.style.top = rect.bottom + window.scrollY + 'px'; // Position dropdown below the button
    dropdownMenu.style.left = rect.left + window.scrollX + 'px'; // Align dropdown with the button
  });

  // Close dropdown if clicked outside
  document.addEventListener('click', function(event) {
    if (!userDropdown.contains(event.target) && dropdownMenu.classList.contains('show')) {
      dropdownMenu.classList.remove('show');
    }
  });

  // Treeview toggle for sidebar
  var navTreeToggles = document.querySelectorAll('.nav-link.nav-is-tree');
  navTreeToggles.forEach(function(toggle) {
    toggle.addEventListener('click', function(e) {
      e.preventDefault();
      var treeviewMenu = toggle.nextElementSibling;
      if (treeviewMenu && treeviewMenu.classList.contains('nav-treeview')) {
        treeviewMenu.style.display = treeviewMenu.style.display === 'block' ? 'none' : 'block';
        toggle.parentElement.classList.toggle('menu-open');
      }
    });
  });

  // Manage Account modal
  var manageAccountButtons = document.querySelectorAll('.manage_account');
manageAccountButtons.forEach(function(button) {
  button.addEventListener('click', function() {
    var userId = button.getAttribute('data-id');
    // Redirect to the manage account page instead of opening a modal
    window.location.href = 'manage_user.php?id=' + userId;
  });
});
});
</script>


</script>

<!-- Basic CSS to replace Bootstrap styles -->
<style>
/* Basic Reset */
body, ul, li {
  margin: 0;
  padding: 0;
  list-style: none;
}

.main-sidebar {
  width: 250px;
  height: 100vh;
  background-color: #343a40;
  color: #ffffff;
  position: fixed;
  overflow-y: auto;
  padding-top: 10px;
  z-index: 1000; /* Ensure sidebar is above other elements */
}

.brand-link {
  display: flex;
  align-items: center;
  padding: 10px;
  cursor: pointer;
  color: #ffffff;
  text-decoration: none;
}

.brand-image {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  margin-right: 10px;
  font-weight: bold;
}

.brand-text {
  font-weight: lighter;
}

.dropdown-menu {
  display: none;
  background-color: #ffffff;
  color: #000000;
  padding: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  z-index: 2000; /* Ensure dropdown is above other elements */
  width: 200px; /* Adjust width if necessary */
}

/* Show class for visibility */
.dropdown-menu.show {
  display: block;
}

/* Improved Alignment for Dropdown Items */
.dropdown-item {
  display: block;
  padding: 8px 12px;
  color: #333;
  text-decoration: none;
}

.dropdown-item:hover {
  background-color: #f1f1f1;
}
.nav-menu {
  margin-top: 20px;
}

.nav-list {
  padding: 0;
}

.nav-item {
  position: relative;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  color: #ffffff;
  text-decoration: none;
  transition: background-color 0.3s;
}

.nav-link:hover {
  background-color: #495057;
}

.nav-link.active {
  background-color: #007bff;
}

.nav-icon {
  margin-right: 10px;
}

/* Treeview Styling */
.nav-treeview {
  display: none;
  padding-left: 20px;
}

.nav-treeview .nav-link {
  padding-left: 35px;
  background-color: #495057;
}

.nav-treeview .nav-link:hover {
  background-color: #6c757d;
}

.menu-open > .nav-treeview {
  display: block;
}

/* Utility Classes */
.d-flex {
  display: flex;
}

.bg-primary {
  background-color: #007bff;
}

.text-white {
  color: #ffffff;
}



</style>
