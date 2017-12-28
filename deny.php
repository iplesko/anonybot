<?php
require_once 'init.php';
$renderer->renderStart();
?>
    <div class="alert alert-danger" role="alert">
        Anonymne môžu prispievať len členovia
        <a href="<?php echo $facebookClient->getGroupUrl() ?>">skupiny</a>.
    </div>
    <p class="text-center">
        <a href="post.php" class="btn btn-primary">Skúsiť znova</a>
    </p>

<?php
$renderer->renderEnd();