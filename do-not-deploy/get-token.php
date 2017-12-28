<?php
require_once '../init.php';

$helper = $fb->getRedirectLoginHelper();

$permissions = ['publish_actions', 'manage_pages', 'publish_pages', 'user_managed_groups'];

$rawLoginUrl = $helper->getLoginUrl($FULL_ROOT.'do-get-token.php', $permissions);
$loginUrl = htmlspecialchars($rawLoginUrl);

?>
<a href="<?php echo $loginUrl?>">login</a>