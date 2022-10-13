<?php

require __dir__ . '/sub-config.php';
require __dir__ . '/control/for-admin-signin.php';

events::addListener('@header', function() { ?>
	<style>
		body {
			align-items: center;
			padding-bottom: 40px;
			background-color: #f5f5f5;
		}
		.gradient-custom-2 {
			/* fallback for old browsers */
			background: #fccb90;

			/* Chrome 10-25, Safari 5.1-6 */
			background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

			/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
			background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
		}

		@media (min-width: 768px) {
			.gradient-form {
				height: 100vh !important;
			}
		}
		@media (min-width: 769px) {
			.gradient-custom-2 {
				border-top-right-radius: .3rem;
				border-bottom-right-radius: .3rem;
			}
		}
	</style>
<?php });

### start HTML
require __auth_dir . '/form-header.php';

?>

<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <img src="<?php echo $temp->logo; ?>" style="width: 75px;" alt="logo" class='mb-3'>
                                    <h4 class="mt-1 mb-4 pb-1">Welcome Admin</h4>
                                </div>
                                <?php echo sysfunc::html_notice( $msg ?? null, false ); ?>
                                <form method='POST'>
                                    <div class="form-outline mb-2">
                                        <input type="email" class="form-control" placeholder="Email address" name="email" required value='<?php echo $_POST['email'] ?? null; ?>' />
                                        <span class="help-block text-danger small"><?php echo $email_err; ?></span>
                                    </div>
                                    <div class="form-outline mb-2">
                                        <input type="password" class="form-control" placeholder='Password' name='password' required />
                                        <span class="help-block text-danger small"><?php echo $password_err; ?></span>
                                    </div>
                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block btn-lg w-100 mb-3" type="submit">Log in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-4 py-4 p-md-5 mx-4">
                                <h4 class="mb-3"><?php echo $config->get('site_name'); ?></h4>
                                <p class="small mb-4"><?php echo $config->get('site_headline'); ?></p>
                                <p class='small mb-0'>
                                    <em><q><?php
									
										require __dir__ . '/quotes.php';
										
										shuffle($Quotes);
										echo $Quotes[0];
										
									?></q></em>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __auth_dir . '/form-footer.php'; ?>