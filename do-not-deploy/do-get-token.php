<?php
require_once '../init.php';

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  header("Location: error.php");
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  header("Location: error.php");
  exit;
}

if (! isset($accessToken)) {
  header("Location: error.php");
  exit;
}

$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId($APP_ID);
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    header("Location: error.php");
    exit;
  }
}

$accessToken = (string) $accessToken;

$response = $fb->get("/$BOT_PAGEID?fields=access_token", $accessToken);
echo $response->getDecodedBody()["access_token"];
