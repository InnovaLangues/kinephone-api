<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/classes/KineException.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

$pdo = new PDO('mysql:host=localhost;dbname=kinephone', "user", "pass");

// default parameters
$defaults = array(
    'limit' => '10',
    'offset' => '0'
);



/**
 * Register monolog services to handle log writing
 */
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ .'/../app/logs/kinephone.log',
    'monolog.level' => Monolog\Logger::ERROR,
));

// ENTITY BY LANGUAGE AND METHOD IDs
$app->get('/kinephones/{lId}', function (Request $request, $lId) use ($app, $pdo, $defaults) {
    // result
    $entity = new stdClass();

    try {

        $sql = " SELECT l.*, m.id AS id_method, m.name, m.image_url
		FROM language l
		JOIN method m ON m.language_id = l.id
		WHERE l.id = {$lId} AND m.id = :method
		LIMIT :limit OFFSET :offset";

        $statement = $pdo->prepare($sql);
        
        $mId = -1;

        // method id param
        if ($request->query->get('method')) {
            $mId = (int) $request->query->get('method');
            $statement->bindValue(':method', (int) $request->query->get('method'), PDO::PARAM_INT);
        } else {            
            throw new KineException(
                KineException::KEXCEPTION_NO_METHOD_MESSAGE, KineException::KEXCEPTION_NO_METHOD_CODE
            );
        }

        // limits & offset params
        $limit = (int) $defaults['limit'];
        if ($request->query->get('limit')) {
            $limit = (int) $request->query->get('limit');
        }

        $offset = (int) $defaults['offset'];
        if ($request->query->get('offset')) {
            $offset = (int) $request->query->get('offset');
        }

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$results) {
            throw new KineException(
                sprintf(KineException::KEXCEPTION_NO_LANGUAGE_MESSAGE, $lId, $mId), KineException::KEXCEPTION_NO_LANGUAGE_CODE
            );
        }

        // entity main data
        $entity->language_id = (int) $results[0]['id'];
        $entity->code_iso = (string) $results[0]['code_iso_639'];
        $entity->code_unicode = (string) $results[0]['code_unicode_api'];
        $entity->method_id = (int) $results[0]['id_method'];
        $entity->name = (string) $results[0]['name'];
        $entity->image = (string) $results[0]['image_url'];

        // items related to entity
        $entity->items = array();

        $sql = "SELECT * FROM item where method_id = {$entity->method_id}";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$items) {
            throw new KineException(                    
                sprintf(KineException::KEXCEPTION_NO_ITEMS_MESSAGE, $lId, $mId), KineException::KEXCEPTION_NO_ITEMS_CODE
            );
        }

        // populate each item with his images / sounds / texts
        foreach ($items as $item) {

            // item id and coords
            $itemId = (int) $item['id'];
            $itemCoords = (string) $item['coords'];

            // sounds for each item
            $itemSounds = new stdClass();
            $itemSounds->sounds = array();

            // images for each item
            $itemImages = new stdClass();
            $itemImages->images = array();

            // texts for each item
            $itemTexts = new stdClass();
            $itemTexts->texts = array();

            // sounds query
            $sql = "SELECT * FROM sound where item_id = {$itemId}";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $sounds = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!$sounds) {
                throw new KineException(                        
                    sprintf(KineException::KEXCEPTION_NO_SOUNDS_MESSAGE, $lId, $mId), KineException::KEXCEPTION_NO_SOUNDS_CODE
                );
            }

            // create item sounds array
            foreach ($sounds as $sound) {
                $itemSounds->sounds[] = array(
                    'id' => (int) $sound['id'],
                    'type' => (string) $sound['sound_type'],
                    'url' => (string) $sound['url'],
                    'gender' => (string) $sound['gender'],
                    'visible' => (boolean) $sound['visible']
                );
            }

            // images query
            $sql = "SELECT * FROM image where item_id = {$itemId}";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $images = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            if (!$images) {
                throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_IMAGES_MESSAGE, $lId, $mId), KineException::KEXCEPTION_NO_IMAGES_CODE
                );
            }

            // create item images array
            foreach ($images as $image) {
                $itemImages->images[] = array(
                    'id' => (int) $image['id'],
                    'image_type' => (string) $image['image_type'],
                    'url' => (string) $image['url'],
                    'visible' => (boolean) $image['visible']
                );
            }

            // texts query
            $sql = "SELECT * FROM text where item_id = {$itemId}";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $texts = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            if (!$texts) {
                throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_TEXTS_MESSAGE, $lId, $mId), KineException::KEXCEPTION_NO_TEXTS_CODE
                );
            }

            // create item texts array
            foreach ($texts as $text) {
                $itemTexts->texts[] = array(
                    'id' => (int) $text['id'],
                    'text_type' => (string) $text['text_type'],
                    'text' => (string) $text['text'],
                    'visible' => (boolean) $text['visible']
                );
            }
            $entity->items[] = array(
                'id' => $itemId,
                'coords' => $itemCoords,
                'sounds' => $itemSounds->sounds,
                'images' => $itemImages->images,
                'texts' => $itemTexts->texts
            );
        }
        
        $data = json_encode($entity, JSON_PRETTY_PRINT);  
        $pdo = null;
        return new Response ($data, 200, array('ContentType' => 'application/json'));
        
    } catch (PDOException $pdoe) {
        $app['monolog']->addError("PDO ERROR :: " . $pdoe->getMessage() . " " . $pdoe->getTrace());
        return new Response(null, 400);
    } catch (KineException $ke) {
        $app['monolog']->addError("KINEPHONE ERROR :: " . $ke->getMessage() . " WITH CODE :: " . $ke->getCode());
        return new Response(null, 404);
    }    
});

$app->run();
