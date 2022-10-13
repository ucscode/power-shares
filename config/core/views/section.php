<?php 

class section {
	
	public static function Title( $title, ?bool $price_widget = true ) { 
		global $config;
		$__user = (new user())->info();
		$cPanel = defined("ADMIN_ONLY");
		
?>

	<div class='row align-items-center'>
		<div class="col-md-6 mb-2 mb-md-0">
			<h3 class="text-dark font-weight-bold mb-2 mb-md-0 text-uppercase"> <?php echo $title; ?> </h3>
		</div>
		<div class='col-md-6 mb-2'>
			<?php if( !$cPanel ): ?>
			
				<input type="text" class="form-control form-control-sm bg-white" readonly="true" value="<?php echo user::get($__user, 'reflink'); ?>" id='reflink' data-copy='#reflink'>
			
			<?php else: ?>
			
                <!-- FOR ADMIN ONLY -->
			
			<?php endif; ?>
		</div>
	</div>
	
	<?php 
		if( $price_widget ):
			events::addListener('@footer', function() use($cPanel) {
	?>
			
			<?php if( !$cPanel ): // coingecko; ?>
				<script src="//widgets.coingecko.com/coingecko-coin-price-marquee-widget.js"></script>
			<?php else: // coinmarketcap; ?>
				<script type="text/javascript" src="//files.coinmarketcap.com/static/widget/coinMarquee.js"></script>
			<?php endif; ?>
	
		<?php }); ?>
			
			<div class='my-2 overflow-auto'>
				<?php if( !$cPanel ): // coingecko; ?>
					<coingecko-coin-price-marquee-widget  coin-ids="bitcoin,ethereum,tether,ripple,cardano" currency="usd" background-color="#ffffff" locale="en"></coingecko-coin-price-marquee-widget>
				<?php else: // coinmarketcap ?>
					<div id="coinmarketcap-widget-marquee" coins="1,1027,825,5426" currency="USD" theme="dark" transparent="false" show-symbol-logo="true"></div>
				<?php endif; ?>
			</div>
			
	<?php endif; ?>
		
		<hr/>
		
		<?php 
			if( !$cPanel ): 
				$main_banner = $config->get('main_banner_code');
		?>
			<div class='mb-2 text-center'>
				<?php if( empty($main_banner) ): ?>
				<div class='fs-11 text-muted'>Main Banner</div>
				<?php else: ?>
					<div class='overflow-auto'>
						<?php echo $main_banner; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
	<?php }
	
	
	###
	
	public static function show_user_balance() { 
		$__user = (new user())->info();
	?>
		<div class='bg-light px-3 py-2 d-flex flex-wrap align-items-center justify-content-between'>
			<div class='text-muted fs-13'>
				<i class='mdi mdi-star-circle text-warning'></i> Balance
			</div>
			<h5 class='mb-0 fw-900 text-primary'>
				<i class='mdi mdi-wallet text-muted'></i> USD <?php echo number_format($__user['walletbalance'], 2); ?>
			</h5>
		</div>
		<div class='mb-3'></div>
	<?php }
	
	###
	
	public static function googleTranslator() { ?>
		
		<div id="google_translate_element"></div>
		
		<?php events::addListener('@footer', function() { ?>
			
			<script type="text/javascript">
				function googleTranslateElementInit() {
					new google.translate.TranslateElement({
						pageLanguage: 'en', 
						layout: google.translate.TranslateElement.InlineLayout.SIMPLE, 
						autoDisplay: false
					}, 'google_translate_element');
				}
			</script>
			
			<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

		<?php }); ?>
		
	<?php }
	
}