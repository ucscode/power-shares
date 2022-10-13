<?php

// rename pmethod to wallets

events::addListener("@header", function() {

?>
	<link rel="stylesheet" href="<?php echo sysfunc::url( __core_vendors . '/jssocials/jssocials.css' ); ?>">
	<link rel="stylesheet" href="<?php echo sysfunc::url( __core_vendors . '/jssocials/jssocials-theme-flat.css' ); ?>">
<?php 
});

events::addListener("@footer", function() {
	global $__user;
?>
	<script src='<?php echo sysfunc::url( __core_vendors . '/jssocials/jssocials.min.js' ); ?>'></script>
	<script>
		$("#jssocials").jsSocials({
			url: <?php echo "'" . user::get($__user, 'reflink') . "'"; ?>,
			//text: 'Invest in your future now',
			showLabel: false,
			shares: [
				{
					share: "facebook",
					logo: "mdi mdi-facebook"
				}, 
				{
					share: "twitter",
					logo: "mdi mdi-twitter"
				},
				{
					share: "whatsapp",
					logo: "mdi mdi-whatsapp"
				}
			]
		});
	</script>
	<!--- For 'nomics-ticker-widget' --->
	<script src="https://widget.nomics.com/embed.js"></script>
<?php
});
