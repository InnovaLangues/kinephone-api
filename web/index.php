<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();
$app['debug'] = true;

$pdo = new PDO('mysql:host=localhost;dbname=kinephone', "kinephone", "kinephone");

$defaults = array(
    'limit'  => '10',
    'offset' => '0'
);

$output = '';

// ITEM //
$app->get('/item', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare('SELECT * FROM item LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->get('/item/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM item where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// IMAGE //
$app->get('/image', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM image LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->get('/image/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM image where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// LANGUAGE //
$app->get('/language', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM language LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->get('/language/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM language where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// SOUND //
$app->get('/sound', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM sound LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->get('/sound/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM sound where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// TEXT //
$app->get('/text', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM text LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->get('/text/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM text where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// METHOD //
$app->get('/method', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM method LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->get('/method/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM method where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->run();
