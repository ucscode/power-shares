<ul class="navbar-nav navbar-nav-right">

    <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
                <img src="<?php echo $temp->logo; ?>" alt="image">
            </div>
            <div class="nav-profile-text">
                <p class="mb-1 text-black">Admin</p>
            </div>
        </a>
        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
            <div class="p-2">
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="ticket-view.php">
					<span>Tickets</span>
					<i class="mdi mdi-ticket ms-1"></i>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="settings.php">
					<span>Settings</span>
					<i class="mdi mdi-settings"></i>
                </a>
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="password.php">
					<span>Password</span>
					<i class="mdi mdi-lock ms-1"></i>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="log-out.php">
					<span>Log Out</span>
					<i class="mdi mdi-logout ms-1"></i>
                </a>
            </div>
        </div>
    </li>

</ul>