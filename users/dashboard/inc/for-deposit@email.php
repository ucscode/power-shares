<?php

### EMAIL TO CLIENT;

$mail = sysfunc::initMail();
$mail->addAddress($__user['email'], $__user['username']);

$eh = new email_handler();

$emailTable = $eh->table_context(array(
	"Username" => $__user['username'],
	"Reference ID" => $data['reference_id'],
	"TX Amount" => (float)$data['usd'] . " USD",
	"TX Rate" => "{$data['coin_rate']} {$data['network']}",
	"TXID" => $data['txid'],
	"Status" => $data['status']
),[0]);

$mail->Subject = "Deposit Alert!";
$mail->Body = $eh->message("
	<p>Your deposit request has been sent. <br> Your balance will be updated after confirmation.</p>
	<h3>Deposit Details</h3>
	{$emailTable}
");

($mail->send());


### NOTIFY ADMIN

$admin_mail = sysfunc::initMail();
$admin_mail->addAddress($config->get('email'));
$admin_mail->Subject = "New Deposit!";
$admin_mail->Body = $eh->message("
	<p>Hi admin,</p>
	<p>A new deposit request was sent for confirmation. <br> Please check the details for approval.</p>
	<h3>Deposit Details</h3>
	{$emailTable}
");

($admin_mail->send());


