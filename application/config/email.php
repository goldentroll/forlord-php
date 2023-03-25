
<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'email-smtp.us-west-2.amazonaws.com', 
    'smtp_port' => 587,
    'smtp_user' => 'info@forlord.com',
    'smtp_pass' => '@ccA2810696!',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);


// $host = 'email-smtp.us-west-2.amazonaws.com';
// $port = 587;
// email: info@forlord.com
// Smtp Username
// AKIAQPHJV44NAMSBS57J
// Smtp Password
// BNZkZjMKh+DkHH31eZCwkCgRHEkU5VnAGfPXbkF1Ky12
//     $mail->Username   = 'Forlord';
//     $mail->Password   = '';   