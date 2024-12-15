<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/api/users', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM plans";
    
    try {
        $db = new DB();
        $db = $db->connectDB();
        
        // Execute the query and fetch the results
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        // Write the results to the response body
        $response->getBody()->write(json_encode($users));
        
        // Return the response
        return $response->withHeader('Content-Type', 'application/json');
        
    } catch (PDOException $e) {
        $error = array('error' => array('text' => $e->getMessage()));
        $response->getBody()->write(json_encode($error));
        
        // Return the response with a 500 status code
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});


// get single user

$app->get('/api/user/{id}', function (Request $request, Response $response, array $args) {
    // $id = $args['id'];
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM users WHERE id = $id";
    
    try {
        $db = new DB();
        $db = $db->connectDB();
        
        // Execute the query and fetch the results
        $stmt = $db->query($sql);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        
        // Write the results to the response body
        $response->getBody()->write(json_encode($user));
        
        // Return the response
        return $response->withHeader('Content-Type', 'application/json');
        
    } catch (PDOException $e) {
        $error = array('error' => array('text' => $e->getMessage()));
        $response->getBody()->write(json_encode($error));
        
        // Return the response with a 500 status code
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

// add user 
$app->post('/api/user/add', function (Request $request, Response $response) {
    $parsedBody = $request->getParsedBody();
    $name = $parsedBody['name'];
    $price_id = $parsedBody['price_id'];

    
    $sql = "INSERT INTO plans (name, price_id) VALUES (:name,:price_id)";
    
    try {
        $db = new DB();
        $db = $db->connectDB();
        
        // Execute the query and fetch the results
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price_id', $price_id);

        $stmt->execute();
        
        $response->getBody()->write('{"notice": {"text": "User added"}}');
        
        // Return the response
        return $response->withHeader('Content-Type', 'application/json');
        
    } catch (PDOException $e) {
        $error = array('error' => array('text' => $e->getMessage()));
        $response->getBody()->write(json_encode($error));
        
        // Return the response with a 500 status code
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

// update user
$app->put('/api/user/update/{id}', function (Request $request, Response $response, array $args) {
    // $id = $args['id'];
    $id = $request->getAttribute('id');
    $parsedBody = $request->getParsedBody();
    $name = $parsedBody['name'];
    $price_id = $parsedBody['price_id'];

    $sql = "UPDATE plans SET name = :name, price_id = :price_id WHERE id = $id";
    
    try {
        $db = new DB();
        $db = $db->connectDB();
        
        // Execute the query and fetch the results
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price_id', $price_id);

        $stmt->execute();
        
        $response->getBody()->write('{"notice": {"text": "User updated"}}');
        
        // Return the response
        return $response->withHeader('Content-Type', 'application/json');
        
    } catch (PDOException $e) {
        $error = array('error' => array('text' => $e->getMessage()));
        $response->getBody()->write(json_encode($error));
        
        // Return the response with a 500 status code
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

// delete user
$app->delete('/api/user/delete/{id}', function (Request $request, Response $response, array $args) {
    // $id = $args['id'];
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM plans WHERE id = $id";
    
    try {
        $db = new DB();
        $db = $db->connectDB();
        
        // Execute the query and fetch the results
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        $response->getBody()->write('{"notice": {"text": "User deleted"}}');
        
        // Return the response
        return $response->withHeader('Content-Type', 'application/json');
        
    } catch (PDOException $e) {
        $error = array('error' => array('text' => $e->getMessage()));
        $response->getBody()->write(json_encode($error));
        
        // Return the response with a 500 status code
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});