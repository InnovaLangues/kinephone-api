<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/classes/KineException.php';
require_once __DIR__ . '/../app/classes/KineConstant.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

$pdo = new PDO('mysql:host=localhost;dbname=kinephone1', "user", "pass");

// default parameters
$defaults = array(
    'limit' => '10',
    'offset' => '0'
);

/**
 * Register monolog services to handle log writing
 */
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../app/logs/kinephone.log',
    'monolog.level' => Monolog\Logger::ERROR,
));

// get params for a given table id
$app->get('/kinephones/tables/{id}/params', function(Request $request, $id) use ($app, $pdo) {
    $sql = "SELECT *
            FROM kine_param 
            WHERE kine_param.kine_table_id = {$id}";

    $statement = $pdo->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $entity = new stdClass();
    $entity->id = (int) $results[0]['id'];
    $entity->tableId = (int) $results[0]['kine_table_id'];
    $entity->name = (string) $results[0]['name'];
    $entity->showImage = (boolean) $results[0]['show_image'];
    $entity->showColor = (boolean) $results[0]['show_color'];
    $entity->showWord = (boolean) $results[0]['show_word'];
    $entity->showSentence = (boolean) $results[0]['show_sentence'];
    $entity->showPhonem = (boolean) $results[0]['show_phonem'];
    $entity->showPhonemSound = (boolean) $results[0]['show_phonem_sound'];
    $entity->showWordSound = (boolean) $results[0]['show_word_sound'];
    $entity->showSentenceSound = (boolean) $results[0]['show_sentence_sound'];

    $data = json_encode($entity, JSON_PRETTY_PRINT);
    $pdo = null;
    return new Response($data, 200, array('ContentType' => 'application/json'));
});

// update param
$app->put('/kinephones/tables/{tid}/params/{pid}', function(Request $request) use ($app, $pdo) {
    try {
        $payload = json_decode($request->getContent());
        $param = new stdClass();
        $param->id = $payload->id;
        $param->tableId = $payload->tableId;
        $param->showColor = $payload->showColor ? 1 : 0;
        $param->showImage = $payload->showImage ? 1 : 0;
        $param->showWord = $payload->showWord ? 1 : 0;
        $param->showPhonem = $payload->showPhonem ? 1 : 0;
        $param->showSentence = $payload->showSentence ? 1 : 0;
        
        $param->showWordSound = $payload->showWordSound ? 1 : 0;
        $param->showPhonemSound = $payload->showPhonemSound ? 1 : 0;
        $param->showSentenceSound = $payload->showSentenceSound ? 1 : 0;
        
        $sql = "    UPDATE kine_param "
                . " SET show_color="            . $param->showColor         . ", "
                . "     show_image="            . $param->showImage         . ","
                . "     show_word="             . $param->showWord          . ","
                . "     show_phonem="           . $param->showPhonem        . ","
                . "     show_sentence="         . $param->showSentence      . ","
                . "     show_word_sound="       . $param->showWordSound     . ","
                . "     show_phonem_sound="     . $param->showPhonemSound   . ","
                . "     show_sentence_sound="   . $param->showSentenceSound . ""
                . " WHERE id="                  . $param->id;
        
        $statement = $pdo->prepare($sql);
        $statement->execute();
        
        return new Response(json_encode($param), 200, array('ContentType' => 'application/json'));        
    } catch (Exception $ex) {
        $app['monolog']->addError("EXCEPTION :: " . $ex->getMessage() . " " . $ex->getTrace());
        return new Response("Error", 400);
    }
});

// get available languages
$app->get('/kinephones/languages', function(Request $request) use ($app, $pdo) {
    try {
        $sql = "SELECT l.id AS language_id, l.name AS language_name
		FROM kine_language l";

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $data = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
        return new Response($data, 200, array('ContentType' => 'application/json'));
    } catch (Exception $ex) {
        $app['monolog']->addError("EXCEPTION :: " . $ex->getMessage() . " " . $ex->getTrace());
        return new Response("Error", 400);
    }
});

// tables per language
$app->get('/kinephones/languages/{lid}/tables', function(Request $request, $lid) use ($app, $pdo) {

    try {
        $sql = "SELECT t.id AS table_id, t.name AS table_name, t.image_url
		FROM kine_table t 
		WHERE t.kine_language_id = {$lid}";

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $data = json_encode($results, JSON_PRETTY_PRINT);

        $pdo = null;
        return new Response($data, 200, array('ContentType' => 'application/json'));
    } catch (Exception $ex) {
        $app['monolog']->addError("EXCEPTION :: " . $ex->getMessage() . " " . $ex->getTrace());
        return new Response("Error", 400);
    }
});

