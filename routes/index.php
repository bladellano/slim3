<?php

use function src\basicAuth;
use function src\jwtAuth;
use function src\slimConfiguration;

use App\Controllers\AuthController;
use App\Controllers\ProdutoController;
use App\Controllers\LojaController;
use App\Middlewares\JwTDateTimeMiddleware;
use Slim\Middleware\HttpBasicAuthentication;
use Tuupola\Middleware\JwtAuthentication;
 
$app = new \Slim\App(slimConfiguration());

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('App/Views', [
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

//=======================================================

$app->post('/login', AuthController::class . ':login');

//=======================================================

$app->post('/refresh-token', AuthController::class . ':refreshToken');

//=======================================================

$app->get('/teste', function () {echo 'Entrou...';})
->add(new JwTDateTimeMiddleware())
->add(jwtAuth());

//=======================================================
$app->get('/', function ($req, $res, $args) {
    return $this->view->render($res, 'index.html');
});
//=======================================================

$app->get('/loja', LojaController::class . ':getLojas')
    ->add(basicAuth());

$app->post('/loja', LojaController::class . ':insertLoja');
$app->put('/loja', LojaController::class . ':updateLoja');
$app->delete('/loja', LojaController::class . ':deleteLoja');

//=======================================================

$app->get('/produto', ProdutoController::class . ':getProdutos');
$app->post('/produto', ProdutoController::class . ':insertProduto');
$app->put('/produto', ProdutoController::class . ':updateProduto');
$app->delete('/produto', ProdutoController::class . ':deleteProduto');

//=======================================================

$app->run();
