<?php 

require( './AuthApi.php' );

switch ($_GET['action']) {
  case 'create':
    $create = new AuthApi();

    $data = $_POST;
    $response = $create->createUser( $data );
    break;
  default:
    $user = new AuthApi('recrutamento@inevent.us','recrutamento123');
    $response = $user->auth();
    break;
}

echo '<pre>';
print_r($response);
