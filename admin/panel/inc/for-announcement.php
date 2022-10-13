<?php

events::addListener('@header', function() { ?>
	<link rel='stylesheet' href='<?php echo sysfunc::url( __core_vendors . '/quill/quill.snow.css' ); ?>'>
<?php });

events::addListener('@footer', function() use($config) { ?>
	
	<script type='text/javascript' src='<?php echo sysfunc::url( __core_vendors . '/quill/quill.js' ); ?>'></script>
	
	<script>
		
		let quill = new Quill('#quill', {
			theme: 'snow',
			placeholder: 'Write here...'
		});
		
		quill.root.innerHTML = <?php 
			$record = addslashes($config->get('announcement'));
			echo "'{$record}';\n";
		?>
		
		$("#announcement").on('submit', function(e) {
			e.preventDefault();
			let form = this;
			swal({
				text: 'Save announcement?',
				icon: 'info',
				buttons: true
			}).then(function(yes) {
				if( !yes ) return;
				$(form).find("[name='announcement']").val( quill.root.innerHTML );
				form.submit();
			});
		});
	
	</script>
	
<?php });


if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$temp->status = $config->set( 'announcement', $_POST['announcement'] );
	$temp->msg = ($temp->status) ? "Announcement successfully saved" : "Announcement not saved";
};