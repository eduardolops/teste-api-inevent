<?php 

require( './AuthApi.php' );

$user = new AuthApi('recrutamento@inevent.us','recrutamento123');
$auth = $user->auth();

echo "<pre>";
print_r($auth);

