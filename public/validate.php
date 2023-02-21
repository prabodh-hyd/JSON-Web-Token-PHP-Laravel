<?php

declare(strict_types=1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once('../vendor/autoload.php');

if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
    header('HTTP/1.0 400 Bad Request');
    echo 'Token not found in request';
    exit;
}

$jwt = $matches[1];
if (! $jwt) {
    // No token was able to be extracted from the authorization header
    header('HTTP/1.0 400 Bad Request');
    exit;
}

$secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
//$token = JWT::decode($jwt, $secretKey, ['HS512']);
$token = JWT::decode((string)$jwt, new Key($secretKey, 'HS512'));echo "<br>";
$now = new DateTimeImmutable();
$serverName = "your.domain.name";

if ($token->iss !== $serverName ||
    $token->nbf > $now->getTimestamp() ||
    $token->exp < $now->getTimestamp())
{
    header('HTTP/1.1 401 Unauthorized');
    exit;
    
}

/*if($token !== 'undefined')
{
    try{
        $diff = $now - $expire_at;
        echo "all good.  $diff remaining";
    }
    catch(err){
        echo "invalid token or expired token";
    }
}
else{
    echo "invalid token";
}*/
/*if($request_data !== 'undefined')
    {
        $res = ($expire_at - time()) < 0;
        if($res == true){
            echo "toekn is valid";
        }
        else{
            echo "token is expired";
        }

    }
    else{
        echo "invalid token";  
}*/
// Show the page