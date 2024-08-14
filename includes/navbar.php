<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow-sm p-3 mb-5">

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            <!-- Dropdown for Categories -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
                    <a class="dropdown-item" href="wall.php?name=wall">Wall</a>
                    <a class="dropdown-item" href="floor.php?name=floor">Floor</a>
                    <a class="dropdown-item" href="bathroom.php?name=bathroom">Bathroom</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="users/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users/cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
        </ul>
    </div>
</nav>
