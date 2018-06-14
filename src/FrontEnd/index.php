<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 26/07/2017
 * Time: 14:09
 */

require_once '../start.php';

use \Slim\Http\Request as Req;
use \Slim\Http\Response as Resp;
use \Slim\App;

use PmroPadraoLib\Controller\PessoaController;
use PmroPadraoLib\Controller\SetorController;
use PmroPadraoLib\Controller\AutenticacaoController;
use PmroPadraoLib\Util\Correios;
use PmroPadraoLib\Util\Utils;
use PmroPadraoLib\Controller\UtilController;

//instancia o slim
$app = new App;

// obtem um container
$container = $app->getContainer();

// Registra componente no container para abilitar o html render
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('Views', [
        'cache' => false
    ]);
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

function echoResponse(Resp $response,$jsonContent,$statusCode)
{
    //return $response->withStatus($statusCode)->withJson($content);
    /*return $response->withStatus($statusCode)
        ->write($jsonContent)
        ->withHeader('Content-type', 'application/json');*/

    $fh = fopen('php://memory', 'rw');
    $stream = new Slim\Http\Stream($fh);
    $stream->write($jsonContent);

    return $response->withStatus($statusCode)->withBody($stream)
        ->withHeader('Content-type', 'application/json');
}

// ROTAS DE WEB
// return HTTP 200 for HTTP OPTIONS requests para cross domain
/*$app->options('/:x+', function ($request,  $response, $args)
{
    return http_response_code(200);
});*/

$app->options('/{routes:.+}', function (Req $request,  Resp $response, $args) {
    return $response->withStatus(200);
});
$app->add(function ($req, $res, $next) {

    $response = $next($req, $res);
    $origin = $req->getHeader('Origin') ? $req->getHeader('Origin') : 'http://192.168.133.12';

    return $response
        ->withHeader('Access-Control-Allow-Credentials', 'true')
        ->withHeader('Access-Control-Allow-Origin', $origin)
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// WEBSERVICE
//pais
$app->get('/pais', function ($request,$response,$args)
{
    try
    {
        $result = json_encode(UtilController::getAllPaises());
        return echoResponse($response,$result,200);
    }
    catch (Exception $e)
    {
        $result =  json_encode(['mesage'=>'Ouve um erro']);
        return echoResponse($response,$result,400);
    }
});
//estado ufs
$app->post('/uf', function (Req $request,$response,$args) use ($app)
{
    try
    {
        $params = $request->getParsedBody();
        $result = json_encode(UtilController::getAllUFs($params));
        return echoResponse($response,$result,200);
    }
    catch (Exception $e)
    {
        $result = json_encode(array('code' => $e->getCode(), 'message' => $e->getMessage()));
        return echoResponse($response,$result,400);
    }
});
//municipios
$app->post('/municipio', function (Req $request,$response,$args) use ($app)
{
    try
    {
        $params = $request->getParsedBody();
        $result = json_encode(UtilController::getAllMunicipios($params));
        return echoResponse($response,$result,200);
    }
    catch (Exception $e)
    {
        $result = json_encode(array('code' => $e->getCode(), 'message' => $e->getMessage()));
        return echoResponse($response,$result,400);
    }
});

//OBTEM O ENDEREÇO POR CEP
$app->get('/correios/endereco/[{cep}]',function (Req $request, $response, $args) use ($app)
{
    try
    {
        $cep = $request->getAttribute('cep');
        $result = json_encode(UtilController::getEnderecoByCep($cep));
        return echoResponse($response,$result,200);
    }
    catch (Exception $e)
    {
        $result = json_encode(array('code' => $e->getCode(), 'message' => $e->getMessage()));
        return echoResponse($response,$result,400);
    }
});
//OBTEM UMA LISTA DE CEP COM BASE NO ENDEREÇO
$app->post('/correios/cep/',function (Req $request, $response, $args) use ($app)
{
    try
    {
        $params = $request->getParsedBody();
        $result = json_encode(UtilController::getCepByEndereco($params));
        return echoResponse($response,$result,200);
    }
    catch (Exception $e)
    {
        $result = json_encode(array('code' => $e->getCode(), 'message' => $e->getMessage()));
        return echoResponse($response,$result,400);
    }
});

$app->run();