<?php
require_once 'init.php';
$guard->authorize();
$renderer->renderStart();
?>
    <div class="alert alert-success" role="alert">
        Úspešne odoslané. Svoj anonymný príspevok si môžeš pozrieť
        <a href="<?php echo $facebookClient->getGroupUrl() ?>" class="alert-link">
            v našej skupine</a>.
    </div>
    <p class="text-center">
        <a href="post.php" class="btn btn-primary">Poslať ešte jednu</a>
    </p>
<?php
$renderer->renderEnd();