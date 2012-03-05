<?php
$to      = 'mikedfunk@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: admin@bookymark.com';

if (mail($to, $subject, $message, $headers))
{
	echo "mail test 2 successful \n\n";
}
else
{
	echo "ERROR sending mail 2 \n\n";
}