<?php

$app->match('/', function () use ($app) {

    return $app['twig']->render('Sources/base.html.twig');
});
