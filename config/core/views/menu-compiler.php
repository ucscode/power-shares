<?php

$menufy->enlist(null, function($data, $name, $menu) {
	$has_submenu = !empty($data['submenu']);
	if( $has_submenu ) $data['link'] = "#m-{$name}";
	if( empty($data['icon']) ) $data['icon'] = "mdi mdi-checkbox-marked-circle-outline";
	ob_start();
?>
	<li class="nav-item">
		<a class="nav-link" href="<?php echo $data['link']; ?>" <?php if( $has_submenu ): ?> data-bs-toggle="collapse" aria-expanded="false" aria-controls="<?php echo "m-{$name}"; ?>" <?php endif; ?>>
			<span class="icon-bg"><i class="<?php echo $data['icon']; ?> menu-icon"></i></span>
			<span class="menu-title"><?php echo ucwords($data['label']); ?></span>
			<?php if( $has_submenu ): ?><i class="menu-arrow"></i><?php endif; ?>
		</a>
		<?php if( $has_submenu ): ?>
			<div class="collapse" id="<?php echo "m-{$name}"; ?>">
				<ul class="nav flex-column sub-menu">
					<?php $menu->enlist($data['submenu'], function($data, $name) { ?>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $data['link']; ?>">
							<?php echo ucwords($data['label']); ?>
						</a>
					</li>
					<?php }); ?>
				</ul>
			</div>
		<?php endif; ?>	
	</li>
<?php 
	$menu_item = ob_get_clean();
	return $menu_item;
});