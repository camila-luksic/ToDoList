<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/src/controllers/todo.controller.php';


$app = AppFactory::create();
$app->setBasePath('/todoApp/public'); 
$app->addBodyParsingMiddleware();

$controller = new TodoController();

// Rutas
$app->get('/todos', function(Request $request, Response $response) use ($controller) {
    $result = $controller->getAll();
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/todos', function(Request $request, Response $response) use ($controller) {
    $data = $request->getParsedBody();
    $result = $controller->create($data);
    $status = $result['message'] === "To do was created." ? 201 : 503;
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
});

$app->put('/todos/{id}', function(Request $request, Response $response, $args) use ($controller) {
    $id = $args['id'];
    $data = $request->getParsedBody();
    $result = $controller->update($id, $data);
    $status = $result['message'] === "To do was updated." ? 200 : 503;
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
});

$app->delete('/todos/{id}', function(Request $request, Response $response, $args) use ($controller) {
    $id = $args['id'];
    $result = $controller->delete($id);
    $status = $result['message'] === "To do was deleted." ? 200 : 503;
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
});

$app->run();
