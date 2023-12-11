<?php

require 'vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Set up database connection
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'stayNL',
    'user' => 'root',
    'password' => '',
];

$pdo = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}", $dbConfig['user'], $dbConfig['password']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Set up Slim app
$app = AppFactory::create();
$app->setBasePath('/david_api');

// Define API routes
$app->group('/kamers', function ($group) use ($pdo) {
    // Create a new room
    $group->post('', function (Request $request, Response $response) use ($pdo) {
        $data = $request->getParsedBody();

        $stmt = $pdo->prepare('INSERT INTO kamer_info (name, location, foto, informatie_kamer, faciliteiten, beschikbaarheid, kamer_spec, maximum_guests, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$data['name'], $data['location'], $data['foto'], $data['informatie_kamer'], $data['faciliteiten'], $data['beschikbaarheid'], $data['kamer_spec'], $data['maximum_guests'], $data['type']]);

        $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Update a room
    $group->put('/{id}', function (Request $request, Response $response, array $args) use ($pdo) {
        $data = $request->getParsedBody();
        $id = $args['id'];

        $stmt = $pdo->prepare('UPDATE kamer_info SET name=?, location=?, foto=?, informatie_kamer=?, faciliteiten=?, beschikbaarheid=?, kamer_spec=?, maximum_guests=?, type=? WHERE id=?');
        $stmt->execute([$data['name'], $data['location'], $data['foto'], $data['informatie_kamer'], $data['faciliteiten'], $data['beschikbaarheid'], $data['kamer_spec'], $data['maximum_guests'], $data['type'], $id]);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Delete a room
    $group->delete('/{id}', function (Request $request, Response $response, array $args) use ($pdo) {
        $id = $args['id'];

        $stmt = $pdo->prepare('DELETE FROM kamer_info WHERE id=?');
        $stmt->execute([$id]);

        return $response->withStatus(204);
    });
});

$app->run();
