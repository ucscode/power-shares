				</div> <!-- content-wrapper ends -->
				
				<!-- partial:../../partials/_footer.html -->
				<footer class="footer">
					<div class="footer-inner-wraper">
						<div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
							<span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
								Copyright © <?php echo $config->get('site_name'); ?> <?php echo date('Y'); ?>
							</span>
							<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
								<?php echo $config->get('footer_remark'); ?>
							</span>
						</div>
					</div>
				</footer>
				<!-- partial -->
				
			</div> <!-- main-panel ends -->

		</div> <!-- page-body-wrapper ends -->

	</div> <!-- container-scroller -->
	
	<?php require_once __core_views . '/foot-tags.php'; ?>

</body>
</html>
