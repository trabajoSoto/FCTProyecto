<?php
header('Content-Type: application/json');
require_once ('app.php');
$app = new App();
$app->run();

die();