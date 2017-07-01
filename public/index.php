<?php


$client_id = "1519057505";
$client_secret = "5997cf65a3c3789378fa99526d0f1b8c";
$redirect_uri = "https%3A%2F%2Frelayline.herokuapp.com";


function getToken($code){
    global $client_id, $client_secret,$redirect_uri;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.line.me/v2/oauth/accessToken",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "grant_type=authorization_code&code=".$code."&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirect_uri,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function getProfile($token){

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.line.me/v2/profile",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ".$token,
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

global $line_profile;
    $obj = json_decode(getToken($_GET['code']),true);


$ozone = $obj['access_token'];

$line_profile = getProfile($ozone);
$obj_profile = json_decode($line_profile,true);
$displayName = $obj_profile['displayName'];
$userId = $obj_profile['userId'];
$pictureUrl = $obj_profile['pictureUrl'];
$statusMessage = $obj_profile['statusMessage'];
?>
<script language="JavaScript">
    window.opener.postMessage(<?php echo $line_profile ?>, 'https://puzzlethai.github.io');
    window.close();
</script>


