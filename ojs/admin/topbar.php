<!-- Navbar -->
<nav class="navbar">
  <!-- Left navbar links -->
  <ul class="navbar-left">
    <?php if(isset($_SESSION['login_id'])): ?>
    <li class="nav-item">
      <a class="nav-link" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <?php endif; ?>
    <li>
      <a class="nav-link" href="./" role="button">
        <span class="nav-title">Online Jewelry Shop</span>
      </a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-right">
    <li class="nav-item">
      <a class="nav-link" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>

  <!-- /.navbar -->

  <style>
    /* Reset */
body, ul, li {
  margin: 0;
  padding: 0;
  list-style: none;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #007bff;
  padding: 10px 20px;
  color: white;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.navbar-left, .navbar-right {
  display: flex;
  align-items: center;
}

.navbar-left .nav-item {
  margin-right: 15px;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-size: 18px;
  display: flex;
  align-items: center;
}



.nav-title {
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  margin-left: 300px;
}

.navbar-right .nav-item {
  margin-left: 15px;
}

.navbar-right .nav-link i {
  font-size: 20px;
}

/* Icon Styling */
.nav-link i {
  margin-right: 8px;
}

/* Fullscreen Button Style */
.navbar-right .nav-item .nav-link {
  font-size: 20px;
  cursor: pointer;
}

.nav-link[data-widget="fullscreen"] i {
  transition: transform 0.3s;
}

.nav-link[data-widget="fullscreen"]:hover i {
  transform: scale(1.1);
}

  </style>