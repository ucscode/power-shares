<ul class="navbar-nav navbar-nav-right user-select-none">

	<!--------- //profile --------->
	
    <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
                <img src="<?php echo user::get($__user, 'avatar'); ?>" alt="image">
            </div>
            <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo $__user['username']; ?></p>
            </div>
        </a>
        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
            <div class="p-3 text-center bg-primary">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="<?php echo user::get($__user, 'avatar'); ?>" alt="">
            </div>
            <div class="p-2">
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="profile.php">
					<span>Profile</span>
					<span class="p-0">
						<i class="mdi mdi-account-outline ms-1"></i>
					</span>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="deposit.php">
					<span>Deposit</span>
					<i class="mdi mdi-arrow-down-bold-hexagon-outline ms-1"></i>
                </a>
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="shares-buy.php">
					<span>Buy Shares</span>
					<i class="mdi mdi-star-half ms-1"></i>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="log-out.php">
					<span>Log Out</span>
					<i class="mdi mdi-logout ms-1"></i>
                </a>
            </div>
        </div>
    </li>
	
	<!-------- //profile ---------->
	
</ul>