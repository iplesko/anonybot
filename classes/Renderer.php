<?php

class Renderer {
    public function renderStart() {
        include 'template/start.php';
    }

    public function renderEnd() {
        include 'template/end.php';
    }
}
