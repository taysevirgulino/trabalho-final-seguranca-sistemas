<?php 
    $data = $_POST['data'];
	$private = $_POST['private_key'];
	$binary_signature = '';
	$private_key = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
$private
-----END RSA PRIVATE KEY-----
EOD;
	openssl_sign($data, $binary_signature, $private_key, OPENSSL_ALGO_MD5);
    echo base64_encode($binary_signature);
?>