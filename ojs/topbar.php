<!-- Navbar -->
<nav class="main-header">
  <div class="container">
    <ul class="navbar-nav">
      <li>
        <a class="nav-link brand-title" href="./" role="button">Online Jewelry Shop</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link nav-home" href="./"><b>Home</b></a>
      </li>


  
      <li class="nav-item">
        <a class="nav-link nav-home" href="./admin">
          <b>Admin</b>
        </a>
      </li>



      <!-- Links for logged-out users -->
      <?php if (!isset($_SESSION['login_id'])): ?>
        <li class="nav-item">
          <a class="nav-link nav-login" href="login.php"><b>Signin</b></a>
        </li>
      <?php else: ?>
        <!-- Links for logged-in users -->
        <li class="nav-item">
          <a class="nav-link nav-my-orders" href="index.php?page=my_order"><b>My Orders</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-my-requests" href="index.php?page=my_req"><b>My Requests</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-my-collections" href="index.php?page=my_collection"><b>My Collections</b></a>
        </li>

        <!-- Cart Link -->
        <li class="nav-item">
          <div class="cart-container">
              <div class="badge badge-danger cart-count">0</div>
              <a href="index.php?page=cart" class="view-cart-btn">View Cart</a>
          </div>
      </li>


        <!-- User Dropdown -->
        <li class="nav-item dropdown user-menu">
          <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="userDropdown">
            <span class="user-info">
              <b><?php echo ucwords($_SESSION['login_firstname']) ?></b>
            </span>
          </a>
          <div class="dropdown-menu user-dropdown" id="dropdownMenu" style="display: none;">
            <a class="dropdown-item" href="signup.php">Manage Account</a><br><br>
            <a class="dropdown-item" href="admin/ajax.php?action=logout2">Logout</a>
          </div>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>




<!-- Styles -->
<style>
 /* General Navbar Styles */
.main-header {
  background-color: #007bff;
  padding: 10px 0;
  font-family: Arial, sans-serif;
}

.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar-nav {
  display: flex;
  align-items: center;
  list-style: none;
  padding-left: 0;
}



.nav-item {
  margin-right: 15px;
}

.nav-link {
  text-decoration: none;
  color: white;
  padding: 10px 15px;
  font-size: 16px;
  transition: background-color 0.3s;
}

.nav-link:hover,
.nav-link.active {
  background-color: #0056b3;
  border-radius: 5px;
}

/* Brand Title */
.brand-title {
  font-size: 24px;
  font-weight: bold;
}


/* Container for Cart Badge and Button */
.cart-container {
  position: relative; /* Create a positioning context */
  display: flex;
  flex-direction: column; /* Stack items vertically */
  align-items: center; /* Center items horizontally */
}

/* Cart Count Badge Styles */
.cart-count {
  background-color: red; /* Red background */
  color: white; /* White text color */
  padding: 5px 10px; /* Padding for spacing */
  border-radius: 12px; /* Rounded corners */
  font-size: 14px; /* Font size */
  font-weight: bold; /* Bold text */
  position: absolute; /* Position relative to container */
  top: -5px; /* Adjust this value as needed */
  right: -5px; /* Adjust this value as needed */
  transform: translate(50%, -50%); /* Center the badge on the corner */
}


.cart-dropdown {
  width: 250px;
  padding: 10px;
  background-color: white;
  border: 1px solid #ccc;
  position: absolute;
  right: 0;
  top: 40px;
  z-index: 1000;
}

.cart-footer {
  text-align: center;
  padding: 10px 0;
}

.view-cart-btn {
  background-color: blue;
  color: white;
  padding: 5px 15px;
  border-radius: 3px;
  text-decoration: none;
}

.view-cart-btn:hover {
  background-color: darkblue;
}

/* User Dropdown Styles */
.user-info {
  display: inline-flex;
  align-items: center;
  background-color: blue;
  padding: 5px 10px;
  border-radius: 25px;
}

.user-dropdown {
  position: absolute;
  right: 0;
  top: 60px;
  background-color: white;
  border: 1px solid #ccc;
  padding: 10px;
}

.user-menu .dropdown-toggle::after {
  display: none;
}

/* User Dropdown Item Styles */
.user-dropdown .dropdown-item {
  padding: 5px 10px; /* Add padding for better spacing */
  color: black; /* Default text color */
  text-decoration: none; /* Remove underline */
  transition: background-color 0.3s; /* Smooth transition for hover effect */
}

/* Change styles on hover for dropdown items */
.user-dropdown .dropdown-item:hover {
  background-color: #f0f0f0; /* Light grey background on hover */
  color: #007bff; /* Change text color to blue */
}



a{
  text-decoration: none;
}

</style>

<!-- Navbar Script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Toggle user dropdown on click
    const userDropdown = document.getElementById('userDropdown');
    const dropdownMenu = document.getElementById('dropdownMenu');

    userDropdown.addEventListener('click', function () {
      dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function (event) {
      if (!userDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.style.display = 'none';
      }
    });
  });
</script>
