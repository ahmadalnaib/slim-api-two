<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/api/products', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM products";
    
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

$app->get('/api/product/{id}', function (Request $request, Response $response, array $args) {
    // $id = $args['id'];
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM products WHERE id = $id";
    
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
$app->post('/api/product/add', function (Request $request, Response $response) {
    // $parsedBody = $request->getParsedBody();
    $data = json_decode($request->getBody(), true);
    $title = $data['title'];


    
    $sql = "INSERT INTO products (title) VALUES (:title)";
    
    try {
        $db = new DB();
        $db = $db->connectDB();
        
        // Execute the query and fetch the results
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);


        $stmt->execute();
        
        $response->getBody()->write('{"notice": {"text": "Product added"}}');
        
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
$app->put('/api/product/update/{id}', function (Request $request, Response $response, array $args) {
    // $id = $args['id'];
    $id = $request->getAttribute('id');
    $data = json_decode($request->getBody(), true);
    $title = $data['title'];


    $sql = "UPDATE products SET title = :title WHERE id = $id";
    
    try {
        $db = new DB();
        $db = $db->connectDB();
        
        // Execute the query and fetch the results
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
       

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
$app->delete('/api/product/delete/{id}', function (Request $request, Response $response, array $args) {
    // $id = $args['id'];
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM products WHERE id = $id";
    
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