<?php

require_once __DIR__.'./../vendor/autoload.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Application\SecurityTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Form\Form as Form;
use Entities\User;
use Entities\Admin;
use Lib\Crop;

class MyApplication extends Application
{
	use Application\TwigTrait;
	use Application\SecurityTrait;
	use Application\FormTrait;
	use Application\UrlGeneratorTrait;
	use Application\SwiftmailerTrait;
	use Application\MonologTrait;
	use Application\TranslationTrait;
}

$app = new Silex\Application();
$app['debug'] = true;

$dbCredentials = array(
	'db.options' => array(
    'driver'	=> 'pdo_mysql',
    'dbname'    => 'sycen',
    'host'		=> 'localhost',
    'user'		=> 'root',
    'password'	=> '',
    'charset'	=> 'utf8'
));

$app['image_games_path'] = __DIR__ . '/../web/Ressources/img/games/';

$app->register(new Silex\Provider\DoctrineServiceProvider(), $dbCredentials);

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('fr'),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__.'./../web/Sources',
));

$app->register(new FormServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\RememberMeServiceProvider());
$app['security.firewalls'] = array(
    'secured' => array(
        'pattern' => '^/',
        'anonymous' => true,
        'form' => array(
			'login_path' => '/login',
            'check_path' => 'login',
            'default_target_path' => '/', 
            'target_path_parameter' => $app['session']->get('_security.secured.target_path')
		),
		'logout' => array(
			'logout_path' => '/logout'
		),
        'remember_me' => array(
            'key'                => '%sycen%',
            'always_remember_me' => true
        ),
		'users' => $app->share(function() use ($app) {
			return new Lib\UserProvider($app['db']);
		})
	)
);

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $user = new Entities\User($app['db']); 
    $admin = new Entities\Admin($app['db']);
	$token = $app['security']->getToken(); 
    $userToken = $token->getUser();

    if ($userToken != 'anon.')
    {
        $userInfos = $user->searchByLogin($userToken->getUsername());
    	$twig->addGlobal('user', $userInfos);
    	$twig->addGlobal('anon', false);
    }
    else 
    {
    	$twig->addGlobal('user', '');
    	$twig->addGlobal('anon', true);
    }

    $app['plateforme'] = $admin->getPlateforme();
    $twig->addGlobal('plateforme', $app['plateforme']);


    return $twig;
}));

$app['security.role_hierarchy'] = array('ROLE_ADMIN' => array('ROLE_USER'), 'ROLE_USER' => array('IS_AUTHENTICATED_REMEMBERED'));

$app['security.access_rules'] =  array(
	array('^/', 'IS_AUTHENTICATED_ANONYMOUSLY')
);




/*
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
   
    $token = $app['security']->getToken(); 
    if (is_null($token)) {
        return $twig;
    }
    $user = $token->getUser();
    $user = $app['session']->get('user');
    if ($user != 'anon.') {
        $userEntitie = new Entities\User($app['db']);
        $twig->addGlobal('userInfo', $userEntitie->searchByLogin($user['username']));
        $twig->addGlobal('anonymous', false);

        if (!$app['session']->get('user_info')) {
            $app['session']->set('user_info', $userEntitie->searchByLogin($user['username']));
        }
    }
    else {
    	$twig->addGlobal('anonymous', true);
    }
    return $twig;
}));*/

$app->boot();

?>