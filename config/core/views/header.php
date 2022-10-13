<!DOCTYPE html>
<html lang="en">
<head>
	<?php require __core_views . '/head-tags.php'; ?>
</head>
<body>
	<div class="container-scroller">
	
		<!-- partial:../../partials/_navbar.html -->
		<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
		
			<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
			
				<a class="navbar-brand brand-logo" href="<?php echo sysfunc::url( PANEL_DIR ); ?>">
					<img src="<?php echo $temp->logo; ?>" alt="logo" />
				</a>
				
				<a class="navbar-brand brand-logo-mini" href="<?php echo sysfunc::url( PANEL_DIR ); ?>">
					<img src="<?php echo $temp->logo; ?>" alt="logo" />
				</a>
				
			</div>
			
			<div class="navbar-menu-wrapper d-flex align-items-stretch">
			
				<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
					<span class="mdi mdi-menu"></span>
				</button>
				
				<div class="search-field d-none d-xl-block--">
					<form class="d-flex align-items-center h-100" action="#">
						<div class="input-group">
							<div class="input-group-prepend bg-transparent">
								<i class="input-group-text border-0 mdi mdi-magnify"></i>
							</div>
							<input type="text" class="form-control bg-transparent border-0" placeholder="Search products">
						</div>
					</form>
				</div>
				
				<?php require_once PANEL_DIR . '/__navbar-top.php'; ?>
				
				<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
					<span class="mdi mdi-menu"></span>
				</button>
				
			</div>
			
		</nav>
		
		<!-- partial -->
		<div class="container-fluid page-body-wrapper">
		
			<!-- partial:../../partials/_sidebar.html -->
			<?php require PANEL_DIR . '/__navbar-aside.php'; ?>
			
			<div class="main-panel">
				<div class="content-wrapper">
