 <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center fw-bold fs-4" href="#">
        <img src="../assets/images/logo-w.png" alt="Logo" width="40" height="40" class="me-2">
        ManualLK
      </a>
      
      <!-- Mobile Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Navigation Links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="../index.php">
              <i class="fas fa-home me-1"></i>Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./find.php">
              <i class="fas fa-search me-1"></i>Find
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./aboutus.php">
              <i class="fas fa-info-circle me-1"></i>About
            </a>
          </li>
          <?php if (!isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="./signin.php">
                <i class="fas fa-envelope me-1"></i>Contact
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-light ms-2 px-3" href="./signin.php">
                <i class="fas fa-sign-in-alt me-1"></i>SignIn
              </a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="./contactus.php">
                <i class="fas fa-envelope me-1"></i>Contact
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-light ms-2 px-3" href="./logout.php">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
              </a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link btn btn-warning ms-2 px-3 text-dark" href="./admin/index.php">
                <i class="fas fa-cog me-1"></i>Admin
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>