<?php
require_once 'init.php';
$guard->authorize();
$renderer->renderStart();
?>
    <form action="publish.php" method="post">
        <div class="form-group">
            <label for="message">Tvoja správa, ktorú chceš poslať anonymne</label>
            <textarea class="form-control" rows="3" id="message" name="message"></textarea>
        </div>
        <button type="submit" class="btn btn-social btn-lg btn-facebook pull-right">
            <span class="fab fa-facebook"></span> Postni to!
        </button>
    </form>

<?php
$renderer->renderEnd();
