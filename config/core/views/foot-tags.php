<!-- plugins:js -->
<script src="<?php echo sysfunc::url( __core_views . '/assets/vendors/js/vendor.bundle.base.js' ); ?>"></script>

<script src="<?php echo sysfunc::url( __core_vendors . '/select2/js/select2.min.js' ); ?>"></script>
<script src="<?php echo sysfunc::url( __core_vendors . '/sweetalert/sweetalert.min.js' ); ?>"></script>
<script src="<?php echo sysfunc::url( __core_vendors . '/toastr/toastr.min.js' ); ?>"></script>
<script src="<?php echo sysfunc::url( __core_vendors . '/magnific-popup/jquery.magnific-popup.min.js' ); ?>"></script>
<script src="<?php //echo sysfunc::url( __core_vendors . '/dataTables/datatables.min.js' ); ?>"></script>

<script src="<?php echo sysfunc::url( __core_views . '/assets/js/off-canvas.js' ); ?>"></script>
<script src="<?php echo sysfunc::url( __core_views . '/assets/js/hoverable-collapse.js' ); ?>"></script>
<script src="<?php echo sysfunc::url( __core_views . '/assets/js/misc.js' ); ?>"></script>

<script src="<?php echo sysfunc::url( __dir__ . '/script.js' ); ?>"></script>

<?php events::exec("@footer"); ?>