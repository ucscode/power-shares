<?php require __dir__ . '/config/config.php'; ?>
<!doctype html>
<html>
<head>
	<?php include_once __core_views . '/head-tags.php'; ?>
</head>
<body>
	<div class="cover-container d-flex w-100 vh-100 p-4 py-5 mx-auto flex-column text-center bg-light">
		<main role="main" class="inner cover my-5 py-5">
			<p class='fs-48'>
				<i class='fa fa-star-o text-muted'></i>
			</p>
			<h5 class="cover-heading">POWERED BY</h5>
			<img src='<?php echo sysfunc::url( __core_views . '/origin.png' ); ?>' width='80px' class='img-fluid mb-2'>
			<h1 class="cover-heading font-weight-bold text-primary">UCSCODE</h1>
			<p class="lead">
				Nothing is here! <br>
				Delete this page and add yours!
			</p>
			<p class="lead">
				<a href="<?php echo sysfunc::url( __users_login_page ); ?>" class="btn btn-lg btn-secondary">
					Login Now
				</a>
			</p>
		</main>
	</div>
</body>
</html>
