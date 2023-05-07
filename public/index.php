<?php
require __DIR__ . '/../vendor/autoload.php';

use Apps\Controller\Inscription\LoginController;
use Apps\Core\DebugHandler;
use Dotenv\Dotenv;
use Apps\Core\Controller\FastRouteCore;

// Gestion des fichiers environnement
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Couche Controller
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', 'Apps\Controller\HomeController');
    $route->addRoute('GET', '/inscription', 'Apps\Controller\Inscription\InscriptionController');
    $route->addRoute('GET', '/validation', 'Apps\Controller\Inscription\ValidationController');
    $route->addRoute('GET', '/lister', 'Apps\Controller\Questionnaire\ListController');
    $route->addRoute('GET', '/detail/{id:\d+}', 'Apps\Controller\Questionnaire\ViewController');
    $route->addRoute('GET', '/home', 'Apps\Controller\HomeController');
    $route->addRoute('GET', '/acceuil', 'Apps\Controller\Acceuil\AcceuilController');
    $route->addRoute('GET', '/testSendMail', 'Apps\Controller\Acceuil\TestSendMail');
    $route->addRoute(['GET','POST'],'/login', 'Apps\Controller\Inscription\LoginController');

});
// Dispatcher -> Couche view
echo FastRouteCore::getDispatcher($dispatcher);





