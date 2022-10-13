<?php 

// delete investor
if(isset($_POST['delete'])){
	
	$id = $_POST['id'];
	
$sql = "DELETE FROM shared WHERE id='$id'";

if (mysqli_query($link, $sql)) {
    $msg = " deleted successfully!";
} else {
    $msg = "not deleted! ";
}
}
// verify investor

if(isset($_POST['act'])){
	
		$id = $_POST['id'];
		$pname = $_POST['pname'];
		$increase = $_POST['increase'];
		$sharescat = $_POST['sharescat'];
		$sharesubcat = $_POST['sharesubcat'];
		$bonus = $_POST['bonus'];
	
$sql = "UPDATE shared SET pname = '$pname',increase = '$increase', sharescat = '$sharescat',sharesubcat = '$sharesubcat',bonus = '$bonus'  WHERE id='$id'";

if (mysqli_query($link, $sql)) {
    $msg = "shares updated successfully!";
} else {
    $msg = "shares not updated! ";
}
}


if(isset($_POST['dact'])){
	
		$id = $_POST['id'];
	
$sql = "UPDATE shared SET status = '0'  WHERE id='$id'";

if (mysqli_query($link, $sql)) {
    $msg = "shares deactivated successfully!";
} else {
    $msg = "shares not deactivated! ";
}
}



if(isset($_POST['vemail'])){
	
	$email = $_POST['email'];
	
$sql = "UPDATE users SET confirm = '1'  WHERE email='$email'";

if (mysqli_query($link, $sql)) {
    $msg = "Investor verified successfully!";
} else {
    $msg = "Investor not was not verified! ";
}
}



// unverify investors

if(isset($_POST['unverify'])){
	
	$email = $_POST['email'];
	
$sql = "UPDATE users SET verify = '0'  WHERE email='$email'";

if (mysqli_query($link, $sql)) {
    $msg = "Investor Un-verified successfully!";
} else {
    $msg = "Investor not was not Un-verified! ";
}
}
