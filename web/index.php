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

// ENTITY ID //
$app->get('/entity/{id}', function (Request $request, $id) use ($pdo, $defaults) {

    $entity = new stdClass();

    try {
        $statement = $pdo->prepare("SELECT *, method.id as id_method FROM language, method where language.id = {$id} and method.language_id = language.id LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Données de l'entité
        $entity->language_id = (int) $results[0]['id'];
        $entity->code_iso = (string) $results[0]['code_iso_639'];
        $entity->code_unicode = (string) $results[0]['code_unicode_api'];
        $entity->method_id = (int) $results[0]['id_method'];
        $entity->name = (string) $results[0]['name'];
        $entity->image = (string) $results[0]['image_url'];

        // Tableau des données des items
        $entity->items = array();

        $statementItem = $pdo->prepare("SELECT * FROM item where method_id = {$entity->method_id} LIMIT :limit OFFSET :offset");
        $statementItem->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statementItem->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statementItem->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statementItem->execute();
        $resultsItem = $statementItem->fetchAll(PDO::FETCH_ASSOC);

        $entity->items[] = array(
            'id'     => (int)    $resultsItem[0]['id'],
            'coords' => (string) $resultsItem[0]['coords'],
            'sounds[]' => array(
                )
            );


        $sound = new stdClass();

        // Ici, je parcours les items.
        // Maintenant, faut que je parcours les tables "sound", "image", "text" sur l'item en cours
        foreach ($resultsItem as $rowItem){
            // Extraction du numéro de l'item
            $itemId = (int) $rowItem['id'];

            //
            // Parcours de la table "sounds"
            $sql = "SELECT * FROM sound where item_id = {$itemId} LIMIT :limit OFFSET :offset";

            $statementSound = $pdo->prepare($sql);
            $statementSound->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

            if ($request->query->get('offset')) {
                $statementSound->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
            }
            else {
                $statementSound->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
            }

            $statementSound->execute();
            $resultsSound = $statementSound->fetchAll(PDO::FETCH_ASSOC);

            //
            // Boucle sur les sounds
            foreach ($resultsSound as $rowSound){
                // Extraction des données
                $soundId = (int) $rowSound['id'];
                $soundType = (string) $rowSound['sound_type'];
                $soundUrl = (string) $rowSound['url'];
                $soundGender = (string) $rowSound['gender'];
                $soundVisible = (boolean) $rowSound['visible'];


                //$entity->items[] = array();

                $entity->items[]->sounds = array(
                        'id'   => (int) $rowSound['id'],
                        'type' => (string) $rowSound['sound_type']
                    );

            }


            //
            // Parcours de la table "image"
            $sql = "SELECT * FROM image where item_id = $itemId LIMIT :limit OFFSET :offset";
            $statementImage = $pdo->prepare($sql);
            $statementImage->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

            if ($request->query->get('offset')) {
                $statementImage->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
            }
            else {
                $statementImage->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
            }

            $statementImage->execute();
            $resultsImage = $statementImage->fetchAll(PDO::FETCH_ASSOC);

            //
            // Boucle sur les images
            foreach ($resultsImage as $rowImage){
            }


            //
            // Parcours de la table "text"
            $sql = "SELECT * FROM text where item_id = $itemId LIMIT :limit OFFSET :offset";
            $statementtext = $pdo->prepare($sql);
            $statementtext->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

            if ($request->query->get('offset')) {
                $statementtext->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
            }
            else {
                $statementtext->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
            }

            $statementtext->execute();
            $resultstext = $statementtext->fetchAll(PDO::FETCH_ASSOC);

            //
            // Boucle sur les textes
            foreach ($resultstext as $rowtext){
            }


        }




























        $entity = json_encode($entity, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $entity = "Erreur !: " . $e->getMessage();
    }

    print_r($entity);
    die();

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

$app->run();
