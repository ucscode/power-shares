<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category no-effect">
			<i class='mdi mdi-star text-warning'></i> MAIN
		</li>
		<?php
			
			## Dashboard
			
			$menufy->add('dashboard', [
				'label' => 'dashboard', 
				'link' => sysfunc::url( PANEL_DIR ),
				'icon' => 'mdi mdi-cube'
			]);
			
			
			## Wallet
			
			$menufy->add('wallet', [
				'label' => 'Transactions',
				'icon' => 'mdi mdi-wallet'
			]);
			
				$menufy->add_submenu('wallet', null, [
					'label' => 'deposit fund',
					'link' => 'deposit.php'
				]);
				$menufy->add_submenu('wallet', null, [
					'label' => 'withdraw fund',
					'link' => 'withdraw.php'
				]);
				$menufy->add_submenu('wallet', null, [
					'label' => 'Transaction Log',
					'link' => 'transaction-log.php'
				]);
				
			
			## Profile
			
			$menufy->add('profile', [
				'label' => 'account',
				'icon' => 'mdi mdi-account'
			]);
			
				$menufy->add_submenu('profile', null, [
					'label' => 'my profile',
					'link' => 'profile.php'
				]);
				$menufy->add_submenu('profile', null, [
					'label' => 'wallet details',
					'link' => 'wallets.php'
				]);
				$menufy->add_submenu('profile', null, [
					'label' => 'verify account',
					'link' => 'verify.php'
				]);
				$menufy->add_submenu('profile', null, [
					'label' => 'my downlines',
					'link' => 'downlines.php'
				]);
				
				
			## Shares
			
			$menufy->add('shares', [
				'label' => 'shares',
				'icon' => 'mdi mdi-chart-areaspline'
			]);
			
				$menufy->add_submenu('shares', null, [
					'label' => 'buy shares',
					'link' => 'shares-buy.php'
				]);
				$menufy->add_submenu('shares', null, [
					'label' => 'my shares',
					'link' => 'shares.php'
				]);
				
				
			## Ticket
			
			$menufy->add('ticket', [
				'label' => 'ticket',
				'icon' => 'mdi mdi-message-alert'
			]);
			
				$menufy->add_submenu('ticket', null, [
					'label' => 'create new',
					'link' => 'ticket-new.php'
				]);
				$menufy->add_submenu('ticket', null, [
					'label' => 'view all',
					'link' => 'ticket-list.php'
				]);
				
			
			## Logout
			
			$menufy->add('logout', [
				'label' => 'logout',
				'icon' => 'mdi mdi-logout',
				'link' => 'log-out.php'
			]);
			
			require __core_views . '/menu-compiler.php';
			
		?>

	</ul>
</nav>
<!-- partial -->