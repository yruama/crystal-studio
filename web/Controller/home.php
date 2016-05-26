<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->match('/', function () use ($app) {

    return $app['twig']->render('Sources/base.html.twig');
});

$app->match('/contact/', function (Request $request) use ($app) {

	$name = $request->get('name');
	$mail = $request->get('mail');
	$message = $request->get('text');

	ini_set("sendmail_from","contact@yruama.fr");
	mail('contact@yruama.fr', 'Crystal Studio : ' . $name, $message . "  ------ <br>" . $mail);

    return $app['twig']->render('Sources/base.html.twig');
});

$app->match('/blog/', function () use ($app) {

    return $app['twig']->render('Sources/blog.html.twig');
});