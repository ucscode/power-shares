<?php

require __dir__ . '/sub-config.php';

session_destroy();//destroy the session

header("location:" . sysfunc::url( __admin_dir ));

exit();

