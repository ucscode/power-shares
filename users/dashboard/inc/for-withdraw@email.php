<?php

### MAIL TO CLIENT;

$mail = sysfunc::initMail();
$mail->addAddress($__user['email'], $__user['username']);

$eh = new email_handler();

$table = $eh->table_context(array(
	"Username" => $__user['username'],
	"Withdrawal Amount" => $data['usd'] . ' USD',
	"Withdrawal Network" => $data['network'],
	"Payment Address" => $data['wallet_addr'],
	"Reference ID" => $data['reference_id'],
	"Status" => $data['status']
), [0]);

$mail->Subject = "Withdrawal Request";
$mail->Body = $eh->message(" 
	<p>Your withdrawal request has been sent. <br> You will receive payment once the withdrawal is approved.</p>
	<h3>Withdrawal Details</h3>
	{$table} 
");

($mail->send());


### NOTIFY ADMIN

$admin_mail = sysfunc::initMail();
$admin_mail->addAddress($config->get('email'));
$admin_mail->Subject = "New Withdrawal!";
$admin_mail->Body = $eh->message("
	<p>Hi admin,</p>
	<p>A new withdrawal request was sent for confirmation. <br> Please check the details for approval.</p>
	<h3>Withdrawal Details</h3>
	{$table}
");

($admin_mail->send());
