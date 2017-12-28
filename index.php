<?php
require_once 'init.php';
$renderer->renderStart();
?>
    <p class="text-center">
        <a href="<?php echo $facebookClient->getLoginUrl() ?>"
           class="btn btn-social btn-lg btn-facebook">
            <span class="fab fa-facebook"></span> Prihlásiť sa cez facebook</a>
    </p>

<?php
$renderer->renderEnd();
