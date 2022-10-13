<?php

$msg = '';
$sid = sysfunc::sanitize_input( $_GET['id'] ?? '' );

if(isset($_POST['switch'])){
    
    $profit = $_POST['profit'];
     $email = $_POST['email'];
    
       $pp =   $percentage;     
    
	
	 $sql = "UPDATE users SET activate = '0',pdate = '0',walletbalance= walletbalance + $profit  WHERE email='$email'";
	 
	 
  if(mysqli_query($link, $sql)){
	
$msg = "Package Ended with profit of $profit you can now switch or enjoy a new package !";

  }else{
      
      $msg = "Package cannot be ended.switched!";
  }
}



if(isset($_POST['activate'])) {
	
	$data = array(
		"email" => $__user['email'],
		"increase" => $_POST['increase'],
		"amount" => $_POST['amount'],
		"pname" => $_POST['pname'],
		"sharescat" => $_POST['sharescat'],
		"sharesubcat" => $_POST['sharesubcat'],
		"bonus" => '',
		"status" => 1,
		"date" => $cdate = date('Y-m-d H:i:s'),
		"sid" => $_POST['sid'],
		"shid" => '',
		'dc' => '',
		'ac' => $cdate
	);
	
	$sql2= "SELECT * FROM users WHERE email= '{$__user['email']}'";
	
	$result2 = mysqli_query($link,$sql2);
	
	if(mysqli_num_rows($result2)) {
		
		$row = mysqli_fetch_assoc($result2);
		
		$sql1 = sysfunc::mysql_insert_str( 'ashares', $data );

		if(!empty($data['amount']) && (float)$row['walletbalance'] >= (float)$data['amount']){

			$sql2 = "UPDATE users SET walletbalance = walletbalance - ({$data['amount']}) WHERE email='{$__user['email']}'";

			$status = mysqli_query($link, $sql1) && mysqli_query($link, $sql2);

			$msg =  $status ? "Your Shares is successfully activated!" : "Your shares could not be activated";
			
		}else{
			$msg = "Package cannot be activated, insufficient balance or amount less than package minimum value !";
		}
		
	}
	
}


	
   
 
