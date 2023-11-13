<?php

// For this demo implementation a fixed data array is used
// In the actual implementation this data should be from the database
const PROPERTIES = [
    [
        'id' => 1,
        'name' => 'Beach House',
        'description' => 'A lovely beach house with a beautiful sea view.',
        'owner_id' => 1001,
        'location' => 'Malibu, California',
        'maximum_guests' => 5,
        'type' => 'House'
    ],
    [
        'id' => 2,
        'name' => 'Mountain Cabin',
        'description' => 'A cozy cabin in the mountains, perfect for a weekend getaway.',
        'owner_id' => 1002,
        'location' => 'Aspen, Colorado',
        'maximum_guests' => 4,
        'type' => 'House'
    ],
    // Additional properties can be added here
];


function createProperty($data)
{
    // Simulating database generated ID
    $newId = count(PROPERTIES) + 1;

    $newProperty = [
        'id' => $newId,
        'name' => $data['name'],
        'description' => $data['description'] ?? '', // Optional field
        'owner_id' => $data['owner_id'],
        'location' => $data['location'] ?? '', // Optional field
        'maximum_guests' => $data['maximum_guests'],
        'type' => $data['type']
    ];

    // In a real implementation, you would save this to a database
    // For this demo, just return the new property
    return $newProperty;
}


function returnJsonOfData($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        returnJsonOfData(PROPERTIES);
        break;
    
    case 'POST':
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $newProperty = createProperty($_POST);
            returnJsonOfData($newProperty);
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(['error' => 'Invalid json data']);
            exit();
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Method Not Allowed']);
        exit();
        break;
}