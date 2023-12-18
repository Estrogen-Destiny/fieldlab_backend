<?php

// Include connection file
require 'conn.php';

// Set up Slim app
$basePath = '/david_api';

// Parse the request URI to get the route
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$trimmedUri = rtrim($requestUri, '/');
$basePathLength = strlen($basePath);

// Check if the request starts with the base path
if (strncmp($trimmedUri, $basePath, $basePathLength) !== 0) {
    http_response_code(404);
    exit();
}

// Remove the base path from the request URI
$trimmedUri = substr($trimmedUri, $basePathLength);

// Define API routes
if (strpos($trimmedUri, '/kamers') === 0) {
    // Get the HTTP method (GET, POST, PUT, DELETE)
    $method = $_SERVER['REQUEST_METHOD'];

    // Get the endpoint
    $endpoint = substr($trimmedUri, strlen('/kamers'));

    // Get request data
    $data = json_decode(file_get_contents('php://input'), true);

    // Route handling
    switch ($method) {
        case 'GET':
            $stmt = $conn->prepare('SELECT * FROM kamer_info');
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($result);
            break;
            
        case 'POST':
            $stmt = $conn->prepare('INSERT INTO kamer_info (name, location, foto, informatie_kamer, faciliteiten, beschikbaarheid, kamer_spec, maximum_guests, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$data['name'], $data['location'], $data['foto'], $data['informatie_kamer'], $data['faciliteiten'], $data['beschikbaarheid'], $data['kamer_spec'], $data['maximum_guests'], $data['type']]);
            
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode($data);
            break;

        case 'PUT':
            $id = ltrim($endpoint, '/');
            $stmt = $conn->prepare('UPDATE kamer_info SET name=?, location=?, foto=?, informatie_kamer=?, faciliteiten=?, beschikbaarheid=?, kamer_spec=?, maximum_guests=?, type=? WHERE id=?');
            $stmt->execute([$data['name'], $data['location'], $data['foto'], $data['informatie_kamer'], $data['faciliteiten'], $data['beschikbaarheid'], $data['kamer_spec'], $data['maximum_guests'], $data['type'], $id]);
            
            header('Content-Type: application/json');
            echo json_encode($data);
            break;

        case 'DELETE':
            $id = ltrim($endpoint, '/');
            $stmt = $conn->prepare('DELETE FROM kamer_info WHERE id=?');
            $stmt->execute([$id]);
            
            http_response_code(204);
            break;

        default:
            http_response_code(405);
            break;
    }
} else {
    http_response_code(404);
}
