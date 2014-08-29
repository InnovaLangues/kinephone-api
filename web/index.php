<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

$pdo = new PDO('mysql:host=localhost;dbname=kinephone', "kinephone", "kinephone");

// Paramêtres par défaut.
$defaults = array(
    'limit'  => '10',
    'offset' => '0'
);

$output = '';

//
// ITEM //
//
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

//
// IMAGE //
//
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

//
// LANGUAGE //
//
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

//
// SOUND //
//
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

//
// TEXT //
//
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

//
// METHOD //
//
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

//
// ENTITY ID //
//
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

        $sqlItem = "SELECT * FROM item where method_id = {$entity->method_id}";
        $statementItem = $pdo->prepare($sqlItem);
        $statementItem->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statementItem->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statementItem->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statementItem->execute();
        $resultsItem = $statementItem->fetchAll(PDO::FETCH_ASSOC);


        // Ici, je parcours les items.
        // Maintenant, faut que je parcours les tables "sound", "image", "text" sur l'item en cours
        foreach ($resultsItem as $rowItem){
            // Extraction du numéro de l'item
            $itemId = (int) $rowItem['id'];

            //
            // Parcours de la table "sound"
            //
            $sound = new stdClass();
            $sound->sounds = array(
            );
            $sqlSound = "SELECT * FROM sound where item_id = {$itemId}";

            $statementSound = $pdo->prepare($sqlSound);
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
                $sound->sounds[] = array(
                        'id'   => (int) $rowSound['id'],
                        'type' => (string) $rowSound['sound_type'],
                        'url' => (string) $rowSound['url'],
                        'gender' => (string) $rowSound['gender'],
                        'visible' => (boolean) $rowSound['visible']
                    );
            }

            //
            // Parcours de la table "image"
            //
            $image = new stdClass();
            $image->images = array(
            );
            $sqlImage = "SELECT * FROM image where item_id = {$itemId}";

            $statementImage = $pdo->prepare($sqlImage);
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
            // Boucle sur les Images
            foreach ($resultsImage as $rowImage){
                // Extraction des données
                $image->images[] = array(
                        'id'   => (int) $rowImage['id'],
                        'image_type' => (string) $rowImage['image_type'],
                        'url' => (string) $rowImage['url'],
                        'visible' => (boolean) $rowImage['visible']
                    );
            }

            //
            // Parcours de la table "text"
            //
            $text = new stdClass();
            $text->texts = array(
                );
            $sqlText = "SELECT * FROM text where item_id = {$itemId}";
            //echo "<br />" . $sqlText;
            $statementText = $pdo->prepare($sqlText);
            $statementText->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

            if ($request->query->get('offset')) {
                $statementText->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
            }
            else {
                $statementText->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
            }

            $statementText->execute();
            $resultsText = $statementText->fetchAll(PDO::FETCH_ASSOC);
            //
            // Boucle sur les Texts
            foreach ($resultsText as $rowText){

                // Extraction des données
                $text->texts[] = array(
                        'id'   => (int) $rowText['id'],
                        'text_type' => (string) $rowText['text_type'],
                        'text' => (string) $rowText['text'],
                        'visible' => (boolean) $rowText['visible']
                    );
            }

            $entity->items[] = array(
                'id'     => (int)    $resultsItem[0]['id'],
                'coords' => (string) $resultsItem[0]['coords'],
                'sounds' => $sound->sounds,
                'images' => $image->images,
                'texts'  => $text->texts
            );

            $output = json_encode($entity, JSON_PRETTY_PRINT);
            print_r($output);

        }

        $pdo = null;
    } catch (PDOException $e) {
        $entity = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

$app->run();
$stack = (new Stack\Builder())
    ->push('Silpion\Stack\Logger', array('logger' => new \Monolog\Logger('logger')))
;

$app = $stack->resolve($app);
$request = Request::create('/');
$response = $app->handle($request);
$app->terminate($request, $response);