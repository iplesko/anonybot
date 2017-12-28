<?php

class FacebookClient {

    /**
     * @var \Facebook\Facebook
     */
    private $fb;
    private $fullRoot;
    private $appId;
    private $groupId;
    private $botToken;

    /**
     * FacebookClient constructor.
     * @param \Facebook\Facebook $fb
     * @param $fullRoot
     * @param $appId
     * @param $groupId
     * @param $botToken
     */
    public function __construct(\Facebook\Facebook $fb, $fullRoot, $appId, $groupId, $botToken) {
        $this->fb = $fb;
        $this->fullRoot = $fullRoot;
        $this->appId = $appId;
        $this->groupId = $groupId;
        $this->botToken = $botToken;
    }

    public function getLoginUrl() {
        $helper = $this->fb->getRedirectLoginHelper();

        $rawLoginUrl = $helper->getLoginUrl($this->fullRoot . 'login.php');
        return htmlspecialchars($rawLoginUrl);
    }

    public function getGroupUrl() {
        return "https://www.facebook.com/groups/$this->groupId";
    }

    /**
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function login() {
        $helper = $this->fb->getRedirectLoginHelper();
        $accessToken = $this->getAccessToken($helper);

        $oAuth2Client = $this->fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $tokenMetadata->validateAppId($this->appId);
        $tokenMetadata->validateExpiration();

        $accessToken = $this->makeLongLivedIfNeeded($accessToken, $oAuth2Client);

        $_SESSION['fb_access_token'] = (string)$accessToken;

        header('Location: post.php');
    }

    public function publish() {
        try {
            $this->fb->post(
                '/' . $this->groupId . '/feed',
                ['message' => $_POST["message"]],
                $this->botToken
            );
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        header("Location: done.php");
    }

    /**
     * @param $helper \Facebook\Helpers\FacebookRedirectLoginHelper
     * @return \Facebook\Authentication\AccessToken|null
     */
    private function getAccessToken($helper) {
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            header("Location: error.php");
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            header("Location: error.php");
            exit;
        }

        if (!isset($accessToken)) {
            header("Location: error.php");
            exit;
        }

        return $accessToken;
    }

    /**
     * @param $accessToken \Facebook\Authentication\AccessToken
     * @param $oAuth2Client \Facebook\Authentication\OAuth2Client
     * @return \Facebook\Authentication\AccessToken
     */
    private function makeLongLivedIfNeeded($accessToken, $oAuth2Client) {
        $longLivedToken = $accessToken;
        if (!$accessToken->isLongLived()) {
            try {
                $longLivedToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                header("Location: error.php");
                exit;
            }
        }

        return $longLivedToken;
    }
}