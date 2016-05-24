<?php

$app->match('/', function () use ($app) {

    return $app['twig']->render('base.html.twig');
});
