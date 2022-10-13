<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">

<link rel="icon" href="<?php echo $temp->logo; ?>">
<title><?php echo $temp->title; ?></title>

<link rel="stylesheet" href="<?php echo sysfunc::url( __core_views . '/assets/vendors/mdi/css/materialdesignicons.min.css' ); ?>">
<link rel="stylesheet" href="<?php echo sysfunc::url( __core_views . '/assets/vendors/flag-icon-css/css/flag-icon.min.css' ); ?>">
<link rel="stylesheet" href="<?php echo sysfunc::url( __core_views . '/assets/vendors/css/vendor.bundle.base.css' ); ?>">

<link rel="stylesheet" href="<?php echo sysfunc::url( __core_vendors . '/font-awesome-5.8.2/css/all.css' ); ?>">
<link rel="stylesheet" href="<?php echo sysfunc::url( __core_vendors . '/select2/css/select2.min.css' ); ?>">
<link rel="stylesheet" href="<?php echo sysfunc::url( __core_vendors . '/toastr/toastr.min.css' ); ?>">
<link rel="stylesheet" href="<?php echo sysfunc::url( __core_vendors . '/magnific-popup/magnific-popup.css' ); ?>">
<link rel="stylesheet" href="<?php //echo sysfunc::url( __core_vendors . '/dataTables/datatables.min.css' ); ?>">

<link rel="stylesheet" href="<?php echo sysfunc::url( __core_views . '/assets/css/style.css' ); ?>">
<link rel="stylesheet" href="<?php echo sysfunc::url( __dir__ . '/style.css' ); ?>">

<?php events::exec("@header"); ?>

