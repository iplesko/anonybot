<?php
require_once 'init.php';

$renderer->renderStart();
?>
    <div class="alert alert-danger" role="alert">
        Nastala chyba pri prihlasovaní.
    </div>
    <p class="text-center">
        <a href="post.php" class="btn btn-primary">Skúsiť znova</a>
    </p>
<?php
$renderer->renderEnd();
