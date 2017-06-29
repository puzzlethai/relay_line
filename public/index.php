<?php
//echo 'test echo';
/**
 * Created by IntelliJ IDEA.
 * User: OZONE
 * Date: 19/6/2560
 * Time: 10:32
 *     <!--const channel_ID = '1519057505';-->
 *   <!--const channel_Secret =   '5997cf65a3c3789378fa99526d0f1b8c';-->
 *    <!--const callback_url = 'https://puzzlethai.github.io/testLineLogin/';-->
 *
 *
 *
 *
 *
 *
 */

$client_id = "1519057505";
$client_secret = "5997cf65a3c3789378fa99526d0f1b8c";
$redirect_uri = "https%3A%2F%2Frelayline.herokuapp.com";
//global $ozone;
//$ozone="first";
//echo $ozone."<br>";


// $token = "";

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
   // global ;
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


    $obj = json_decode(getToken($_GET['code']),true);


$ozone = $obj['access_token'];
echo 'token : '.$ozone."<br>";

$obj_profile = json_decode(getProfile($obj['access_token']),true);
echo "obj_profile --> $obj_profile";
$displayName = $obj_profile['displayName'];
echo "displayName --> $displayName";
$userId = $obj_profile['userId'];
echo "userId --> $userId";
$pictureUrl = $obj_profile['pictureUrl'];
echo "pictureUrl --> $pictureUrl";
$statusMessage = $obj_profile['statusMessage'];
echo "statusMessage --> $statusMessage";

//echo 'userId'.$userId."<br>";
?>
<script language="JavaScript">
window.opener.loginCallback("<?php echo $token ?>","<?php echo $displayName ?>","<?php echo $userId ?>","<?php echo $pictureUrl ?>","<?php echo $statusMessage ?>");
window.close();

</script>

//    "userId":"Ufr47556f2e40dba2456887320ba7c76d",
//  "displayName":"Brown",
//  "pictureUrl":"https://example.com/abcdefghijklmn",
//  "statusMessage":"Hello, LINE!"
