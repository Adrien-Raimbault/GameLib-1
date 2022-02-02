<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_ALL, '');

spl_autoload_register(function ($className) {
    include './classes/' . $className . '.php';
});

$test = new Test;

require_once './functions/autoLoadFunction.php';
require_once './includes/head.php';
require_once './includes/main.php';
require_once './includes/footer.php';
