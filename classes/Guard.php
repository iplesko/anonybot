<?php

class Guard {
    /**
     * @var \Facebook\Facebook
     */
    private $fb;
    private $groupId;
    private $botToken;

    public function __construct($fb, $groupId, $botToken) {
        $this->fb = $fb;
        $this->groupId = $groupId;
        $this->botToken = $botToken;
    }

    public function assertLogin() {
        if (!isset($_SESSION['fb_access_token'])) {
            header("Location: index.php");
            exit;
        }
    }

    /**
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function authorize() {
        $this->assertLogin();

        $allowedUserIdArray = $this->getGroupMembers();
        $currentUserId = $this->getCurrentUserId();
        $this->assertUserIdIsInAllowed($currentUserId, $allowedUserIdArray);
    }

    /**
     * @return array
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    private function getGroupMembers() {
        $response = $this->fb->get("/$this->groupId/members", $this->botToken);
        $allowedUserIdArray = array_map(
            $this->getId(),
            $response->getDecodedBody()["data"]
        );
        return $allowedUserIdArray;
    }

    private function getId() {
        return function ($item) {
            return $item["id"];
        };
    }

    /**
     * @return mixed
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    private function getCurrentUserId() {
        $currentUserIdResponse = $this->fb->get("/me", $_SESSION['fb_access_token']);
        $currentUserId = $currentUserIdResponse->getDecodedBody()["id"];
        return $currentUserId;
    }

    /**
     * @param $currentUserId
     * @param $allowedUserIdArray
     */
    private function assertUserIdIsInAllowed($currentUserId, $allowedUserIdArray) {
        if (!in_array($currentUserId, $allowedUserIdArray)) {
            header("Location: deny.php");
            exit;
        }
    }
}