// ENTITY BY LANGUAGE AND TABLE IDs
$app->get('/kinephones/languages/{lid}/table/{tid}/items', function (Request $request, $lid, $tid) use ($app, $pdo, $defaults) {
    // result
    $entity = new stdClass();

    try {

        $sql = " SELECT l.*, t.id AS id_table, t.name, t.image_url
		FROM kine_language l
		JOIN kine_table t ON t.kine_language_id = l.id
		WHERE l.id = {$lid} AND t.id = {$tid}
		LIMIT :limit OFFSET :offset";

        $statement = $pdo->prepare($sql);

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
            sprintf(KineException::KEXCEPTION_NO_LANGUAGE_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_LANGUAGE_CODE
            );
        }

        // entity main data
        $entity->language_id = (int) $results[0]['id'];
        $entity->code_iso = (string) $results[0]['code_iso_639'];
        $entity->code_unicode = (string) $results[0]['code_unicode_api'];
        $entity->table_id = (int) $results[0]['id_table'];
        $entity->name = (string) $results[0]['name'];
        $entity->image = (string) $results[0]['image_url'];

        // items related to entity
        $entity->items = array();

        $sql = "SELECT * FROM kine_item where kine_table_id = {$tid}";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$items) {
            throw new KineException(
            sprintf(KineException::KEXCEPTION_NO_ITEMS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_ITEMS_CODE
            );
        }

        // get params for the selected table
        $sql = " SELECT p.* 
        FROM kine_param p
        WHERE p.kine_table_id = {$entity->table_id}";

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $params = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$params) {
            throw new KineException(
            sprintf(KineException::KEXCEPTION_NO_PARAMS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_PARAMS_CODE
            );
        }

        $showImage = (boolean) $params[0]['show_image'];
        $showColor = (boolean) $params[0]['show_color'];
        $showWord = (boolean) $params[0]['show_word'];
        $showSentence = (boolean) $params[0]['show_sentence'];
        $showPhonem = (boolean) $params[0]['show_phonem'];
        $showPhonemSound = (boolean) $params[0]['show_phonem_sound'];
        $showWordSound = (boolean) $params[0]['show_word_sound'];
        $showSentenceSound = (boolean) $params[0]['show_sentence_sound'];

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

            if ($showPhonemSound || $showSentenceSound || $showWordSound) {
                // sounds query
                $sql = "SELECT * FROM kine_sound WHERE kine_item_id = {$itemId} AND sound_type = ( 'all' ";
                if ($showPhonemSound) {
                    $sql .= " OR '" . KineConstant::SOUND_TYPE_PHONEM . "'";
                }
                if ($showSentenceSound) {
                    $sql .= " OR '" . KineConstant::SOUND_TYPE_SENTENCE . "'";
                }
                if ($showSentenceSound) {
                    $sql .= " OR '" . KineConstant::SOUND_TYPE_WORD . "'";
                }

                $sql .= " )";

                $statement = $pdo->prepare($sql);
                $statement->execute();
                $sounds = $statement->fetchAll(PDO::FETCH_ASSOC);

                if (!$sounds) {
                    throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_SOUNDS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_SOUNDS_CODE
                    );
                }

                // create item sounds array
                foreach ($sounds as $sound) {
                    $itemSounds->sounds[] = array(
                        'id' => (int) $sound['id'],
                        'type' => (string) $sound['sound_type'],
                        'url' => (string) $sound['url'],
                        'gender' => (string) $sound['gender']
                    );
                }
            }

            if ($showColor || $showImage) {
                // images query
                $sql = "SELECT * FROM kine_image WHERE kine_item_id = {$itemId} AND image_type = ( 'all' ";
                if ($showColor) {
                    $sql .= " OR '" . KineConstant::IMAGE_TYPE_COLOR . "'";
                }
                if ($showImage) {
                    $sql .= " OR '" . KineConstant::IMAGE_TYPE_DRAWING . "'";
                }
                $sql .= " )";

                $statement = $pdo->prepare($sql);
                $statement->execute();
                $images = $statement->fetchAll(PDO::FETCH_ASSOC);

                if (!$images) {
                    throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_IMAGES_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_IMAGES_CODE
                    );
                }

                // create item images array
                foreach ($images as $image) {
                    $itemImages->images[] = array(
                        'id' => (int) $image['id'],
                        'image_type' => (string) $image['image_type'],
                        'url' => (string) $image['url']
                    );
                }
            }

            if ($showWord || $showSentence || $showPhonem) {
                // texts query
                $sql = "SELECT * FROM kine_text where kine_item_id = {$itemId} AND text_type = ( 'all' ";
                if ($showWord) {
                    $sql .= " OR '" . KineConstant::TEXT_TYPE_WORD . "'";
                }
                if ($showSentence) {
                    $sql .= " OR '" . KineConstant::TEXT_TYPE_SENTENCE . "'";
                }
                if ($showPhonem) {
                    $sql .= " OR '" . KineConstant::TEXT_TYPE_PHONETIC . "'";
                }
                $sql .= " )";

                $statement = $pdo->prepare($sql);
                $statement->execute();
                $texts = $statement->fetchAll(PDO::FETCH_ASSOC);

                if (!$texts) {
                    throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_TEXTS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_TEXTS_CODE
                    );
                }

                // create item texts array
                foreach ($texts as $text) {
                    $itemTexts->texts[] = array(
                        'id' => (int) $text['id'],
                        'text_type' => (string) $text['text_type'],
                        'text' => (string) utf8_encode($text['text'])
                    );
                }
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
        return new Response($data, 200, array('ContentType' => 'application/json'));
    } catch (PDOException $pdoe) {
        $app['monolog']->addError("PDO ERROR :: " . $pdoe->getMessage() . " " . $pdoe->getTrace());
        return new Response(null, 400);
    } catch (KineException $ke) {
        $app['monolog']->addError("KINEPHONE ERROR :: " . $ke->getMessage() . " WITH CODE :: " . $ke->getCode());
        return new Response(null, 404);
    }
});

$app->run();
