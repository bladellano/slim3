<?php

use function src\slimConfiguration;

use App\Controllers\AuthController;
use App\Controllers\ProdutoController;
use App\Controllers\LojaController;
use Slim\Middleware\HttpBasicAuthentication;

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

$app->post('/login',AuthController::class.':login');
//=======================================================
$app->get('/', function ($req, $res, $args) {
    return $this->view->render($res, 'index.html');
});
//=======================================================

$app->get('/loja', LojaController::class . ':getLojas')
    ->add(new HttpBasicAuthentication([
        "users" => array(
            "root" => "teste123"
        )
    ]));

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
