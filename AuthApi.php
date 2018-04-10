<?php

class AuthApi
{

  protected $user, $pass;

  function __construct($user = '', $pass = '')
  {
    $this->setUser($user);
    $this->setPass($pass);
  }

  private function setUser( $user )
  {
    $this->user = $user;
  }

  private function setPass( $pass )
  {
    $this->pass = $pass;
  }

  private function getUser()
  {
    return $this->user;
  }

  private function getPass()
  {
    return $this->pass;
  }
   
  public function auth()
  {
 	  $data = [ 'username' => $this->getUser(), 'password' => $this->getPass() ];
 		$user = $this->send( 'person.signIn', 'POST', $data );

    if( !$user )
      return false;

    return $user;
  }

  public function createUser( $data )
  {
    if( !is_array($data) )
      return false;

    $create = $this->send( 'person.create', 'POST', $data );

    if( !$create )
      return false;

    return $create;

  }


  private function send( $router,  $method = 'POST', $data = [], $timeOut = false ) 
  {
  	$postData = $this->setParams($data);

    $url = 'https://inevent.us/api/?action='.$router.'&'.$postData;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HEADER, false); 

    if ( $method == 'POST' ) {
  	  curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    if( $timeOut ) {
    	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    }

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);       
    curl_close($ch);

    return json_decode($response);
  }

  private function setParams($params)
  {
    $postData = '';
    //create name value pairs seperated by &
    foreach($params as $k => $v) 
    { 
      $postData .= $k . '='.$v.'&'; 
    }

    $postData = rtrim($postData, '&');
    return $postData;
  }
}
