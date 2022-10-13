<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category no-effect">
			<i class='mdi mdi-star-circle text-warning'></i> ADMIN
		</li>
		<?php
			
			## Dashboard
			
			$menufy->add('home', [
				'label' => 'home', 
				'link' => sysfunc::url( PANEL_DIR ),
				'icon' => 'mdi mdi-xaml'
			]);
			
			
			## Security
			
			$menufy->add('security', [
				'label' => 'security',
				'icon' => 'mdi mdi-lock-open-outline'
			]);
			
				$menufy->add_submenu('security', null, [
					'label' => 'change password',
					'link' => 'password.php'
				]);
				
			
			## Settings
			
			$menufy->add('settings', [
				'label' => 'Configure',
				'icon' => 'mdi mdi-settings',
				'link' => 'settings.php'
			]);
			
				$menufy->add_submenu('settings', null, [
					'label' => 'settings',
					'icon' => 'mdi mdi-settings',
					'link' => 'settings.php'
				]);
				$menufy->add_submenu('settings', null, [
					'label' => 'Ads',
					'icon' => 'mdi mdi-settings',
					'link' => 'ads.php'
				]);
			
			
			## Payment Gateway
			
			$menufy->add('gateway', [
				'label' => 'wallets',
				'icon' => 'mdi mdi-camera-timer'
			]);
			
				$menufy->add_submenu('gateway', null, [
					'label' => 'add new',
					'link' => 'wallet-add.php'
				]);
				$menufy->add_submenu('gateway', null, [
					'label' => 'manage',
					'link' => 'wallet-manage.php'
				]);
				
				
			## Users
			
			$menufy->add('users', [
				'label' => 'users',
				'icon' => 'mdi mdi-account-edit'
			]);
			
				$menufy->add_submenu('users', null, [
					'label' => 'view all',
					'link' => 'users.php'
				]);
				$menufy->add_submenu('users', null, [
					'label' => 'manage',
					'link' => 'users-manager.php'
				]);
				$menufy->add_submenu('users', null, [
					'label' => 'add new',
					'link' => 'user-add.php'
				]);
				
				
			## Transactions
			
			$menufy->add('transaction', [
				'label' => 'transaction',
				'icon' => 'mdi mdi-chart-line-variant'
			]);
			
				$menufy->add_submenu('transaction', null, [
					'label' => 'withdrawals',
					'link' => 'withdraw.php'
				]);
				$menufy->add_submenu('transaction', null, [
					'label' => 'deposits',
					'link' => 'deposit.php'
				]);
				
				
			## Shares
			
			$menufy->add('shares', [
				'label' => 'shares',
				'icon' => 'mdi mdi-chart-bubble'
			]);
			
				$menufy->add_submenu('shares', null, [
					'label' => 'add new',
					'link' => 'shares-new.php'
				]);
				$menufy->add_submenu('shares', null, [
					'label' => 'view all',
					'link' => 'shares.php'
				]);
				$menufy->add_submenu('shares', null, [
					'label' => 'Investments',
					'link' => 'shares-inv.php'
				]);
				
				
			## Messages
			
			$menufy->add('messages', [
				'label' => 'Messages',
				'icon' => 'mdi mdi-message-text-outline'
			]);
			
				$menufy->add_submenu('messages', null, [
					'label' => 'tickets',
					'link' => 'ticket-view.php'
				]);
				$menufy->add_submenu('messages', null, [
					'label' => 'testimonials',
					'link' => 'testimonials.php'
				]);
				$menufy->add_submenu('messages', null, [
					'label' => 'send email',
					'link' => 'sendmail.php'
				]);
				$menufy->add_submenu('messages', null, [
					'label' => 'announcement',
					'link' => 'announcement.php'
				]);
				
			require __core_views . '/menu-compiler.php';
			
		?>
		
       
		<li class="nav-item documentation-link no-effect">
            <a class="nav-link" href="<?php echo sysfunc::url( PANEL_DIR . '/log-out.php' ); ?>">
				<span class="icon-bg">
					<i class="mdi mdi-file-document-box menu-icon"></i>
				</span>
				<span class="menu-title">Logout</span>
            </a>
        </li>

	</ul>
</nav>
<!-- partial -->